<?php declare(strict_types=1);
namespace Transfashion\Transfashionid\apis;

use AgungDhewe\PhpLogger\Log;
use AgungDhewe\Webservice\WebApi;

class LoginExternal extends WebApi {




	/**
	 * @ApiMethod
	 */
	public function ViaWhatsapp(array $payload) : array {
		$phone_number = array_key_exists('phone_number', $payload) ? $payload['phone_number'] : null;
		$message = array_key_exists('message', $payload) ? $payload['message'] : null;
		$from_name = array_key_exists('from_name', $payload) ? $payload['from_name'] : null;
		$intent = array_key_exists('intent', $payload) ? $payload['intent'] : null;

		// extract data
		$data = $this->parseLoginRequestMessage($message);
		$msg_intent = array_key_exists('intent', $data) ? $data['intent'] : null;
		$msg_ref = array_key_exists('ref', $data) ? $data['ref'] : null;

		
		$sessid = $msg_ref;
		session_id($sessid);
		session_start();
		
		$_SESSION['wa_number'] = $phone_number;
		$_SESSION['user_name'] = $from_name;
		$_SESSION['is_login'] = true;

		// balas wa nya
		return [
			"success" => true
		];

	}


	private function parseLoginRequestMessage(string $message) : array {
		$cleanedInput = str_replace("\n", " ", $message);
		$pattern = '/#([\w-]+)|\[(.*?)\]/';
		preg_match_all($pattern, $cleanedInput, $matches);
		$result = [];
		$result['intent'] = $matches[1][0] ?? null;
		$metadataString = $matches[2][1] ?? null;
		if ($metadataString) {
			preg_match_all('/(\w+):([\w-]+)/', $metadataString, $metaMatches, PREG_SET_ORDER);
			foreach ($metaMatches as $meta) {
				$result[$meta[1]] = $meta[2];
			}
		}
		return $result;
	}



}