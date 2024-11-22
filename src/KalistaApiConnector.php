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

	public final function execute(string $apipath, array $requestParameters, ?array $options = []) : array {
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
		Log::info($response);

		return [];
		// $dataResponse = json_decode($response, true);


	}
}

