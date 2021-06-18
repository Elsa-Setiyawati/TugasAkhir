@extends('layouts.template')
@section('title','Penjualan')
@section('konten')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Penjualan <a class="btn btn-primary text-white" href="/penjualan/transaksi" >Tambah Data</a> </h4>
                <div class="table-responsive m-t-40">
                    <table id="mydatatable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No Faktur</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Nominal</th>
                                <th>Diskon</th>
                                <th>Total</th>
                                <th>Retur</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach($data->list as $list)
                            @php $tot = $list->jual_tot_jual - $list->jual_diskon_jual; @endphp
                            <tr>
                                <td>JL-{{$list->jual_id}}</td>
                                <td>@date($list->jual_tgl)</td>
                                <td>{{$list->pelanggan_nama}}</td>
                                <td>@rp($list->jual_tot_jual)</td>
                                <td>@rp($list->jual_diskon_jual)</td>
                                <td>@rp($tot)</td>
                                <td>@rp($list->jual_tot_retur_jual)</td>
                                <td>
                                    <a class="btn btn-info text-white" href="/penjualan/transaksi/{{$list->jual_id}}/detail">Detail</a>
                                    <a class="btn btn-warning text-white" href="/penjualan/transaksi/{{$list->jual_id}}/retur">Retur</a>

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
