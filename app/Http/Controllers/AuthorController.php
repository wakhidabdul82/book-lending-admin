<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**$author = Author::with('books')->get();
        return $author;*/

        return view('admin.author');
    }

    // Datatable/yajra here
    public function api()
    {
        $author = Author::all();

        //foreach ($author as $key => $item) {
        //    $item->date = convert_date($item->created_at);
        //}

        $datatables = datatables()->of($author)
                    ->addColumn('date', function($author){
                        return convert_date($author->created_at);
                    })
                    ->addIndexColumn();
        
        return $datatables->make(true);
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
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required|numeric',
            'address' => 'required',
        ], [
            'name.required' => 'Name must filled!',
            'email.required' => 'Email must filled!',
            'phone_number.required' => 'Phone Number must filled with number',
            'address.required' => 'Address must filled!',
        ]);

        Author::create($request->all());
        return redirect('/authors');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required|numeric',
            'address' => 'required',
        ], [
            'name.required' => 'Name must filled!',
            'email.required' => 'Email must filled!',
            'phone_number.required' => 'Phone Number must filled with number',
            'address.required' => 'Address must filled!',
        ]);

        $author->update($request->all());
        return redirect('/authors');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        $author->delete();
    }
}
