<?php
// String input
// $input = "Hai Transfashion,\nSaya ingin #login-website-transfashion via whatsapp\n[ref:673dde5904171;evt:456;dat:555]";

// // Hapus semua karakter \n agar input bersih
// $cleanedInput = str_replace("\n", " ", $input);

// // Debug untuk memastikan input bersih
// echo "Cleaned Input: $cleanedInput\n";

// // Regex pattern untuk menangkap tag dan metadata
// $pattern = '/#([\w-]+)|\[(.*?)\]/';

// // Eksekusi regex
// preg_match_all($pattern, $cleanedInput, $matches);

// // Debug hasil regex
// print_r($matches);

// // Ambil tag login
// $loginTag = $matches[1][0] ?? null;

// // Ambil metadata string dalam tanda []
// $metadataString = $matches[2][1] ?? null;

// // Debug metadata string
// echo "Metadata String: $metadataString\n";

// // Parse metadata string ke dalam array asosiatif
// $metadata = [];
// if ($metadataString) {
//     // preg_match_all('/(\w+):([\w-]+)/', $metadataString, $metaMatches, PREG_SET_ORDER);
// 	preg_match_all('/(\w+):([\w-]+)/', $metadataString, $metaMatches, PREG_SET_ORDER);

// 	// foreach ($metaMatches as $meta) {
// 	// 	$metadata[$meta[1]] = $meta[2];
// 	// }

//     foreach ($metaMatches as $meta) {
//         $metadata[$meta[1]] = $meta[2];
//     }
// }

// print_r($metadata);

// /*
// // Cetak hasil
// echo "Login Tag: $loginTag\n";
// foreach ($metadata as $key => $value) {
//     echo ucfirst($key) . ": $value\n";
// }



$metadataString = "[ref:673dde5904171;evt:456;dat:555]";

// Parse metadata string ke dalam array asosiatif
$metadata = [];
preg_match_all('/(\w+):([\w-]+)/', $metadataString, $metaMatches, PREG_SET_ORDER);

foreach ($metaMatches as $meta) {
    $metadata[$meta[1]] = $meta[2];
}

// Cetak hasil
print_r($metadata);
