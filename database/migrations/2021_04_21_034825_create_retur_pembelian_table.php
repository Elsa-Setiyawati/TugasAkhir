<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateReturPembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retur_pembelian', function (Blueprint $table) {
            $table->increments('rb_id');
            $table->unsignedInteger('rb_beli_id')->nullable();
            $table->foreign('rb_beli_id')->references('beli_id')->on('pembelian')->onDelete('cascade');
            $table->unsignedInteger('rb_barang_id');
            $table->foreign('rb_barang_id')->references('barang_id')->on('barang')->onDelete('cascade');
            $table->date('rb_tgl');
            $table->string('rb_jml', 50);
            $table->decimal('rb_harga', 15, 2);
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
        Schema::dropIfExists('retur_pembelian');
    }
}
