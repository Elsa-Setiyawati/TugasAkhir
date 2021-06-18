<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreatePembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian', function (Blueprint $table) {
            $table->increments('beli_id');
            $table->string('beli_no_nota');
            $table->date('beli_tgl')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedInteger('beli_user_id');
            $table->unsignedInteger('beli_pemasok_id');
            $table->foreign('beli_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('beli_pemasok_id')->references('pemasok_id')->on('pemasok')->onDelete('cascade');
            $table->decimal('beli_tot_beli' , 15, 2);
            $table->decimal('beli_tot_retur_beli', 15, 2)->default(0);;
            $table->decimal('beli_diskon_beli', 15, 2);
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
        Schema::dropIfExists('pembelian');
    }
}
