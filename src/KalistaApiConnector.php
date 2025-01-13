<?php declare(strict_types=1);
namespace Transfashion\Transfashionid;

use AgungDhewe\PhpLogger\Log;


final class KalistaApiConnector {
	private string $_url;
	private string $_appid;
	private string $_secret;

	function __construct(string $url, string $appid, string $secret) {
		$this->_url = $url;
		$this->_appid = $appid;
		$this->_secret = $secret;
	}

	public final function execute(string $apipath, array $requestParameters, ?array $options = []) : ?array {
		$endpoint = join("/", [$this->_url, "api", $apipath]);

		// Data yang akan dikirim
		$txid = array_key_exists('txtid', $options) ? $options['txid'] : uniqid();
		$datetime = new \DateTime("now", new \DateTimeZone("UTC"));
		$data = [
			"txid" => $txid,
			"timestamp" => $datetime->format("Y-m-d\TH:i:s\Z"),
			"request" => $requestParameters
		];

		// Mengonversi data menjadi JSON
		$jsonData = json_encode($data);

		// buat code verifier
		$codeVerifier = hash_hmac('sha256', join(":", [$this->_appid, $jsonData]), $this->_secret);


		// siapkan curl
		$ch = curl_init($endpoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Menerima output sebagai string
		curl_setopt($ch, CURLOPT_HEADER, true);         // Sertakan header dalam output
		curl_setopt($ch, CURLOPT_NOBODY, false);        // Tetap sertakan body (ubah ke true jika hanya butuh header)
		curl_setopt($ch, CURLOPT_POST, true); // Menggunakan metode POST
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"Content-Type: application/json", // Header untuk JSON
			"App-Id: " . $this->_appid,
			"App-Secret: " . $this->_secret,
			"Code-Verifier: " . $codeVerifier,
			"Content-Length: " . strlen($jsonData)
		]);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // Data yang dikirim

		// Eksekusi cURL dan ambil responsnya
		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$httpHeader = substr($response, 0, $header_size);
		$jsonResponse = substr($response, $header_size);

		if ($httpCode !== 200) {
			$err = json_decode($jsonResponse, true);
			if (json_last_error()==JSON_ERROR_NONE) {
				$api_errormessage = array_key_exists('errormessage', $err) ? $err['errormessage'] : "error when execute $apipath";
				$errmsg = Log::error($api_errormessage);
				throw new \Exception($errmsg);
			} else {
				Log::error("HTTP error $httpCode when executing '$endpoint'");
				throw new \Exception($httpHeader);
			}
		}

		/*
		Format result:
		{
			"code":0,
			"errormessage":"",
			"response":{
				"success":true,
				"errormessage":"",
				"result":{
					"kalista_sessid":"c0d208f6f9e9901f162e9709fb86884e"
				}
			}
		}
		*/
		if (!$jsonResponse) {
			$errmsg = Log::error("Cannot connect to $endpoint");
			throw new \Exception($errmsg);
		}

		$data = json_decode($jsonResponse, true);
		if (json_last_error() !== JSON_ERROR_NONE) {
			$errmsg = Log::error("JSON error: " . json_last_error_msg());
			Log::info($jsonResponse);
			throw new \Exception($errmsg);
		}

		if (!array_key_exists('code', $data)) {
			$errmsg = "bad result from $apipath";
			throw new \Exception($errmsg);
		}

		if ($data['code'] !== 0) {
			$api_errormessage = array_key_exists('errormessage', $data) ? $data['errormessage'] : "error when execute $apipath";
			$errmsg = "error from $apipath: " . $api_errormessage ;
			throw new \Exception($errmsg);
		}

		if (!array_key_exists('response', $data)) {
			$errmsg = "bad result from $apipath";
			throw new \Exception($errmsg);
		}
	
		$response = $data['response'];
		return $response;
	}
}

