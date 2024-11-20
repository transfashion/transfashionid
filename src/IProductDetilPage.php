<?php 
namespace Transfashion\Transfashionid;

use AgungDhewe\Webservice\IWebPage;

interface IProductDetilPage extends IWebPage {
	static function getPageObject(object $obj) : IProductDetilPage;
}

