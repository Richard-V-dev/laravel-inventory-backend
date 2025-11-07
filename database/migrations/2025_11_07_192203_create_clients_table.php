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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            
            $table->string("type");
            $table->string("company_name")->nullable();
            $table->string("identification_number",40)->nullable();
            $table->string("telephone",20)->nullable();
            $table->string("address",200)->nullable();
            $table->string("email",250)->nullable();
            $table->boolean("state",30)->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
