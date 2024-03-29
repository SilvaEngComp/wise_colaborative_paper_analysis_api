<?php

namespace App\Http\Controllers;

use App\Models\ProtocolType;
use Illuminate\Http\Request;

class ProtocolTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProtocolType::all();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProtocolType  $protocolType
     * @return \Illuminate\Http\Response
     */
    public function show(ProtocolType $protocolType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProtocolType  $protocolType
     * @return \Illuminate\Http\Response
     */
    public function edit(ProtocolType $protocolType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProtocolType  $protocolType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProtocolType $protocolType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProtocolType  $protocolType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProtocolType $protocolType)
    {
        //
    }
}
