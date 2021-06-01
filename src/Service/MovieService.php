<?php


namespace App\Service;


use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MovieService
{
    private $httpClient;
    private $apiKey = '3c6d05c2ecda902ddfbecffd4bfa740c';

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getPopularMovies()
    {
        try {
            return $this->httpClient->request('GET',
                "https://api.themoviedb.org/3/movie/popular?api_key=$this->apiKey&language=es-ES&page=1")->toArray()['results'];
        } catch (ClientExceptionInterface | DecodingExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface |
        TransportExceptionInterface $e) {
            dd($e->getMessage());
        }
    }

    public function getMovieById($id): array
    {
        try {
            return $this->httpClient->request('GET',
                "https://api.themoviedb.org/3/movie/$id?api_key=$this->apiKey&language=es-ES")->toArray();
        } catch (ClientExceptionInterface | DecodingExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface |
        TransportExceptionInterface $e) {
            dd($e->getMessage());
        }
    }

    public function getRecommendations($id): array
    {
        try {
            return $this->httpClient->request('GET',
                "https://api.themoviedb.org/3/movie/$id/recommendations?api_key=$this->apiKey&language=es-ES&page=1")
                ->toArray()['results'];
        } catch (ClientExceptionInterface | DecodingExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
            dd($e->getMessage());
        }
    }
}