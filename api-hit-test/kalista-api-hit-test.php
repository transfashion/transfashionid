<?php

$url = "http://host.docker.internal:8132/public";
$endpoint = "$url/api/Transfashion/KalistaApi/Session/RegisterExternalSession";

// Data yang akan dikirim
$data = [
	"request" => [
		"payload" => [
			"sessid" => "333"
		]
	]
];

// Mengonversi data menjadi JSON
$jsonData = json_encode($data);


try {

	// Inisialisasi cURL
	$ch = curl_init($endpoint);

	// Mengatur opsi cURL
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Menerima output sebagai string
	curl_setopt($ch, CURLOPT_HEADER, true);         // Sertakan header dalam output
	curl_setopt($ch, CURLOPT_NOBODY, false);        // Tetap sertakan body (ubah ke true jika hanya butuh header)
	curl_setopt($ch, CURLOPT_POST, true); // Menggunakan metode POST
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		"Content-Type: application/json", // Header untuk JSON
		"Content-Length: " . strlen($jsonData)
	]);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // Data yang dikirim

	// Eksekusi cURL dan ambil responsnya
	$response = curl_exec($ch);
	if (!$response) {
		throw new Exception("maaf, curl gak nyambung");
	}

	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE); // Ukuran header
	$header = substr($response, 0, $header_size);           // Pisahkan header
	$body = substr($response, $header_size);                // Pisahkan body (jika diperlukan)

	echo $header;
	echo $body;

} catch (Exception $ex) {
	echo $ex->getMessage();
} finally {
	echo "\n\n";
}


