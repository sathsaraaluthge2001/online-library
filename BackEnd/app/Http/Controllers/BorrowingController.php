<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the borrowings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $borrowings = Borrowing::all();
        return response()->json($borrowings);
    }

    /**
     * Store a newly created borrowing in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    //store the borrowing details
    public function store(Request $request)
    {
        $request->validate([
            'bookid' => 'required|integer',
            'useremail' => 'required|email',
            'booktitle' => 'required|string',
        ]);

        $borrowing = Borrowing::create($request->all());

        return response()->json($borrowing, 201);
    }

    /**
     * Search for borrowings by user email.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

     //search using mail
    public function searchByEmail(Request $request)
{
    $request->validate([
        'useremail' => 'required|email',
    ]);

    $borrowings = Borrowing::where('useremail', $request->query('useremail'))->get();

    if ($borrowings->isEmpty()) {
        return response()->json(['message' => 'No borrowings found for this email.'], 404);
    }

    return response()->json($borrowings);
}


    /**
     * Remove the specified borrowing from storage by bookid.
     *
     * @param int $bookid
     * @return \Illuminate\Http\Response
     */

     //delete borroing books using bookid
    public function deleteByBookId($bookid)
    {
        $borrowing = Borrowing::where('bookid', $bookid)->first();

        if (!$borrowing) {
            return response()->json(['message' => 'Borrowing not found.'], 404);
        }

        $borrowing->delete();

        return response()->json(['message' => 'Borrowing deleted successfully.']);
    }

   
}
