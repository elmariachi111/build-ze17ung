<?php


namespace AppBundle\Services;


use AppBundle\Entity\Excerpt;
use AppBundle\Exception\MercuryException;
use GuzzleHttp\ClientInterface;

/**
 * @deprecated replaced with GooseExcerptService
 * Class MercuryExcerptService
 * @package AppBundle\Services
 */
class MercuryExcerptService
{

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var string $apiKey
     */
    protected $apiKey;

    /**
     * @var $baseUrl
     */
    protected $baseUrl;

    public function __construct(ClientInterface $client, $mercuryBaseUrl,  $apiKey)
    {
        $this->client = $client;
        $this->baseUrl = $mercuryBaseUrl;
        $this->apiKey = $apiKey;
    }

    public function getExcerpt($url) : Excerpt {

        $response = $this->client->request("GET", "{$this->baseUrl}/parser",  [
            "query" => ["url" => $url],
            "headers" => [
                "x-api-key" => $this->apiKey
            ]
        ]);
        $_resp = $response->getBody()->getContents();
        $resp = json_decode($_resp, true);
        if (isset($resp['errorMessage'])) {
            throw new MercuryException($resp['errorMessage']);
        }
        return Excerpt::deserializeFromApi($resp);
    }
}