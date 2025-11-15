<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Exception;
use Illuminate\Support\Facades\DB;
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
            "date"=>"nullable|date",
            "note_type"=>"required|in:sale,purchase,return",
            "taxes"=>"nullable",
            "discounts"=>"nullable",
            "total_calculated"=>"nullable",
            "note_state"=>"nullable|string",
            "observations"=>"nullable|string",
            "client_id"=>"required|exists:clients,id",
            "user_id"=>"required",
            "movements"=>"required|array|min:1",
                "movements.*.product_id"=>"required|exists:product,id",
                "movements.*.storehouse_id"=>"required|exists:storehouse,id",
                "movements.*.quantity"=>"required|quantity|min:1",
                "movements.*.movement_type"=>"required|in:entry,exit,return",
                "movements.*.unit_purchase_price"=>"required",
                "movements.*.unit_sales_price"=>"required",
                "movements.*.observations"=>"nullable|string",

        ]);
        DB::beginTransaction();
        try{
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

            foreach($request->movements as $movs){
                $note->movements()->attach($movs['storehouse_id'],[
                    "product_id"=>$movs['product_id'],
                    "quantity"=>$movs["quantity"],
                    "movement_type"=>$movs["movement_type"],
                    "unit_purchase_price"=>$movs["unit_purchase_price"],
                    "unit_sales_price"=>$movs["unit_sales_price"],
                    "observations"=>$movs["observations"]??null
                ]);
                $pivot = DB::table("product_storehouse")
                            ->where("storehouse_id",$movs["storehouse_id"])
                            ->where("product_id",$movs["product_id"])
                            ->first();
                if(!$pivot){
                    if($movs["movement_type"]==="exit"){
                        throw new Exception("No stock in this storehouse for this product to be delivered");
                    }
                    DB::table("product_storehouse")->insert([
                        "storehouse_id"=>$movs["storehouse_id"],
                        "product_id"=>$movs["product_id"],
                        "current_quantity"=>$movs["quantity"],
                        "update_date"=>now()
                    ]);
                }else{
                    $newQuantity = $pivot->current_quantity;
                    if($movs["movement_type"]==="return"||$movs["movement_type"]==="entry"){
                        $newQuantity += $movs["quantity"];
                    }elseif($movs["movement_type"]==="exit"){
                        if($pivot->current_quantity<$movs["quantity"]){
                            throw new Exception("Not sufficient stock for exiting ");
                        }
                        $newQuantity -= $movs["quantity"];
                    }
                    DB::table("product_storehouse")
                            ->where("storehouse_id",$movs["storehouse_id"])
                            ->where("product_id",$movs["product_id"])
                            ->update([
                                "current_quantity"=>$newQuantity,
                                "update_date"=>now()
                            ]);
                    
                }
            }
            DB::commit();
            return response()->json(["message"=>"Note successfully created","note"=>$note->load("movements")],201);
        }catch(Exception $e){
            DB::rollback();
            return response()->json(["error" => $e->getMessage()], 500);
        }
            
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
