<?php namespace Transfashion\Transfashionid;

use AgungDhewe\Webservice\IWebTemplate;

interface ITemplate extends IWebTemplate {
	function getPromoterText() : ?string;
	function includeMenubarNavContent() : void;
	function includeSidebarNavContent() : void;
	function includeFooterNavContent() : void;
}