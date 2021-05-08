<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SalaRequest;
use App\Sala;
use Illuminate\Http\Response;
use App\Http\Resources\Sala as SalaResource;

class SalaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new SalaResource(Sala::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalaRequest $request)
    {
        $sala = new Sala;

        $sala->nombre = $request->nombre;
        $sala->direccion = $request->direccion;
        $sala->color = $request->color;

        $sala->save();
        //return response()->json($sala, Response::HTTP_CREATED);
        return (new SalaResource($sala))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new SalaResource(Sala::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sala = Sala::find($id);

        $sala->nombre = $request->nombre;
        $sala->direccion = $request->direccion;
        $sala->color = $request->color;

        $sala->save();
        return (new SalaResource($sala))->response()->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
