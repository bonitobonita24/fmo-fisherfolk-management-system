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
        // Add status field to fisherfolk table
        Schema::table('fisherfolk', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])->default('active')->after('aquaculture');
        });

        // Create fisherfolk_renewals table to track renewal history
        Schema::create('fisherfolk_renewals', function (Blueprint $table) {
            $table->id();
            $table->string('fisherfolk_id', 50);
            $table->date('renewal_date');
            $table->year('renewal_year');
            $table->text('notes')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->foreign('fisherfolk_id')->references('id_number')->on('fisherfolk')->onDelete('cascade');
            $table->index(['fisherfolk_id', 'renewal_year']);
            $table->index('renewal_year');
        });

        // Create fisherfolk_status_history table to track status changes
        Schema::create('fisherfolk_status_history', function (Blueprint $table) {
            $table->id();
            $table->string('fisherfolk_id', 50);
            $table->enum('old_status', ['active', 'inactive'])->nullable();
            $table->enum('new_status', ['active', 'inactive']);
            $table->enum('reason', ['manual', 'auto_inactive_january', 'renewal', 'new_registration'])->default('manual');
            $table->text('notes')->nullable();
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->foreign('fisherfolk_id')->references('id_number')->on('fisherfolk')->onDelete('cascade');
            $table->index(['fisherfolk_id', 'created_at']);
            $table->index('reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fisherfolk_status_history');
        Schema::dropIfExists('fisherfolk_renewals');
        
        Schema::table('fisherfolk', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
