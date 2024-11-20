<?php declare(strict_types=1);
namespace Transfashion\Transfashionid;

use \AgungDhewe\PhpLogger\Log;

use \AgungDhewe\Webservice\Page;
use \AgungDhewe\Webservice\IAuthenticationPage;


class LoginPage extends Page implements IAuthenticationPage
{
	public function LoadPage(string $requestedContent, array $params): void {

		$this->setData('nonce', uniqid());
		if ($_POST) {
			Log::debug('ada data di POST');
		} else {
			Log::debug('hanya GET');
		}

		Log::debug($params);
		parent::LoadPage($requestedContent, $params);
	}

	static function getPageObject(object $obj) : IAuthenticationPage {
		if (!($obj instanceof LoginPage)) {
			throw new \Exception('Handler of this page is not LoginPage');
		}
		return $obj;
	}

}