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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('brand');             // Nama brand fashion
            $table->string('name');              // Nama produk
            $table->string('category');          // Kategori fashion (Shoes, Hoodie, Bag, dll)
            $table->integer('price');            // Harga
            $table->text('description')->nullable();  // Deskripsi produk
            $table->string('image_url')->nullable();  // Link gambar produk
            $table->timestamps();                // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
