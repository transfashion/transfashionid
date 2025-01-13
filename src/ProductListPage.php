<?php declare (strict_types=1);
namespace Transfashion\Transfashionid;


use \AgungDhewe\Webservice\WebPage;

class ProductListPage extends WebPage  {

	public static function getObject(object $obj) : ProductListPage {
		return $obj;
	}

    public function loadPage(string $requestedPage, array $params): void
    {
        // search criteria


		$requestedPage = "product-list";
        parent::LoadPage($requestedPage, $params);
    }


}