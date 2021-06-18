<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->increments('barang_id');
            $table->string('barang_nama');
            $table->decimal('barang_hargabeli' , 15, 2);
            $table->decimal('barang_hargapokok' , 15, 2);
            $table->decimal('barang_margin' , 15);
            $table->string('barang_stok');
            $table->unsignedInteger('barang_kategori_id');
            $table->foreign('barang_kategori_id')->references('kategori_id')->on('kategori')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
}
