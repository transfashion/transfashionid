<?php declare(strict_types=1);
namespace Transfashion\Transfashionid;

use AgungDhewe\PhpLogger\Log;

use AgungDhewe\Webservice\Page;
use AgungDhewe\Webservice\IAuthenticationPage;
use AgungDhewe\Webservice\Service;
use AgungDhewe\Webservice\Configuration;
use AgungDhewe\Webservice\Session;
use AgungDhewe\Webservice\User;

class LoginPage extends Page implements IAuthenticationPage
{
	public function LoadPage(string $requestedContent, array $params): void {
		
		if (array_key_exists("id", $_GET)) {
			Log::info('auto login from external');
			$kalista_sessid = $_GET['id'];


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
				$errmsg = Log::error($errormessage);
				throw new \Exception($errmsg);
			}


			$data = array_key_exists('data', $result) ? $result['data'] : [];
			if (!array_key_exists('id', $data)) {
				$url = join("/", [Service::getBaseUrl(), "page", "login-error"]);
				header("Location: $url");
				return;
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
			$url = join("/", [Service::getBaseUrl(), "page", "welcome"]);
			header("Location: $url");
			
		}

		parent::LoadPage($requestedContent, $params);
	}

	static function getPageObject(object $obj) : IAuthenticationPage {
		if (!($obj instanceof LoginPage)) {
			throw new \Exception('Handler of this page is not LoginPage');
		}
		return $obj;
	}

}
