@extends('layouts.template')
@section('title','Laporan Kartu Gudang')
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
            <div class="font-w600 text-uppercase text-center"><b> Kartu Gudang</b></div>
            <div class="font-w600 text-uppercase text-center"><b> TOKO BINTANG ELEKTRONIK</b></div>
            <div class="font-w600 text-uppercase text-center">periode @date($data->startdate) s.d @date($data->enddate)</div><br />
            <div class="font-w600 text-uppercase text-left"><b> Nama Barang : {{$data->barangpilih->barang_nama}} </b></div> <br>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Masuk</th>
                            <th class="text-center">Keluar</th>
                            <th class="text-center">Sisa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1; $sisa = 0;   @endphp
                        @if($data->persediaan_awal>0)
                        <tr>
                            <td class="font-w600 text-center">{{($no=1)}}</td>
                            <td class="font-w600 text-center">@date($data->startdate) </td>
                            <td class="font-w600 text-center"></td>
                            <td class="font-w600 text-center"></td>
                            <td class="font-w600 text-center">{{($data->persediaan_awal)}}</td>
                        </tr>
                        @php $no=1+1; $sisa = $data->persediaan_awal;  @endphp
                        @endif
                        @foreach($data->list as $list)
                        @php $sisa = $sisa + $list->kp_qty; @endphp
                        <tr>
                            <td class="font-w600 text-center">{{($no)}}</td>
                            <td class="font-w600 text-center">@date($list->kp_tgl) </td>
                            <td class="font-w600 text-center">
                            @if($list->kp_jenis == 'Pembelian'){{+($list->kp_qty)}}  @endif
                            </td>
                            <td class="font-w600 text-center">
                            @if($list->kp_jenis == 'Penjualan'){{-($list->kp_qty)}}  @endif
                            </td>
                            <td class="font-w600 text-center">{{($sisa)}}</td>
                        </tr>
                        @php $no++; @endphp 
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<div class="modal fade " data-backdrop="false" id="modal-fromleft" width="600px" tabindex="+1" role="dialog" aria-labelledby="smallmodalLabel" >
    <div class="modal-dialog modal-md" role="document">
    <form action="/lap_kartu_gudang" method="get">
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smallmodalLabel">Periode Laporan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="form-group row">
                            <div class="col-12">
                                <div class="form-material">
                                <label for="barang_id" class="control-label">Barang</label>
                                <select
                                    required
                                    id="barang_id"
                                    class="form-control select2"
                                    name="barang_id"
                                    data-placeholder="Pilih Barang" data-allow-clear="true"
                                    
                                >
                                <option value="">==Pilih Data==</option>
                                    @foreach(@$data->barang as $barang)
                                        <option value="{{ $barang->barang_id }}" @if($barang->barang_id==$data->barang_id) selected @endif >{{ $barang->barang_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
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