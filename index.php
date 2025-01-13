<?php 
require_once __DIR__ . '/vendor/autoload.php';

use AgungDhewe\PhpLogger\Logger;
use AgungDhewe\Webservice\Configuration;
use AgungDhewe\Webservice\Service;
use AgungDhewe\Webservice\Router;
use AgungDhewe\Webservice\Routes\PageRoute;


use Transfashion\Transfashionid\modules\home\HomePage;
use Transfashion\Transfashionid\modules\login\LoginPage;


use Transfashion\Transfashionid\LogoutPage;
use Transfashion\Transfashionid\ProfilePage;
use Transfashion\Transfashionid\CheckoutPage;
use Transfashion\Transfashionid\ProductDetilPage;
use Transfashion\Transfashionid\ProductListPage;

// script ini hanya dijalankan di web server
if (php_sapi_name() === 'cli') {
	die("Script cannot be executed directly from CLI\n\n");
}


try {
	$configfile = 'config.php';
	if (getenv('CONFIG')) {
		$configfile = getenv('CONFIG');
	}

	$configpath = implode(DIRECTORY_SEPARATOR, [__DIR__, $configfile]);
	if (!is_file($configpath)) {
		throw new Exception("Configuration '$configfile' is not found");
	}

	require_once $configpath;
	Configuration::SetRootDir(__DIR__);
	Configuration::SetLogger();
	Logger::ShowScriptReferenceToUser(false);

	// Prepare debug
	PageRoute::ResetDebugOnPageRequest(["page/*", "content/*", "api/*"]);
	PageRoute::AddPageHandler('page/home', HomePage::class);
	PageRoute::AddPageHandler('page/login', LoginPage::class);
	PageRoute::AddPageHandler('page/login/*', LoginPage::class);


	PageRoute::AddPageHandler('page/logout', LogoutPage::class);
	PageRoute::AddPageHandler('page/profile', ProfilePage::class);
	PageRoute::AddPageHandler('page/checkout', CheckoutPage::class);
	PageRoute::AddPageHandler('page/product/*', ProductDetilPage::class);
	PageRoute::AddPageHandler('page/list/*', ProductListPage::class);


	// Route internal
	Router::SetupDefaultRoutes();

	Router::POST('page/login', PageRoute::class);
	Router::POST('page/checkout', PageRoute::class);

	// Serve url
	Service::Main();

	echo "\n";
} catch (Exception $ex) {
	Service::handleHttpException($ex);
}