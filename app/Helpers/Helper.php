<?php


namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
class Helper
{
    public static function rp($p)
    {
        return 'Rp. ' . number_format($p,2,'.',',');
    }
    public static function harga_terbaru($barang_id){
        $databarang = DB::table('kartupersediaan')->where('kp_barang_id', $barang_id)->orderBy('kp_tgl')->get();
        $data =  new \stdClass();
        $data->qty = 0;
        $data->total = 0;
        $data->average = 0;

        foreach($databarang as $barang){
            $data->qty = $data->qty + $barang->kp_qty;
            $data->total = $data->total + $barang->kp_total;
            $data->average = ($data->qty==0) ? 0 : $data->total/$data->qty;
            // $data->average = $data->total/$data->qty;

            // if($barang->kp_jenis == 'Persediaan Awal' || $barang->kp_jenis == 'masuk') {
            //     $data->qty = $data->qty + $barang->kp_qty;
            //     $data->total = $data->total + ($barang->kp_harga*$barang->kp_qty);
            //     if($data->qty==0){
            //         $data->average = 0;
            //     }else{
            //         $data->average = $data->total/$data->qty;
            //     }
                
            // }elseif ($barang->kp_jenis == 'keluar') {
            //     $data->qty = $data->qty - $barang->kp_qty;
            //     $data->total = $data->total - ($barang->kp_harga*$barang->kp_qty);
            //     if($data->qty==0){
            //         $data->average = 0;
            //     }else{
            //         $data->average = $data->total/$data->qty;
            //     }
            // }
        }
        $save_barang = DB::table('barang')->where('barang_id', $barang_id)->update(['barang_hargapokok' => $data->average]);
        return $data;

    }
    public static function persediaan_awal($barang_id, $date){
        $databarang = DB::table('kartupersediaan')->where('kp_barang_id', $barang_id)->where('kp_tgl', '<', $date)->orderBy('kp_tgl')->get();
        $data =  new \stdClass();
        $data->qty = 0;
        $data->total = 0;
        $data->average = 0;

        foreach($databarang as $barang){
            $data->qty = $data->qty + $barang->kp_qty;
            $data->total = $data->total + $barang->kp_total;
            $data->average = ($data->qty==0) ? 0 : $data->total/$data->qty;
            // $data->average = $data->total/$data->qty;
            // if($barang->kp_jenis == 'Persediaan Awal' || $barang->kp_jenis == 'masuk') {
            //     $data->qty = $data->qty + $barang->kp_qty;
            //     $data->total = $data->total + ($barang->kp_harga*$barang->kp_qty);
            //     if($data->qty==0){
            //         $data->average = 0;
            //     }else{
            //         $data->average = $data->total/$data->qty;
            //     }
            // }elseif ($barang->kp_jenis == 'keluar') {
            //     $data->qty = $data->qty - $barang->kp_qty;
            //     $data->total = $data->total - ($barang->kp_harga*$barang->kp_qty);
            //     if($data->qty==0){
            //         $data->average = 0;
            //     }else{
            //         $data->average = $data->total/$data->qty;
            //     }
            // }
        }
        return $data;

    }
}
