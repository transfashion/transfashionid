<?php declare (strict_types=1);
namespace Transfashion\Transfashionid;


use \AgungDhewe\Webservice\Page;

class CheckoutPage extends Page {

    public function LoadPage(string $requestedPage, array $params): void
    {
        $this->setData('nama', 'putra');



        parent::LoadPage($requestedPage, $params);
    }
}