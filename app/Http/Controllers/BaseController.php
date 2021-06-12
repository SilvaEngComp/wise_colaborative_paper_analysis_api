<?php

namespace App\Http\Controllers;

use App\Models\Base;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Base::all();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Base::create([
            "name"=>$request->input('base')
        ]);

        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Base  $base
     * @return \Illuminate\Http\Response
     */
    public function show(Base $base)
    {
        if($base){
            return $base;
        }

        return response(['message'=>'Base não encontrada'],404);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Base  $base
     * @return \Illuminate\Http\Response
     */
    public function destroy(Base $base)
    {
        if($base){
            $base->delete();
            return response(['message'=>'Base deletada'],200);
        }
        return response(['message'=>'Base não encontrada'],404);

    }
}
