<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateDetailPenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->increments('djual_id');
            $table->unsignedInteger('djual_jual_id')->nullable();
            $table->foreign('djual_jual_id')->references('jual_id')->on('penjualan')->onDelete('cascade');
            $table->unsignedInteger('djual_barang_id');
            $table->foreign('djual_barang_id')->references('barang_id')->on('barang')->onDelete('cascade');
            $table->string('djual_jml');
            $table->decimal('djual_harga', 15, 2);
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
        Schema::dropIfExists('detail_penjualan');
    }
}
