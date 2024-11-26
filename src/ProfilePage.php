<?php declare(strict_types=1);
namespace Transfashion\Transfashionid;

use AgungDhewe\Webservice\Page;

class ProfilePage extends Page {
	public function LoadPage(string $requestedContent, array $params): void {


		
		parent::LoadPage($requestedContent, $params);
	}

	static function getPageObject(object $obj) : ProfilePage {
		if (!($obj instanceof ProfilePage)) {
			throw new \Exception('Handler of this page is not ProfilePage');
		}
		return $obj;
	}

}
