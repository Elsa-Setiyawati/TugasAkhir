@extends('layouts.template')
@section('title','Kategori')
@section('konten')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            @if(Auth::user()->hak_akses == 'Admin Gudang')
                <h4 class="card-title">Data Kategori <a class="btn btn-primary text-white" data-toggle="modal" data-target="#exampleModal" onclick="set_form('Tambah Kategori')" data-whatever="@mdo">Tambah Data</a> </h4>@endif
                @if(Auth::user()->hak_akses == 'Admin Penjualan')
                <h4 class="card-title">Data Kategori </h4> @endif
                @if(Auth::user()->hak_akses == 'Pemilik')
                <h4 class="card-title">Data Kategori </h4> @endif
                <div class="table-responsive m-t-40">
                    <table id="mydatatable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach($data->list as $list)
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$list->kategori_nama}}</td>
                                <td> 
                                    @if(Auth::user()->hak_akses == 'Admin Gudang')
                                    <a class="btn btn-success text-white  ti-pencil-alt" data-toggle="modal" data-target="#exampleModal" onclick="set_form('Edit Data', '{{$list->kategori_id}}', '{{$list->kategori_nama}}')" data-whatever="@mdo"></a>
                                    <a class="btn btn-warning text-white ti-trash" onclick="del_data('{{$list->kategori_id}}')"></a>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <form action="/kategori/store" method="post">
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
                            <input type="hidden" class="form-control" id="kategori_id" name="kategori_id">
                            <label for="kategori_nama" class="control-label">Nama Kategori <span id="alert" class="text-danger"></span></label>
                            <input type="text" onchange="cek(this.value)" class="form-control" required id="kategori_nama" name="kategori_nama">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary btn-submit">Submit</button>
                </div>
            </div>
        </div>
    </form>

</div>

@endsection

@section('js_after')
<script>
var kategori = @json($data->list, JSON_PRETTY_PRINT) ;
var old_nama = null;

    function cek(value){
        $('#alert').text('');
        $('.btn-submit').prop('disabled', false);
        if(old_nama.toLowerCase() != value.toLowerCase()){
            kategori.forEach(myget => {
                if(myget.kategori_nama.toLowerCase() == value.toLowerCase()){
                    $('#alert').text('*Data Sudah digunakan*');
                    $('.btn-submit').prop('disabled', true);
                }
            })
        }
        
    }

    function set_form(title, kategori_id, kategori_nama) {
        old_nama = (kategori_nama) ? kategori_nama : '' ;
        $('#titleModal').text(title);
        $('#kategori_id').val(kategori_id);
        $('#kategori_nama').val(kategori_nama);
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
            window.location.href = window.location.origin + "/kategori/delete/" + id;
        });
    }
</script>
@endsection