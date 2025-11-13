<?php

namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::get();
        return response()->json($clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "type"=>"required",
        ]);
        $client = new Client();
        $client->type=$request->type;
        $client->company_name=$request->company_name;
        $client->identification_number=$request->identification_number;
        $client->telephone=$request->telephone;
        $client->address=$request->address;
        $client->email=$request->email;
        $client->state=$request->state;
        $client->save();
        return response()->json($client);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::find($id);
        return response()->json($client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "type"=>"required",
        ]);
        $client = Client::find($id);
        $client->type=$request->type;
        $client->company_name=$request->company_name;
        $client->identification_number=$request->identification_number;
        $client->telephone=$request->telephone;
        $client->address=$request->address;
        $client->email=$request->email;
        $client->state=$request->state;
        $client->update();
        return response()->json($client);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client=Client::find($id);
        $client->state=false;
        $client->update();
        return response()->json(["message"=>"Client successfully disabled"]);
    }
}
