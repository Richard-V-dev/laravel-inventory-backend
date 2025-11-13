<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Person;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $people = Person::get();
        return response()->json($people);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "full_name"=>"required",
            "user_id"=>"required",
        ]);
        $person = new Person();
        $person -> full_name = $request -> full_name;
        $person -> ci_nit = $request -> ci_nit;
        $person -> address = $request -> address;
        $person -> telephone = $request -> telephone;
        $person -> state = $request -> state;
        $person -> user_id = $request -> user_id;
        $person->save();
        return response()->json(["message"=>"Person successfully created"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $person = Person::find($id);
        return response()->json($person);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "full_name"=>"required",
            "user_id"=>"required",
        ]);
        $person = Person::find($id);
        $person -> full_name = $request -> full_name;
        $person -> ci_nit = $request -> ci_nit;
        $person -> address = $request -> address;
        $person -> telephone = $request -> telephone;
        $person -> state = $request -> state;
        $person -> user_id = $request -> user_id;
        $person->update();
        return response()->json(["message"=>"Person successfully created"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $person = Person::find($id);
        $person->state=false;
        $person->update();
        return response()->json(["message"=>"Person successfully disabled"]);        
    }
}
