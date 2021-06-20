<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreatePenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->increments('jual_id');
            $table->date('jual_tgl')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedInteger('jual_user_id');
            $table->foreign('jual_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('jual_pelanggan_id');
            $table->foreign('jual_pelanggan_id')->references('pelanggan_id')->on('pelanggan')->onDelete('cascade');
            $table->decimal('jual_tot_jual', 15, 2);
            $table->decimal('jual_tot_retur_jual', 15, 2)->default(0);
            $table->decimal('jual_diskon_jual', 15, 2);
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
        Schema::dropIfExists('penjualan');
    }
}
