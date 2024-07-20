<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    protected $books;

    public function __construct()
    {
        $this->books = new Book();
    }

    // Show all books
    public function index()
    {
        try {
            $books = $this->books->all();
            return response()->json($books, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Add a book
    public function store(Request $request)
    {
        try {
            $books = $this->books->create($request->all());
            return response()->json($books, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Search for books by any column
public function search(Request $request)
{
    try {
        $query = $request->input('query'); // Get the query parameter from the URL
        $books = Book::where('title', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->orWhere('type', 'like', "%$query%") // Ensure column name matches your model
            ->get();
        
        return response()->json($books, 200);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    // Delete a book
    public function destroy(string $id)
    {
        try {
            $book = $this->books->find($id);
            if (!$book) {
                return response()->json(['error' => 'Book not found'], 404);
            }
            $book->delete();
            return response()->json(['message' => 'Book deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Find a book by title
    public function show(string $title)
    {
        try {
            $book = $this->books->where('title', $title)->first();
            if (!$book) {
                return response()->json(['error' => 'Book not found'], 404);
            }
            return response()->json($book, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Find a book by type
    public function showType(string $type)
    {
        try {
            $book = $this->books->where('type', $type)->first();
            if (!$book) {
                return response()->json(['error' => 'Book not found'], 404);
            }
            return response()->json($book, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
