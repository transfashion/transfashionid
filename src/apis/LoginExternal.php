<?php declare(strict_types=1);
namespace Transfashion\Transfashionid\apis;

use AgungDhewe\PhpLogger\Log;
use AgungDhewe\Webservice\Configuration;
use AgungDhewe\Webservice\Service;
use AgungDhewe\Webservice\WebApi;
use AgungDhewe\Webservice\Session;
use AgungDhewe\Webservice\User;

use Transfashion\Transfashionid\KalistaApiConnector;

class LoginExternal extends WebApi {
	/**
	 * @ApiMethod
	 */
	public function RegisterKalistaSession(string $sessid) : array {
		Session::Start();

		// daftarkan ke kalista
		$kalistaConfig = Configuration::Get('Kalista');
		if (!$kalistaConfig) {
			$errmsg = Log::error("Configuration key 'Kalista' is not found config file");
			throw new \Exception($errmsg, 500);
		}

		$url = $kalistaConfig['URL'];
		$appid = $kalistaConfig['AppId'];
		$secret = $kalistaConfig['AppSecret'];
		$apipath = "Transfashion/KalistaApi/Session/RegisterExternalSession";

		if (!$url || !$appid || !$secret) {
			$errmsg = Log::error("Kalista configuration is not complete");
			throw new \Exception($errmsg, 500);
		}



		// Data yang akan dikirim
		$callback_url = join("/", [Service::getBaseUrl(), "page", "login"]);
		$params = [
			"sessid" => $sessid,
			"callback_url" => $callback_url,
		];

		$api = new KalistaApiConnector($url, $appid, $secret);
		$result = $api->execute($apipath, $params);

		$success = array_key_exists('success', $result) ? $result['success'] : false;
		$errormessage = array_key_exists('errormessage', $result) ? $result['errormessage'] : 'api error';
		if (!$success) {
			$errmsg = Log::error($errormessage);
			throw new \Exception($errmsg, 500);
		}

		$result = array_key_exists('result', $result) ? $result['result'] : [];
		$kalista_sessid = array_key_exists('kalista_sessid', $result) ? $result['kalista_sessid'] : null;
		if (!$kalista_sessid) {
			$errmsg = Log::error("Failed to register kalista session");
			throw new \Exception($errmsg, 500);
		}

		return [
			"success" => true,
			"kalista_sessid" => $kalista_sessid
		];
	}


	/**
	 * @ApiMethod
	 */
	public function GetKalistaCustomerLoginSessionUser(string $kalista_sessid) : ?array {
		try {
			$kalistaConfig = Configuration::Get('Kalista');
			
			$url = $kalistaConfig['URL'];
			$appid = $kalistaConfig['AppId'];
			$secret = $kalistaConfig['AppSecret'];
			$apipath = "Transfashion/KalistaApi/Session/GetCustomerLogin";

			$params = [
				"sessid" => $kalista_sessid,
			];

			$api = new KalistaApiConnector($url, $appid, $secret);
			$result = $api->execute($apipath, $params);
	
			$success = array_key_exists('success', $result) ? $result['success'] : false;
			$errormessage = array_key_exists('errormessage', $result) ? $result['errormessage'] : 'api error';
			if (!$success) {
				$errmsg = Log::warning($errormessage);
				return [
					"success" => true,
					"user" => null,
					"logininfo" => $errormessage
				];
			}


			$data = array_key_exists('data', $result) ? $result['data'] : null;
			
			if (!$data) {
				$errmsg = Log::error("login error or failed");
				throw new \Exception($errmsg);
			}

			if (!array_key_exists('id', $data)) {
				$errmsg = Log::error("login failed");
				throw new \Exception($errmsg);
			}	

			$user = new User([
				'id' => $data['id'],
				'name' => $data['name'],
				'phone' => array_key_exists('phone', $data) ? $data['phone'] : null,
				'email' => array_key_exists('email', $data) ? $data['email'] : null,
				'gender' => array_key_exists('gender', $data) ? $data['gender'] : null,
				'birthdate' => array_key_exists('birthdate', $data) ? $data['birthdate'] : null,
				'custaccess_code' => array_key_exists('custaccess_code', $data) ? $data['custaccess_code'] : null,
				'custaccesstype_id' => array_key_exists('custaccesstype_id', $data) ? $data['custaccesstype_id'] : null,
				'kalista_sessid' => $kalista_sessid,
			]);

			Session::SetUser($user); 
			return [
				"success" => true,
				"user" => $user
			];
		} catch (\Exception $e) {
			$errmsg = Log::error($e->getMessage());
			throw new \Exception($errmsg, 500);
		}

		
	}

	/**
	 * @ApiMethod
	 */
	public function SimulasiCustomerKirimWhatsappLogin(array $payload) : ?array {
		$kalistaConfig = Configuration::Get('Kalista');
			
		$url = $kalistaConfig['URL'];
		$appid = $kalistaConfig['AppId'];
		$secret = $kalistaConfig['AppSecret'];
		$apipath = "Transfashion/KalistaApi/Whatsapp/CustomerLogin";

		$params = [
			"payload" => $payload
		];

		$api = new KalistaApiConnector($url, $appid, $secret);
		$result = $api->execute($apipath, $params);
		return $result;
	}

}