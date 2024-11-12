<?php 

use AgungDhewe\Webservice\Configuration;
use AgungDhewe\Webservice\PlainTemplate;

Configuration::Set([
	
	'DbMain' => [
		'DSN' => "mysql:host=127.0.0.1;dbname=mydb",
		'user' => "root",
		'pass' => ""
	],

	'Logger' => [
		'output' => 'file',      			// output ke filename (log.txt)
		'filename' => 'log.txt',			// nama file og
		'maxLogSize' => '10485760',			// ukuran maksimal log (bytes)
		'debug' => true,         			// output ke debug.txt, isi akan dikosongkan apabila ada parameter $_GET['cleardebug'] = 1, atau pada CLI, saat script dijalankan
		'showCallerFileOnInfo' => false,  	// default false, jika true, menampilkan referensi caller file di Log:info()
		// 'debugChannel' => 'fgta5-dev'
	],

	'WebTemplate' => new PlainTemplate(join(DIRECTORY_SEPARATOR, [__DIR__, 'templates']), "transfashionid"), 
	'PagesDir' => 'pages',
	'BaseUrl' => 'http://localhost:8007',
	'IndexPage' => 'page/home',
	
]);

Configuration::UseConfig([
	Configuration::DB_MAIN => 'DbMain',
]);

