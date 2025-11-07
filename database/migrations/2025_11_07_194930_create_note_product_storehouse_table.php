<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('note_product_storehouse', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger("note_id")->unsigned();
            $table->bigInteger("product_id")->unsigned();
            $table->bigInteger("storehouse_id")->unsigned();
            
            $table->integer("quantity")->default(1);
            $table->string("movement_type",30)->nullable();
            $table->decimal("unit_purchase_price",12,2)->default(0);
            $table->decimal("unit_sales_price",12,2)->default(0);
            $table->text("observations")->nullable();
            
            $table->foreign("note_id")->references("id")->on("notes");
            $table->foreign("product_id")->references("id")->on("products");
            $table->foreign("storehouse_id")->references("id")->on("storehouses");
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movement');
    }
};
