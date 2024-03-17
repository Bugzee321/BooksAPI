<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\OpenLibraryService;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    protected $openLibraryService;

    public function __construct(OpenLibraryService $openLibraryService)
    {
        $this->openLibraryService = $openLibraryService;
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $isbn)
    {
        // Validate ISBN format
        $validator = validator(['isbn' => $isbn], [
            'isbn' => ['required', 'regex:/^(?:\d{10}|\d{13})$/']
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        // Fetch book details from Open Library API
        $book = $this->openLibraryService->searchBooks($isbn);

        // Check if book is found
        if (!$book) {
            return response()->json(['error' => 'ISBN not found'], 404);
        }

        // Return book details
        return response()->json($book);
    }
}
