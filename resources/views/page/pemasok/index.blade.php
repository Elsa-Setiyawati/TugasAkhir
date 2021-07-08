@extends('layouts.template')
@section('title','Pemasok')
@section('konten')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Pemasok <a class="btn btn-primary text-white" data-toggle="modal" data-target="#exampleModal" onclick="set_form('Tambah Data')" data-whatever="@mdo">Tambah Data</a> </h4>
                <div class="table-responsive m-t-40">
                    <table id="mydatatable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No Telp</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach($data->list as $list)
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$list->pemasok_nama}}</td>
                                <td>{{$list->pemasok_alamat}}</td>
                                <td>{{$list->pemasok_notelp}}</td>
                                <td>
                                    <a class="btn btn-success text-white  ti-pencil-alt" data-toggle="modal" data-target="#exampleModal" onclick="set_form('Edit Data', '{{$list->pemasok_id}}', '{{$list->pemasok_nama}}', '{{$list->pemasok_alamat}}', '{{$list->pemasok_notelp}}' )" data-whatever="@mdo"></a>
                                    <a class="btn btn-warning text-white ti-trash" onclick="del_data('{{$list->pemasok_id}}')"></a>

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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <form action="/pemasok/store" method="post">
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
                            <input type="hidden" class="form-control" id="pemasok_id" name="pemasok_id">
                            <label for="pemasok_nama" class="control-label">Nama <span id="alert" class="text-danger"></span></label>
                            <input type="text" onchange="cek(this.value)" class="form-control" required id="pemasok_nama" name="pemasok_nama">
                            </div>
                            <div class="form-group">
                            <label for="pemasok_alamat" class="control-label">Alamat</label>
                            <input type="text" class="form-control" required id="pemasok_alamat" name="pemasok_alamat">
                            </div>
                            <div class="form-group">
                            <label for="pemasok_notelp" class="control-label">No Telp</label>
                            <input type="text" class="form-control" required id="pemasok_notelp" name="pemasok_notelp">
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
var pemasok = @json($data->list, JSON_PRETTY_PRINT) ;
var old_nama = null;

    function cek(value){
        $('#alert').text('');
        $('.btn-submit').prop('disabled', false);
        if(old_nama.toLowerCase() != value.toLowerCase()){
            pemasok.forEach(myget => {
                if(myget.pemasok_nama.toLowerCase() == value.toLowerCase()){
                    $('#alert').text('*Data Sudah digunakan*');
                    $('.btn-submit').prop('disabled', true);
                }
            })
        }
        
    }

    function set_form(title, pemasok_id, pemasok_nama, pemasok_alamat, pemasok_notelp ) {
        old_nama = (pemasok_nama) ? pemasok_nama : '' ;
        $('#titleModal').text(title);
        $('#pemasok_id').val(pemasok_id);
        $('#pemasok_nama').val(pemasok_nama);
        $('#pemasok_alamat').val(pemasok_alamat);
        $('#pemasok_notelp').val(pemasok_notelp);
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
            window.location.href = window.location.origin + "/pemasok/delete/" + id;
        });
    }
</script>
@endsection