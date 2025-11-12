<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Storehouse;

class StorehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $storehouses = Storehouse::get();
        return response()->json($storehouses,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name"=>"required",
            "branch_id"=>"required"
        ]);
        $storehouse = new Storehouse();
        $storehouse->name = $request->name;
        $storehouse->code = $request->code;
        $storehouse->description = $request->description;
        $storehouse->branch_id = $request->branch_id;
        $storehouse->save();

        return response()->json(["message"=>"Storehouse successfully created","storehouse"=>$storehouse,201]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $storehouse = Storehouse::find($id);
        return response()->json($storehouse,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name"=>"required",
            "branch_id"=>"required"
        ]);
        $storehouse = Storehouse::find($id);
        $storehouse->name = $request->name;
        $storehouse->code = $request->code;
        $storehouse->description = $request->description;
        $storehouse->branch_id = $request->branch_id;
        $storehouse->update();

        return response()->json(["message"=>"Storehouse successfully updated","storehouse"=>$storehouse,201]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
