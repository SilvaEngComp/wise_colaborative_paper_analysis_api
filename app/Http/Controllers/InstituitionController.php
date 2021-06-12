<?php

namespace App\Http\Controllers;

use App\Models\Instituition;
use Illuminate\Http\Request;

class InstituitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Instituition::all();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Instituition::create([
            "name"=>$request->input('instituition'),
            "abreviation"=>$request->input('abreviation'),
            "region"=>$request->input('region'),
            "state"=>$request->input('state'),
        ]);

        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Instituition  $instituition
     * @return \Illuminate\Http\Response
     */
    public function show(Instituition $instituition)
    {
        if($instituition){
            return $instituition;
        }

        return response(['message'=>'Instituition não encontrada'],404);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instituition  $instituition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Instituition $instituition)
    {
        if($instituition){
            $instituition->delete();
            return response(['message'=>'Instituition deletada'],200);
        }
        return response(['message'=>'Instituition não encontrada'],404);

    }
}
