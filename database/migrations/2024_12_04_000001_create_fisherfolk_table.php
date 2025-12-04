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
        Schema::create('fisherfolk', function (Blueprint $table) {
            $table->string('id_number', 50)->primary();
            $table->string('full_name');
            $table->date('date_of_birth');
            $table->string('address');
            $table->enum('sex', ['Male', 'Female']);
            $table->string('image')->nullable();
            $table->string('signature')->nullable();
            $table->string('rsbsa', 50)->nullable();
            $table->string('contact_number', 20)->nullable();
            
            // Activity Categories (boolean flags)
            $table->boolean('boat_owneroperator')->default(false);
            $table->boolean('capture_fishing')->default(false);
            $table->boolean('gleaning')->default(false);
            $table->boolean('vendor')->default(false);
            $table->boolean('fish_processing')->default(false);
            $table->boolean('aquaculture')->default(false);
            
            $table->timestamp('date_registered')->useCurrent();
            $table->timestamp('date_updated')->useCurrent()->useCurrentOnUpdate();
            
            $table->index('address');
            $table->index('sex');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fisherfolk');
    }
};
