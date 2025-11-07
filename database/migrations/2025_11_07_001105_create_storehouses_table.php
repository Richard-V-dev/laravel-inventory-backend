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
        Schema::create('storehouses', function (Blueprint $table) {
            $table->id();
            $table->string("name",100);
            $table->string("code",100)->nullable();
            $table->text("description")->nullable();

            //N:1
            $table->bigInteger(("branch_id"))->unsigned();
            $table->foreign("branch_id")->references("id")->on("branches");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storehouses');
    }
};
