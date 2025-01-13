<?php declare (strict_types=1);
namespace Transfashion\Transfashionid;


use \AgungDhewe\Webservice\WebPage;

class CheckoutPage extends WebPage {


	public static function getObject(object $obj) : CheckoutPage {
		return $obj;
	}

    public function loadPage(string $requestedPage, array $params): void
    {
        $this->setData('nama', 'putra');
        parent::loadPage($requestedPage, $params);
    }
}