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
                                <th>No</th>
                                <th>Faktur</th>
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
                                <td>{{$no}}</td>
                                <td>{{$list->jual_no_nota}}</td>
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

@section('js_after')
<script>
    function set_form(title, pelanggan_id, pelanggan_nama, pelanggan_alamat, pelanggan_notelp ) {
        $('#titleModal').text(title);
        $('#pelanggan_id').val(pelanggan_id);
        $('#pelanggan_nama').val(pelanggan_nama);
        $('#pelanggan_alamat').val(pelanggan_alamat);
        $('#pelanggan_notelp').val(pelanggan_notelp);
    }

    function del_data(id) {
        swal({
            title: "Hapus Data",
            text: "Anda Yakin Menghapus Data ini ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Tidak",
            confirmButtonColor: "#DD6B55",
            closeOnConfirm: false
        }, function() {
            window.location.href = window.location.origin + "/pelanggan/delete/" + id;
        });
    }
</script>
@endsection