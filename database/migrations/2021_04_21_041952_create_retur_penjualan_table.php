<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateReturPenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retur_penjualan', function (Blueprint $table) {
            $table->increments('rj_id');
            $table->unsignedInteger('rj_jual_id')->nullable();
            $table->foreign('rj_jual_id')->references('jual_id')->on('penjualan')->onDelete('cascade');
            $table->unsignedInteger('rj_barang_id');
            $table->foreign('rj_barang_id')->references('barang_id')->on('barang')->onDelete('cascade');
            $table->date('rj_tgl');
            $table->string('rj_jml');
            $table->decimal('rj_harga', 15, 2);
            $table->decimal('rj_total', 15, 2);
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
        Schema::dropIfExists('retur_penjualan');
    }
}
