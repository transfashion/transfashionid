<?php declare(strict_types=1);
namespace Transfashion\Transfashionid;

use AgungDhewe\Webservice\WebPage;

class ProfilePage extends WebPage {

	public static function getObject(object $obj) : ProfilePage {
		return $obj;
	}

	public function loadPage(string $requestedContent, array $params): void {


		
		parent::LoadPage($requestedContent, $params);
	}



}
