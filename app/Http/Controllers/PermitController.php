<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permit;

class PermitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permits = Permit::get();
        return response()->json($permits);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            "name"=>"required"
        ]);
        $permit = new Permit();
        $permit -> name = $request ->name;
        $permit -> description = $request ->description;
        $permit -> subject = $request ->subject;
        $permit -> action = $request ->action;
        $permit -> save();
        return response()->json(["message"=>"Permit successfully created"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permit = Permit::find($id);
        return response()->json($permit);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request -> validate([
            "name"=>"required"
        ]);
        $permit = Permit::find($id);
        $permit -> name = $request ->name;
        $permit -> description = $request ->description;
        $permit -> subject = $request ->subject;
        $permit -> action = $request ->action;
        $permit -> update();
        return response()->json(["message"=>"Permit successfully updated"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permit = Permit::find($id);
        $permit->delete();
        return response()->json(["message"=>"Permit successfully deleted"]);
    }
}
