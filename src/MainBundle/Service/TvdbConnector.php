<?php
namespace TestBundle\Service;

/**
 * Class TvdbConnector
 * @package TestBundle\Service
 */
class TvdbConnector
{
    private $apiKey;
    private $username;
    private $userKey;
    private $client;


    public function __construct($apiKey, $username, $userKey)
    {
        $this->apiKey = $apiKey;
        $this->username = $username;
        $this->userKey = $userKey;


        $client = new \Adrenth\Thetvdb\Client();

        $client->setLanguage('en');

        $token = $client->authentication()->login($this->apiKey, $this->username, $this->userKey);
        $client->setToken($token);

        $this->client = $client;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getUserKey()
    {
        return $this->userKey;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function searchSerieByName($name)
    {
        return $this->client->search()->seriesByName($name)->getData();
    }

    public function getSerieById($idSerie)
    {
        return $this->client->series()->get($idSerie);
    }

    public function getEpisodesFromSerie($idSerie)
    {
        return $this->client->series()->getEpisodes($idSerie)->getData();
    }

    public function getActeursFromSerie($idSerie)
    {
        return $this->client->series()->getActors($idSerie)->getData();
    }

    public function getImagesFromSerie($idSerie)
    {
        return $this->client->series()->getImages($idSerie)->getData();
    }
}
?>