<?php declare (strict_types=1);
namespace Transfashion\Transfashionid;



use \AgungDhewe\Webservice\Page;


class ProductDetilPage extends Page implements IProductDetilPage {

    public function LoadPage(string $requestedPage, array $params): void
    {
        // ambil data yang diminta


		$requestedPage = "product-detil";
        parent::LoadPage($requestedPage, $params);
    }

	static function getPageObject(object $obj) : IProductDetilPage { 
		if (!($obj instanceof ProductDetilPage)) {
			throw new \Exception('Handler of this page is not ProductDetilPage');
		}
		return $obj;
	}
}