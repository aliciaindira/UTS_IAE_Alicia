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

            $table->string('name'); // Nama produk

            $table->integer('price'); // Harga produk

            $table->enum('category', ['Kaos', 'Kemeja', 'Dress', 'Skirt', 'Jeans']); // Kategori produk

            $table->enum('size', ['S', 'M', 'L', 'XL', 'XXL']); // Ukuran produk

            $table->string('color'); // Warna produk

            $table->integer('stock'); // Stok produk

            $table->text('description')->nullable(); // Deskripsi produk

            $table->enum('material', ['Cotton', 'Denim', 'Silk', 'Satin']); // Material produk (tidak nullable karena required di validasi)

            $table->timestamps(); // Kolom created_at dan updated_at

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
