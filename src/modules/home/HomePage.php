<?php declare (strict_types=1);
namespace Transfashion\Transfashionid\modules\home;

use AgungDhewe\PhpLogger\Log;
use AgungDhewe\Webservice\WebPage;

class HomePage extends WebPage {

	function __construct() {
		$this->setTitle("Home");
	}


	public static function getObject(object $obj) : HomePage {
		return $obj;
	}

    public function loadPage(string $requestedPage, array $params): void {
		try {
			$pageviewpath = implode(DIRECTORY_SEPARATOR, [__DIR__, 'HomePage.phtml']);
			Log::Info("rendering file $pageviewpath");
			$this->renderPageFile($pageviewpath, $params);
		} catch (\Exception $ex) {
			Log::Error($ex->getMessage());
			throw $ex;
		}       
		
    }
}