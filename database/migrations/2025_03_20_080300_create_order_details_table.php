<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); 
            $table->integer('quantity');
            $table->decimal('price', 10, 2); 
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
