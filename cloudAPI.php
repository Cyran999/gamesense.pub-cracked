<?php
require 'vendor/autoload.php';

/**
 * Class Chunxi
 */
class Chunxi
{
    const API_URL = "https://api.onetap.com/cloud/";

    //Please go to the Personal Center to obtain this information before using it.
    const API_ID = "";
    const API_SECRET = "";
    const API_KEY = "";

    /**
     * @var \GuzzleHttp\Client
     */
    protected \GuzzleHttp\Client $client;


    /**
     * Chunxi constructor.
     */
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client([
            "base_uri" => self::API_URL,
            "timeout" => 5.0,
            "headers" => [
                "X-Api-Id" => self::API_ID,
                "X-Api-Secret" => self::API_SECRET,
                "X-Api-Key" => self::API_KEY
            ]
        ]);
    }

    /**
     * @param string $uri
     * @return string
     */
    protected function getUri(string $uri): string
    {
        if (substr($uri, 0, strlen($uri) - 1) != "/") {
            $uri .= "/";
        }
        return $uri;
    }


    /**
     * @param string $uri
     * @return array
     */
    public function get(string $uri): ?array
    {
        try {
            $response = $this->client->get($this->getUri($uri));
            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            return null;
        }
    }


    /**
     * @param string $uri
     * @param array $data
     * @return array|mixed
     */
    public function post(string $uri, array $data): ?array
    {
        try {
            $response = $this->client->post($this->getUri($uri), [
                "form_params" => $data,
                "headers" => [
                    "Content-Type" => "application/x-www-form-urlencoded"
                ]
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            return null;
        }
    }


    /**
     * @param string $uri
     * @param array $data
     * @return array|mixed
     */
    public function delete(string $uri, array $data): ?array
    {
        try {
            $response = $this->client->delete($this->getUri($uri), [
                "form_params" => $data,
                "headers" => [
                    "Content-Type" => "application/x-www-form-urlencoded"
                ]
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            return null;
        }
    }
}


$chunxi = new Chunxi();

//Gets all configs.
$configs = $chunxi->get("configs");
var_dump($configs);


//Creates a new script invite.
$invites = $chunxi->post("scripts/41458/invites", [
    "max_age" => 1,
    "max_uses" => 1
]);
var_dump($invites);

//Deletes a script invite.
$delete = $chunxi->delete("scripts/41458/invites", ["invite_id" => "12269"]);
var_dump($delete);
