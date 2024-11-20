<?php declare (strict_types=1);
namespace Transfashion\Transfashionid;


use \AgungDhewe\Webservice\Page;

class ProductDetilPage extends Page {

    public function LoadPage(string $requestedPage, array $params): void
    {
        // ambil data yang diminta


		$requestedPage = "product-detil";
        parent::LoadPage($requestedPage, $params);
    }
}