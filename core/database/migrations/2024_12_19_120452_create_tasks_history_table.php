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
        Schema::create('tasks_history', function (Blueprint $table) {
            $table->timestamps();
            $table->string('name');
            $table->string('description');
            $table->enum('priority', ['low','medium', 'high']);
            $table->enum('status', ['to-do', 'in progress', 'done']);
            $table->datetime('start_time');
            $table->time('req_time');
            $table->foreignId('task_id')->constrained()->onDelete('cascade');;        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks_history');
    }
};
