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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
     
            $table->dateTime("date");
            $table->string("note_type",20)->nullable();
            $table->decimal("taxes",12,2)->nullable();
            $table->decimal("discounts",12,2)->nullable();
            $table->decimal("total_calculated",12,2)->nullable();
            $table->string("note_state",50)->nullable();
            $table->text("observations")->nullable();

            $table->bigInteger("client_id")->unsigned();
            $table->bigInteger("user_id")->unsigned();

            $table->foreign("client_id")->references("id")->on("clients");
            $table->foreign("user_id")->references("id")->on("users");
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
