<?php
// app/Services/OpenLibraryService.php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class OpenLibraryService
{
    protected $httpClient;
    protected $baseUrl;

    protected $cacheService;
    public function __construct(CacheService $cacheService)
    {
        $this->httpClient = new Client();
        $this->baseUrl = 'http://openlibrary.org/api/volumes/brief/isbn/';
        $this->cacheService = $cacheService;
    }

    public function searchBooks($isbn)
    {
        $cacheKey = 'open_library_search_' . md5($isbn);
        // Check if data is cached
        if ($this->cacheService->has($cacheKey)) {
            return $this->cacheService->get($cacheKey);
        }

        // If not cached, fetch data from API
        $response = $this->httpClient->request('GET', $this->baseUrl . $isbn . '.json', []);
      
        $data = json_decode($response->getBody()->getContents(), true);
        if($data){
            // Cache data for future use
            $this->cacheService->put($cacheKey, $data, 1440); // Cache for 1440 minutes (1 day)s
        }

        return $data;
    }
}
