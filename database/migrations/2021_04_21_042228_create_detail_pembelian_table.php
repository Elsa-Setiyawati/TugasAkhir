<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateDetailPembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->increments('dbeli_id');
            $table->unsignedInteger('dbeli_beli_id')->nullable();
            $table->unsignedInteger('dbeli_barang_id');
            $table->foreign('dbeli_beli_id')->references('beli_id')->on('pembelian')->onDelete('cascade');
            $table->foreign('dbeli_barang_id')->references('barang_id')->on('barang')->onDelete('cascade');
            $table->string('dbeli_jml', 50);
            $table->decimal('dbeli_harga', 15, 2);
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
        Schema::dropIfExists('detail_pembelian');
    }
}
