<?php 
namespace Transfashion\Transfashionid;

use AgungDhewe\Webservice\IWebPage;

interface IProductListPage extends IWebPage {
	static function getPageObject(object $obj) : IProductListPage;
}


