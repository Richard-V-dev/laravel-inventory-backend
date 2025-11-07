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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            $table->string("name",200);
            $table->text("description")->nullable();
            $table->string("unit_of_messurement",20)->nullable();
            $table->string("brand",50)->nullable();
            $table->decimal("selling_price",12,2)->default(0);
            $table->string("image")->nullable();
            $table->boolean("state")->default(true);

            $table->bigInteger("category_id")->unsigned();
            $table->foreign("category_id")->references("id")->on("categories");
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
