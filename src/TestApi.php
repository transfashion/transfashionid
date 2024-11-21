<?php declare(strict_types=1);
namespace Transfashion\Transfashionid;

use AgungDhewe\Webservice\WebApi;

class TestApi extends WebApi {


	/**
	 * @ApiMethod
	 */
	public function Coba(string $pertama, string $kedua) : array {
		$ret = [
			"status" => "success",
			"data" => "pertama:$pertama   kedua:$kedua"
		];

		return $ret;
	}


	public function TestHit() : string {
		return 'Test';
	}


}