<?php


namespace AppBundle\Services;


use GuzzleHttp\ClientInterface;

class MercuryExcerptService
{

    /**
     * @var ClientInterface
     */
    protected $client;

    protected $apiKey;


    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function getExcerpt($url) {

        $response = $this->client->request("GET", "/parser",  [
            "query" => ["url" => $url],
            "headers" => [
                "x-api-key" => ""
            ]
        ]);
        return $response->getBody()->getContents();
    }
}