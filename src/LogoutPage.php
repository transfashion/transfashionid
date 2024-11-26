<?php declare(strict_types=1);
namespace Transfashion\Transfashionid;

use AgungDhewe\Webservice\Page;
use AgungDhewe\Webservice\Session;
use AgungDhewe\Webservice\Configuration;

class LogoutPage extends Page {
	public function LoadPage(string $requestedContent, array $params): void {
		
		
		$kalista_sessid = $_SESSION['kalista_sessid'];
		

		// Logout di kalista
		$kalistaConfig = Configuration::Get('Kalista');
		$url = $kalistaConfig['URL'];
		$appid = $kalistaConfig['AppId'];
		$secret = $kalistaConfig['AppSecret'];
		$apipath = "Transfashion/KalistaApi/Session/SessionLogout";

		$params = [
			"sessid" => $kalista_sessid,
		];

		$api = new KalistaApiConnector($url, $appid, $secret);
		$result = $api->execute($apipath, $params);

		$success = array_key_exists('success', $result) ? $result['success'] : false;
		if ($success) {
			Session::SetUser(null);
		} else {
			throw new \Exception('Error while logout');
		}

		parent::LoadPage($requestedContent, $params);
	}

	static function getPageObject(object $obj) : LogoutPage {
		if (!($obj instanceof LogoutPage)) {
			throw new \Exception('Handler of this page is not LogoutPage');
		}
		return $obj;
	}

}
