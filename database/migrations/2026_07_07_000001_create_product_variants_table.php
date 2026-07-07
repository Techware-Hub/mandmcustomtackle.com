<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('color_name');
            $table->string('weight');
            $table->decimal('price', 10, 2);
            $table->string('sku')->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->string('status')->default('active');
            $table->timestamps();

            $table->unique(['product_id', 'color_name', 'weight']);
            $table->index(['color_name', 'weight', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
