<?php declare(strict_types=1);
namespace Transfashion\Transfashionid;

use AgungDhewe\Webservice\WebTemplate;
use AgungDhewe\Webservice\IWebTemplate;


class Template extends WebTemplate implements IWebTemplate {
	const string DEFAULT_NAME = "transfashionid";
	private string $tpldir;

	function __construct(?string $tpldir=null) {
		$this->tpldir = $tpldir;
	}


	public static function GetObject(object $tpl) : Template {
		return $tpl;
	}


	public function GetName() : string {
		return self::DEFAULT_NAME;
	}

	public function GetTemplateDir() : string {
		return $this->tpldir;
	}


	public function getPromoterText() : ?string {
		$text  = 'Dapatkan tambahan discount <b>50%</b> setiap pembelian 2 pairs di <b>GEOX Kota Casablanca</b>,';
		$text .= ' berlaku <b>hanya hari ini</b> Rabu, 13 November 2024';
		// $text = "www.transfashion.id";
		return $text;
	}

	public function includeMenubarNavContent() : void {
		include join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'navigation', 'menubar-nav.phtml']);
	}

	public function includeSidebarNavContent() : void {
		include join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'navigation', 'sidebar-nav.phtml']);
	}

	public function includeFooterNavContent() : void {
		include join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'navigation', 'footer-nav.phtml']);
	}

}