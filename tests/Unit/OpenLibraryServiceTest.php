<?php
namespace Tests\Unit;

use App\Services\OpenLibraryService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use App\Services\CacheService; // Import CacheService


class OpenLibraryServiceTest extends TestCase
{
    protected $openLibraryService;

    protected function setUp(): void
    {
        parent::setUp();
        $mockCacheService = $this->createMock(CacheService::class);
        $this->openLibraryService = new OpenLibraryService($mockCacheService);
    }

    public function testGetBookByISBNSuccess()
    {
        $isbn = '9783161484100';
        
        $mockCacheService = $this->createMock(CacheService::class);
        
        $openLibraryService = new OpenLibraryService($mockCacheService);
        $response = $openLibraryService->searchBooks($isbn);        
        
        $this->assertNotNull($response);
    }

    public function testGetBookByISBNFailure()
    {
        $isbn = '123';
        
        $mockCacheService = $this->createMock(CacheService::class);
        
        $openLibraryService = new OpenLibraryService($mockCacheService);
        $response = $openLibraryService->searchBooks($isbn);        
        $this->assertTrue(is_array($response) && count($response) === 0);
    }

    public function testGetBookFromCache()
    {
        $isbn = '9783161484100';
        
        // Mock CacheService
        $mockCacheService = $this->createMock(CacheService::class);
        $mockCacheService->method('has')->willReturn(true); // Assume data is already cached
        $mockCacheService->method('get')->willReturn(['title' => 'Test Book', 'author' => 'Test Author']);
    
        // Mock HttpClient
        $mockHttpClient = $this->createMock(Client::class);
        // Assuming the response structure, you can adjust it according to your actual implementation
        $mockHttpClient->method('request')->willReturn(new Response(200, [], '{"title": "Test Book", "author": "Test Author"}'));
    
        // Create OpenLibraryService instance with mock CacheService and HttpClient
        $openLibraryService = new OpenLibraryService($mockCacheService);
        
        // Call the method to search for books
        $book = $openLibraryService->searchBooks($isbn);
    
        // Assert that the book is retrieved from the cache
        $this->assertEquals(['title' => 'Test Book', 'author' => 'Test Author'], $book);
    }
}
