<?php declare (strict_types=1);
namespace Transfashion\Transfashionid;


use \AgungDhewe\Webservice\Page;

class ProductListPage extends Page implements IProductListPage {

    public function LoadPage(string $requestedPage, array $params): void
    {
        // search criteria


		$requestedPage = "product-list";
        parent::LoadPage($requestedPage, $params);
    }


	static function getPageObject(object $obj) : IProductListPage { 
		if (!($obj instanceof ProductListPage)) {
			throw new \Exception('Handler of this page is not ProductListPage');
		}
		return $obj;
	}
}