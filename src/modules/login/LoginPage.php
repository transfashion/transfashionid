<?php declare (strict_types=1);
namespace Transfashion\Transfashionid\modules\login;

use AgungDhewe\PhpLogger\Log;
use AgungDhewe\Webservice\WebPage;

class LoginPage extends WebPage {

	function __construct() {
		
	}


	public static function getObject(object $obj) : LoginPage {
		return $obj;
	}

    public function loadPage(string $requestedPage, array $params): void {
		try {
			if ($requestedPage=='login/whatsapp') {
				$pageTitle = "Login via Whatsapp";
				$pageFile = "LoginViaWhatsapp.phtml";
			} else if ($requestedPage=='login/mpc') {
				$pageTitle = "Login via CtCorp MPC";
				$pageFile = "LoginViaMpc.phtml";
			} else if ($requestedPage=='login/google') {
				$pageTitle = "Login via Google";
				$pageFile = "LoginViaGoogle.phtml";
			} else {
				$pageTitle = "Login";
				$pageFile = "LoginPage.phtml";
			}
			
			$this->setTitle($pageTitle);

			$pageviewpath = implode(DIRECTORY_SEPARATOR, [__DIR__, $pageFile]);
			Log::Info("rendering file $pageviewpath");
			$this->renderPageFile($pageviewpath, $params);
		} catch (\Exception $ex) {
			Log::Error($ex->getMessage());
			throw $ex;
		}       
		
    }
}