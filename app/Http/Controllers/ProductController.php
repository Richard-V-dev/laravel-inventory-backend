<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $products = Product::query();

        // Filtrar por estado
        if ($request->has('state')) {
            $products->where('state', $request->state == 'true' ? 1 : 0);
        }


        // Búsqueda por nombre o marca
        if ($request->has('search')) {
            $search = $request->search;
            $products->where(function($query) use ($search) {
                $query->where("name", "like", "%$search%")
                ->orWhere("brand", "like", "%$search%");
            });
        }

        // Relacionar y paginar
        $products = $products->with(["category", "storehouses"])
                        ->orderBy('id', 'desc')
                        ->paginate($request->limit ?? 10);

        return response()->json($products);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name"=>"required",
            "category_id"=>"required"
        ]);
        $product = new Product();
        $product->name=$request->name;
        $product->description=$request->description;
        $product->unit_of_messurement=$request->unit_of_messurement;
        $product->brand=$request->brand;
        $product->selling_price=$request->selling_price;
        $product->image=$request->image;
        $product->state=$request->state;
        $product->category_id=$request->category_id;
        $product->save();

        return response()->json(["message"=>"Product successfully created","product"=>$product],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name"=>"required",
            "category_id"=>"required"
        ]);
        $product = Product::find($id);
        $product->name=$request->name;
        $product->description=$request->description;
        $product->unit_of_messurement=$request->unit_of_messurement;
        $product->brand=$request->brand;
        $product->selling_price=$request->selling_price;
        $product->image=$request->image;
        $product->state=$request->state;
        $product->category_id=$request->category_id;
        $product->update();

        return response()->json(["message"=>"Product successfully updated","product"=>$product]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product=Product::find($id);
        $product->state=false;
        $product->update();
        return response()->json(["message"=>"Product disabled"]);
    }

    public function updateImage(string $id,Request $request)
    {
        $request->validate([
            'image'=>'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);
        $product = Product::findOrFail($id);
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        $path = $request->file('image')->store('products', 'public');
        $product->image = $path;
        $product->save();
        return response()->json([
            'message' => 'Image successfully updated',
            'image_url' => asset('storage/' . $path),
        ], 200);
    }
}
