<?php

namespace arleslie\Enom;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Message\Response;

class Helper
{
	protected $client;

	public function __construct(Guzzle $client)
	{
		$this->client = $client;
	}

	protected function request($args)
	{
		$response = $this->client->get('interface.asp?'.http_build_query($args));
		return $this->parseResponse($response);
	}

	protected function parseResponse(Response $response)
	{
		$xml = simplexml_load_string((string) $response->getBody());
		if (!empty($xml->errors)) {
			throw new EnomException($xml->errors->Err1[0], false);
		}

		return $xml;
	}
}