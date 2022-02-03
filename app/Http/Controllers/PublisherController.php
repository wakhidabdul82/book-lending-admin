<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** 
        $publisher = Publisher::with('books')->get();
        return $publisher;
        */
        $publishers = Publisher::all();
        return view('admin.publisher', compact('publishers'));
    }

    public function api()
    {
        $publishers = Publisher::all();
        $datatables = datatables()->of($publishers)
                    ->addColumn('date', function($publishers){
                        return convert_date($publishers->created_at);
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
        //return view('admin.publisher.create');
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

        Publisher::create($request->all());
        return redirect('/publishers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function show(Publisher $publisher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function edit(Publisher $publisher)
    {
        //return view('admin.publisher.edit', compact('publisher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publisher $publisher)
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

        $publisher->update($request->all());
        return redirect('/publishers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();
        //return redirect('/publishers');
    }
}
