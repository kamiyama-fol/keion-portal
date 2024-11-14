<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Models\Studio;
/**
 * 予約するスタジオを制御するコントローラ
 */

class StudioController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if (Auth::user()->admin != 1){
            return redirect('/');
        }
        
        //$studios = ;
        return view('studios.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        
        if (Auth::user()->admin != 1){
            return redirect('/');
        }
        return view('studios.create');
        
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->admin != 1){
            return redirect('/');
        }
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (Auth::user()->admin != 1){
            return redirect('/');
        }
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Auth::user()->admin != 1){
            return redirect('/');
        }
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Auth::user()->admin != 1){
            return redirect('/');
        }
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::user()->admin != 1){
            return redirect('/');
        }
        //
    }
}
