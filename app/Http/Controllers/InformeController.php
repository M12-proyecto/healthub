<?php

namespace App\Http\Controllers;

use App\Models\Informe;
use Illuminate\Http\Request;

class InformeController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function show()
    {
        $informes = Informe::all();

        return view('informes/informes')->with(["informes" => $informes]);
    }

    /**
     * Show the form for creating a new resource and store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function read(Informe $informe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource and update the specified resource in storage.
     */
    public function update(Request $request, Informe $informe = new Informe())
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, Informe $informe = new Informe())
    {
        //
    }
}
