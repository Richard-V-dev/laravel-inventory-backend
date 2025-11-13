<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query=Note::with(["user","client"]);
        if($request->has("note_type")){
            $query->where("note_type",$request->note_type);
        }
        if($request->has("note_state")){
            $query->where("note_state",$request->note_state);
        }
        if($request->has("client_id")){
            $query->where("client_id",$request->client_id);
        }
        if($request->has("user_id")){
            $query->where("user_id",$request->note_type);
        }
        if($request->has(["start_date","end_date"])){
            $query->where("date",[$request->start_date,$request->end_date]);
        }
        if($request->has('search')){
            $query->where("observations","like","%".$request->search."%");
        }
        $notes = $query->orderByDesc("date")->paginate(10);
        return response()->json($notes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "note_type"=>"required|in:sale,purchase,return",
            "client_id"=>"required",
            "user_id"=>"required"
        ]);
        $note = new Note();
        $note->date = date("Y-m-d H:i:s"); 
        $note->note_type = $request->note_type ;   
        $note->taxes = $request->taxes ;   
        $note->discounts = $request->discounts ;   
        $note->total_calculated = $request->total_calculated ;   
        $note->note_state = $request->note_state ;   
        $note->observations = $request->observations ;  
        $note->client_id = $request->client_id ; 
        $note->user_id = $request->user_id ;  
        $note->save();
        return response()->json(["message"=>"Note successfully created","note"=>$note],201);    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $note = Note::find($id);
        return response()->json($note);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "note_type"=>"required|in:sale,purchase,return",
            "client_id"=>"required",
            "user_id"=>"required"
        ]);
        $note = Note::find($id); 
        $note->note_type = $request->note_type ;   
        $note->taxes = $request->taxes ;   
        $note->discounts = $request->discounts ;   
        $note->total_calculated = $request->total_calculated ;   
        $note->note_state = $request->note_state ;   
        $note->observations = $request->observations ;  
        $note->client_id = $request->client_id ; 
        $note->user_id = $request->user_id ;  
        $note->update();
        return response()->json(["message"=>"Note successfully updated"]);    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
