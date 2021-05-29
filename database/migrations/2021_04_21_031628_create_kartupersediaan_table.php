<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateKartupersediaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kartupersediaan', function (Blueprint $table) {
            $table->increments('kp_id');
            $table->date('kp_tgl');
            $table->unsignedInteger('kp_barang_id');
            $table->foreign('kp_barang_id')->references('barang_id')->on('barang')->onDelete('cascade');
            $table->string('kp_jenis');
            $table->string('kp_qty');
            $table->decimal('kp_harga', 15, 2);
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
        Schema::dropIfExists('kartupersediaan');
    }
}
