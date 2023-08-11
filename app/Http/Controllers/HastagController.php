<?php

namespace App\Http\Controllers;

use App\Models\Hastag;
use App\Http\Requests\StoreHastagRequest;
use App\Http\Requests\UpdateHastagRequest;

class HastagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreHastagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHastagRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hastag  $hastag
     * @return \Illuminate\Http\Response
     */
    public function show(Hastag $hastag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hastag  $hastag
     * @return \Illuminate\Http\Response
     */
    public function edit(Hastag $hastag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHastagRequest  $request
     * @param  \App\Models\Hastag  $hastag
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHastagRequest $request, Hastag $hastag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hastag  $hastag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hastag $hastag)
    {
        //
    }
}
