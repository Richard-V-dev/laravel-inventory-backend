<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::get();
        return response()->json($branches,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name"=>"required",
            "city"=>"required"
        ]);
        $branch = new Branch();
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->telephone = $request->telephone;
        $branch->city = $request->city;
        $branch->save();

        return response()->json(["message"=>"Branch successfully saved","branch"=>$branch,201]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $branch = Branch::find($id);
        return response()->json($branch,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name"=>"required",
            "city"=>"required"
        ]);
        $branch = Branch::find($id);
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->telephone = $request->telephone;
        $branch->city = $request->city;
        $branch->update();

        return response()->json(["message"=>"Branch successfully updated"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
