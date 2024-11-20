<?php declare (strict_types=1);
namespace Transfashion\Transfashionid;


use \AgungDhewe\Webservice\Page;

class ProductListPage extends Page {

    public function LoadPage(string $requestedPage, array $params): void
    {
        // search criteria


		$requestedPage = "product-list";
        parent::LoadPage($requestedPage, $params);
    }
}