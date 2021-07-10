@extends('layouts.template')
@section('title','Barang')
@section('konten')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            @if(Auth::user()->hak_akses == 'Admin Gudang')
                <h4 class="card-title">Data Barang <a class="btn btn-primary text-white" data-toggle="modal" data-target="#exampleModal" onclick="set_form('Tambah Data')" data-whatever="@mdo">Tambah Data</a> </h4> @endif
                @if(Auth::user()->hak_akses == 'Admin Penjualan')
                <h4 class="card-title">Data Barang </h4> @endif
                <div class="table-responsive m-t-40">
                    <table id="mydatatable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Persentase Laba (%)</th>
                                <th>Stok</th>
                                <th>Harga Beli</th>
                                <th>Harga Pokok</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach($data->list as $list)
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$list->barang_nama}}</td>
                                <td>{{$list->kategori_nama}}</td>
                                <td>{{$list->barang_profit}}</td>
                                <td>{{$list->barang_stok}}</td>
                                <td>@rp($list->barang_hargabeli)</td>
                                <td>@rp($list->barang_hargapokok)</td>   
                                <td>
                                @if(Auth::user()->hak_akses == 'Admin Gudang')
                                    <a class="btn btn-success text-white  ti-pencil-alt" data-toggle="modal" data-target="#exampleModal" onclick="set_form('Edit Data', '{{$list->barang_id}}', '{{$list->barang_nama}}', '{{$list->barang_profit}}', '{{$list->barang_stok}}', '{{$list->barang_hargabeli}}', '{{$list->barang_hargapokok}}', '{{$list->barang_kategori_id}}',)" data-whatever="@mdo"></a>
                                    <a class="btn btn-warning text-white ti-trash" onclick="del_data('{{$list->barang_id}}')"></a>
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
    <form action="/barang/store" method="post">
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
                            <input type="hidden" class="form-control" id="barang_id" name="barang_id">
                            <label for="barang_nama" class="control-label">Nama Barang <span id="alert" class="text-danger"></span></label>
                            <input type="text" onchange="cek(this.value)" class="form-control" required id="barang_nama" name="barang_nama">
                        </div>
                        <div class="form-group">
                            <label for="barang_profit" class="control-label">Persentase Laba (%)</label>
                            <input type="number" min="0" class="form-control" required id="barang_profit" name="barang_profit">
                        </div>
                        <div class="form-group">
                            <label for="barang_stok" class="control-label">Stok</label>
                            <input type="number" min="0" class="form-control" required id="barang_stok" name="barang_stok">
                        </div>
                        <div class="form-group">
                            <label for="barang_hargabeli" class="control-label">Harga Beli</label>
                            <input type="number" min="0" class="form-control" required id="barang_hargabeli" name="barang_hargabeli">
                        </div>
                        <div class="form-group">
                            <label for="barang_hargapokok" class="control-label">Harga Pokok</label>
                            <input type="number" min="0" class="form-control" required id="barang_hargapokok" name="barang_hargapokok">
                        </div>                       
                        <div class="form-group">
                            <label for="barang_kategori_id" class="control-label" >Kategori</label>
                            <select
                            required
                                id="barang_kategori_id"
                                class="form-control select2"
                                name="barang_kategori_id"
                                data-value="{{@$data->barang_kategori_id}}"
                                data-placeholder="Pilih Kategori" data-allow-clear="true"
                            >
                            <option value="">==Pilih Data==</option>
                                @foreach(@$data->kategori as $kategori)
                                    <option value="{{ $kategori->kategori_id }}">{{ $kategori->kategori_nama }}</option>
                                @endforeach
                            </select>
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
var barang = @json($data->list, JSON_PRETTY_PRINT) ;
var old_nama = null;

    function cek(value){
        $('#alert').text('');
        $('.btn-submit').prop('disabled', false);
        if(old_nama.toLowerCase() != value.toLowerCase()){
            barang.forEach(myget => {
                if(myget.barang_nama.toLowerCase() == value.toLowerCase()){
                    $('#alert').text('*Data Sudah digunakan*');
                    $('.btn-submit').prop('disabled', true);
                }
            })
        }
        
    }
    function set_form(title, barang_id, barang_nama, barang_profit, barang_stok, barang_hargabeli, barang_hargapokok,barang_kategori_id) {
        old_nama = (barang_nama) ? barang_nama : '' ;
        $('#titleModal').text(title);
        $('#barang_id').val(barang_id);
        $('#barang_nama').val(barang_nama); 
        $('#barang_profit').val(barang_profit); 
        $('#barang_stok').val(barang_stok);
        $('#barang_hargabeli').val(barang_hargabeli);
        $('#barang_hargapokok').val(barang_hargapokok);
        $('#barang_kategori_id').val(barang_kategori_id);
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
            window.location.href = window.location.origin + "/barang/delete/" + id;
        });
    }
</script>
@endsection