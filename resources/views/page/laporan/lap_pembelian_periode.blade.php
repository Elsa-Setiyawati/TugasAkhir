@extends('layouts.template')
@section('title','Laporan Pembelian Per Periode')
@section('konten')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
    <div class="block block-themed block-rounded">
        <div class="block-header bg-gd-primary">
            <btn class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-fromleft">Periode</btn>
            <btn class="btn btn-secondary btn-sm" onclick="printDiv('print')">Print</btn>
        </div>
        <div id="print" class="block-content">
            <div class="font-w600 text-uppercase text-center"><b>Laporan Pembelian Per Periode</b></div>
            <div class="font-w600 text-uppercase text-center"><b> TOKO BINTANG ELEKTRONIK</b></div>
            <div class="font-w600 text-uppercase text-center">periode @date($data->startdate) s.d @date($data->enddate)</div><br />
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">No Faktur Beli</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">User</th>
                            <th class="text-center">Pemasok</th>
                            <th class="text-center">Nama Barang</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center" >Total</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1;  $beli_tot_beli=0; @endphp
                        @foreach($data->list as $list)
                        @php $tot = $list->dbeli_jml*$list->dbeli_harga; @endphp
                        @php $beli_tot_beli = $beli_tot_beli + $tot; @endphp
                        <tr>
                            <td class="font-w600 text-center">{{($no)}}</td>
                            <td class="font-w600 text-center">BL-{{($list->beli_id)}}</td>
                            <td class="font-w600 text-center">@date($list->beli_tgl) </td>
                            <td class="font-w600 text-center">{{($list->name)}}</td>
                            <td class="font-w600 text-center">{{($list->pemasok_nama)}}</td>
                            <td class="font-w600 text-center">{{($list->barang_nama)}}</td>
                            <td class="font-w600 text-center">{{($list->dbeli_jml)}}</td>
                            <td class="font-w600 text-center">@rp($list->dbeli_harga)</td>
                            <td class="text-right">@rp($tot)</td>
                        </tr>
                        @php  $no=$no+1; @endphp 
                        @endforeach
                    </tbody>
                    <tfood>
                            <tr>
                                <th colspan="8" class="text-right">Total</th>
                                <th colspan="2">@rp($beli_tot_beli)</th>
                            </tr>
                        </tfood>
                </table>
            </div>
        </div>
    </div>
<div class="modal fade " data-backdrop="false" id="modal-fromleft" width="600px" tabindex="+1" role="dialog" aria-labelledby="smallmodalLabel" >
    <div class="modal-dialog modal-md" role="document">
    <form action="/lap_pembelian_periode" method="get">
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smallmodalLabel">Periode Laporan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="form-group row">
                            <div class="col-6">
                                <div class="form-material">
                                <label for="startdate">Mulai</label>
                                    <input type="date" class="form-control" id="startdate" value="{{$data->startdate}}" name="startdate">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-material">
                                <label for="enddate">Akhir</label>
                                    <input type="date" class="form-control" id="enddate" value="{{$data->enddate}}" name="enddate">
                                </div>
                            </div>
                        </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i> Ubah
                    </button>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
</div>
@endsection