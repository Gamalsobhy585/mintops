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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('leader_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index('leader_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void 
    {
        Schema::dropIfExists('teams');
    }
};