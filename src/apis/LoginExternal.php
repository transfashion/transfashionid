<?php declare(strict_types=1);
namespace Transfashion\Transfashionid\apis;

use AgungDhewe\PhpLogger\Log;
use AgungDhewe\Webservice\Configuration;
use AgungDhewe\Webservice\WebApi;
use AgungDhewe\Webservice\Session;


use Transfashion\Transfashionid\KalistaApiConnector;

class LoginExternal extends WebApi {




	/**
	 * @ApiMethod
	 */
	public function ViaWhatsapp(array $payload) : array {
		$phone_number = array_key_exists('phone_number', $payload) ? $payload['phone_number'] : null;
		$message = array_key_exists('message', $payload) ? $payload['message'] : null;
		$from_name = array_key_exists('from_name', $payload) ? $payload['from_name'] : null;
		$intent = array_key_exists('intent', $payload) ? $payload['intent'] : null;

		// extract data
		$data = $this->parseLoginRequestMessage($message);
		$msg_intent = array_key_exists('intent', $data) ? $data['intent'] : null;
		$msg_ref = array_key_exists('ref', $data) ? $data['ref'] : null;



		
		$sessid = $msg_ref;
		session_id($sessid);
		session_start();
		
		$_SESSION['wa_number'] = $phone_number;
		$_SESSION['user_name'] = $from_name;
		$_SESSION['is_login'] = true;

		// balas wa nya
		return [
			"success" => true
		];

	}

	/**
	 * @ApiMethod
	 */
	public function RegisterKalistaSession(string $sessid) : array {
		if (Session::IsExists($sessid)) {
			if (session_status() !== PHP_SESSION_ACTIVE) {
				session_id($sessid);
				session_start();
			}
		} else {
			$errmsg = Log::error("Session is not valid");
			throw new \Exception($errmsg , 403);
		}

		// daftarkan ke kalista
		$kalistaConfig = Configuration::Get('Kalista');
		$url = $kalistaConfig['URL'];
		$appid = $kalistaConfig['AppId'];
		$secret = $kalistaConfig['AppSecret'];
		$apipath = "Transfashion/KalistaApi/Session/RegisterExternalSession";


		// Data yang akan dikirim
		$params = [
			"sessid" => $sessid
		];

		$api = new KalistaApiConnector($url, $appid, $secret);
		$result = $api->execute($apipath, $params);

	
		// // Mengonversi data menjadi JSON
		// $jsonData = json_encode($data);

		// // Inisialisasi cURL
		// $ch = curl_init($endpoint);

		// // Mengatur opsi cURL
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Menerima output sebagai string
		// curl_setopt($ch, CURLOPT_HEADER, true);         // Sertakan header dalam output
		// curl_setopt($ch, CURLOPT_NOBODY, false);        // Tetap sertakan body (ubah ke true jika hanya butuh header)
		// curl_setopt($ch, CURLOPT_POST, true); // Menggunakan metode POST
		// curl_setopt($ch, CURLOPT_HTTPHEADER, [
		// 	"Content-Type: application/json", // Header untuk JSON
		// 	"Content-Length: " . strlen($jsonData)
		// ]);
		// curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // Data yang dikirim

		// // Eksekusi cURL dan ambil responsnya
		// $response = curl_exec($ch);
		// Log::info($response);

		// $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE); // Ukuran header
		// $header = substr($response, 0, $header_size);           // Pisahkan header
		// $body = substr($response, $header_size);                // Pisahkan body (jika diperlukan)


		// $response = json_decode($body, true);
		// // Log::info($header);
		// // Log::info($body);

		return [
			"success" => true
		];
	}


	private function parseLoginRequestMessage(string $message) : array {
		$cleanedInput = str_replace("\n", " ", $message);
		$pattern = '/#([\w-]+)|\[(.*?)\]/';
		preg_match_all($pattern, $cleanedInput, $matches);
		$result = [];
		$result['intent'] = $matches[1][0] ?? null;
		$metadataString = $matches[2][1] ?? null;
		if ($metadataString) {
			preg_match_all('/(\w+):([\w-]+)/', $metadataString, $metaMatches, PREG_SET_ORDER);
			foreach ($metaMatches as $meta) {
				$result[$meta[1]] = $meta[2];
			}
		}
		return $result;
	}



}