<?php

/**
 * @Mindfav Info:
 * Die Mailerlite Klasse wurde so erweitert,
 * dass der Client die Header-Daten der letzten Anfrage speichert,
 * und diese über die MailerLite Klasse abgefragt werden können.
 * Somit können auch die Response-Header empfangen und ausgewertet werden,
 * welche bspw. Informationen über Rate-Limits enthalten.
 * Github-Repo: https://github.com/sfxon/mailerlite-api-v2-php-sdk
 **/

namespace MailerLiteApi;

use Http\Client\HttpClient;

use MailerLiteApi\Common\ApiConstants;
use MailerLiteApi\Common\RestClient;
use MailerLiteApi\Exceptions\MailerLiteSdkException;

/**
 * Class MailerLite
 *
 * @package MailerLiteApi
 */
class MailerLite {

    /**
     * @var null | string
     */
    protected $apiKey;

    /**
     * @var RestClient
     */
    protected $restClient;

    /**
     * @param string|null $apiKey
     * @param HttpClient $client
     */
    public function __construct(
        $apiKey = null,
        HttpClient $httpClient = null
    ) {
        if (is_null($apiKey)) {
            throw new MailerLiteSdkException("API key is not provided");
        }

        $this->apiKey = $apiKey;

        $this->restClient = new RestClient(
            $this->getBaseUrl(),
            $apiKey,
            $httpClient
        );
    }

    /**
     * @return \MailerLiteApi\Api\Groups
     */
    public function groups()
    {
        return new \MailerLiteApi\Api\Groups($this->restClient);
    }

    /**
     * @return \MailerLiteApi\Api\Fields
     */
    public function fields()
    {
        return new \MailerLiteApi\Api\Fields($this->restClient);
    }

    /**
     * @return \MailerLiteApi\Api\Subscribers
     */
    public function subscribers()
    {
        return new \MailerLiteApi\Api\Subscribers($this->restClient);
    }

    /**
     * @return \MailerLiteApi\Api\Campaigns
     */
    public function campaigns()
    {
        return new \MailerLiteApi\Api\Campaigns($this->restClient);
    }

    /**
     * @return \MailerLiteApi\Api\Stats
     */
    public function stats()
    {
        return new \MailerLiteApi\Api\Stats($this->restClient);
    }

    /**
     * @return \MailerLiteApi\Api\Settings
     */
    public function settings()
    {
        return new \MailerLiteApi\Api\Settings($this->restClient);
    }

    public function woocommerce()
    {
        return new \MailerLiteApi\Api\WooCommerce($this->restClient);
    }

    /**
     * @return \MailerLiteApi\Api\Segments
     */
    public function segments()
    {
        return new \MailerLiteApi\Api\Segments($this->restClient);
    }

    /**
     * @return \MailerLiteApi\Api\Batch
     */
    public function batch()
    {
        return new \MailerLiteApi\Api\Batch($this->restClient);
    }

    /**
     * @param  string $version
     * @return string
     */
    public function getBaseUrl($version = ApiConstants::VERSION)
    {
        return ApiConstants::BASE_URL . $version . '/';
    }
	
	/**
	 * Return the last responses headers.
	 * @return array|null
	 */
	public function getLastResponseHeaders() {
		return $this->restClient->getLastResponseHeaders();
	}

}
