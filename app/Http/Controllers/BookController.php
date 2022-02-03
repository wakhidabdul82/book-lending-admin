<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use App\Models\Author;
use App\Models\Catalog;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** 
        $books = Book::with('publisher', 'author', 'catalog')->get();
        return $books;
        */
        $publishers = Publisher::all();
        $authors = Author::all();
        $catalogs = Catalog::all();
        return view('admin.book', compact('publishers', 'authors', 'catalogs'));
    }

    public function api()
    {
        $book = Book::all();
        
        return json_encode($book);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'isbn' => 'required',
            'title' => 'required',
            'year' => 'required|numeric',
            'publisher_id' => 'required',
            'author_id' => 'required',
            'catalog_id' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|numeric'
        ], [
            'isbn.required' => 'ISBN must filled!',
            'title.required' => 'Title must filled!',
            'year.required' => 'Year must filled!',
            'publisher_id.required' => 'Choose one!',
            'author_id.required' => 'Choose one!',
            'catalog_id.required' => 'Choose one!',
            'qty.required' => 'Qty must filled!',
            'price.required' => 'Price must filled!'
        ]);

        Book::create($request->all());
        return redirect('/books');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'isbn' => 'required',
            'title' => 'required',
            'year' => 'required|numeric',
            'publisher_id' => 'required',
            'author_id' => 'required',
            'catalog_id' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|numeric'
        ], [
            'isbn.required' => 'ISBN must filled!',
            'title.required' => 'Title must filled!',
            'year.required' => 'Year must filled!',
            'publisher_id.required' => 'Choose one!',
            'author_id.required' => 'Choose one!',
            'catalog_id.required' => 'Choose one!',
            'qty.required' => 'Qty must filled!',
            'price.required' => 'Price must filled!'
        ]);

        $book->update($request->all());
        return redirect('/books');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
    }
}
