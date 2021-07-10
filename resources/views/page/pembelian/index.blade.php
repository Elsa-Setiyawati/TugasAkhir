@extends('layouts.template')
@section('title','Pembelian')
@section('konten')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Pembelian <a class="btn btn-primary text-white" href="/pembelian/transaksi" >Tambah Data</a> </h4>
                <div class="table-responsive m-t-40">
                    <table id="mydatatable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No Faktur</th>
                                <th>Tanggal</th>
                                <th>Pemasok</th>
                                <th>Nominal</th>
                                <th>Retur</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach($data->list as $list)
                            <tr>
                                <td>BL-{{$list->beli_id}}</td>
                                <td>@date($list->beli_tgl)</td>
                                <td>{{$list->pemasok_nama}}</td>
                                <td>@rp($list->beli_tot_beli)</td>
                                <td>@rp($list->beli_tot_retur_beli)</td>
                                <td>
                                    <a class="btn btn-info text-white" href="/pembelian/transaksi/{{$list->beli_id}}/detail">Detail</a>
                                    @if($list->beli_tot_retur_beli==0)
                                    <a class="btn btn-warning text-white" href="/pembelian/transaksi/{{$list->beli_id}}/retur">Retur</a>
                                    @endif
                                </td>
                            </tr>
                            @php $no++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection