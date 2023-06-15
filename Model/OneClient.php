<?php

namespace Musicjerm\OneApiPhpSdk\Model;

use JsonException;

class OneClient
{
    private string $apiToken;
    private string $url = 'https://the-one-api.dev/v2';
    private string $jsonEncodedData;

    public function __construct(string $apiToken)
    {
        // take api token as constructor arg
        $this->apiToken = $apiToken;
    }

    private function curlRequest(string $endpoint): void
    {
        // set the url and endpoints
        $url = $this->url . "/$endpoint";

        // curl handler
        $ch = curl_init();

        // set curl options and pass the api token for auth
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $this->apiToken"]);

        // get the response
        $response = curl_exec($ch);

        // close the handler
        curl_close($ch);

        // check for valid data and authentication
        try {
            $data = json_decode($response, false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $je){
            throw new \RuntimeException(sprintf('Invalid json data returned, received: %s', $response));
        }

        if (property_exists($data, 'success') && !$data->success){
            throw new \RuntimeException(property_exists($data, 'message') ? $data->message : 'bad api request', 403);
        }

        // save response data to client object->jsonEncodedData
        $this->jsonEncodedData = $response;
    }

    public function verifyData(string $jsonString): bool
    {
        // check for valid json data
        try {
            $data = json_decode($jsonString, false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $je){
            throw new \RuntimeException(sprintf('Invalid json data returned, received: %s', $jsonString));
        }

        // check api token authenticates
        if (property_exists($data, 'success') && !$data->success){
            throw new \RuntimeException(property_exists($data, 'message') ? $data->message : 'bad api request', 403);
        }

        return true;
    }

    public function oneQuery(string $mediaType, ?string $mediaId = null, ?string $quote = null): void
    {
        // make sure media type is lower case
        $mediaType = strtolower($mediaType);

        // build the endpoint
        $endpoint = $mediaType;
        if ($mediaId !== null){
            $endpoint .= "/$mediaId";

            if ($quote !== null && in_array($mediaType, ['movie', 'character'])){
                $endpoint .= "/$quote";
            }
        }

        // check data, return if valid
        $this->curlRequest($endpoint);
        if ($this->verifyData($this->jsonEncodedData)) {
            return;
        }

        // throw final error if data check failed, should not make it to this point
        throw new \RuntimeException('invalid json data was retrieved, please check your endpoints');
    }

    public function getJsonData(): string
    {
        return $this->jsonEncodedData;
    }
}