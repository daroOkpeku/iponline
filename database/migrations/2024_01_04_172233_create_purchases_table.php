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

    //   "orderid",
    //   "ref",
    //   "userid"
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userid')->references('id')->on('users');
            $table->tinyText('ref')->nullable();
            $table->foreignId('orderid')->references('id')->on('orders');
            $table->tinyText('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
