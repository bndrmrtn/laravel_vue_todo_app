<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuschanges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_id')->constrained('statuses')->onDelete('cascade');
            $table->foreignId('todo_id')->constrained('todos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuschanges');
    }
};
