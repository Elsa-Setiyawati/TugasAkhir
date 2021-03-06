@extends('layouts.template')
@section('title','Pelanggan')
@section('konten')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            @if(Auth::user()->hak_akses == 'Admin Penjualan')
                <h4 class="card-title">Data Pelanggan <a class="btn btn-primary text-white" data-toggle="modal" data-target="#exampleModal" onclick="set_form('Tambah Pelanggan')" data-whatever="@mdo">Tambah Data</a> </h4> @endif
                @if(Auth::user()->hak_akses == 'Pemilik')
                <h4 class="card-title">Data Pelanggan </h4> @endif
                <div class="table-responsive m-t-40">
                    <table id="mydatatable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No Telp</th>
                                @if(Auth::user()->hak_akses == 'Admin Penjualan')
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach($data->list as $list)
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$list->pelanggan_nama}}</td>
                                <td>{{$list->pelanggan_alamat}}</td>
                                <td>{{$list->pelanggan_notelp}}</td>
                                @if(Auth::user()->hak_akses == 'Admin Penjualan')
                                <td>
                                    <a class="btn btn-success text-white  ti-pencil-alt" data-toggle="modal" data-target="#exampleModal" onclick="set_form('Edit Data', '{{$list->pelanggan_id}}', '{{$list->pelanggan_nama}}', '{{$list->pelanggan_alamat}}', '{{$list->pelanggan_notelp}}' )" data-whatever="@mdo"></a>
                                    <a class="btn btn-warning text-white ti-trash" onclick="del_data('{{$list->pelanggan_id}}')"></a>  

                                </td>
                                @endif
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <form action="/pelanggan/store" method="post">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titleModal">New message</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="pelanggan_id" name="pelanggan_id">
                            <label for="pelanggan_nama" class="control-label">Nama <span id="alert" class="text-danger"></span></label>
                            <input type="text" onchange="cek(this.value)" class="form-control" required id="pelanggan_nama" name="pelanggan_nama">
                            </div>
                            <div class="form-group">
                            <label for="pelanggan_alamat" class="control-label">Alamat</label>
                            <input type="text" class="form-control" required id="pelanggan_alamat" name="pelanggan_alamat">
                            </div>
                            <div class="form-group">
                            <label for="pelanggan_notelp" class="control-label">No Telp</label>
                            <input type="text" class="form-control" required id="pelanggan_notelp" name="pelanggan_notelp">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary btn-submit">Submit</button>
                </div>
            </div>
        </div>
    </form>

</div>

@endsection

@section('js_after')
<script>
var pelanggan = @json($data->list, JSON_PRETTY_PRINT) ;
var old_nama = null;

    function cek(value){
        $('#alert').text('');
        $('.btn-submit').prop('disabled', false);
        if(old_nama.toLowerCase() != value.toLowerCase()){
            pelanggan.forEach(myget => {
                if(myget.pelanggan_nama.toLowerCase() == value.toLowerCase()){
                    $('#alert').text('*Data Sudah digunakan*');
                    $('.btn-submit').prop('disabled', true);
                }
            })
        }
        
    }
    function set_form(title, pelanggan_id, pelanggan_nama, pelanggan_alamat, pelanggan_notelp ) {
        old_nama = (pelanggan_nama) ? pelanggan_nama : '' ;
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