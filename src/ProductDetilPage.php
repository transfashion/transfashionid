<?php declare (strict_types=1);
namespace Transfashion\Transfashionid;



use \AgungDhewe\Webservice\WebPage;


class ProductDetilPage extends WebPage  {

	public static function getObject(object $obj) : ProductDetilPage {
		return $obj;
	}

    public function loadPage(string $requestedPage, array $params): void {
        // ambil data yang diminta


		$requestedPage = "product-detil";
        parent::loadPage($requestedPage, $params);
    }

	
}