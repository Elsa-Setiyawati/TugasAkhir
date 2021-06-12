@extends('layouts.template')
@section('title','Barang')
@section('konten')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Barang <a class="btn btn-primary text-white" data-toggle="modal" data-target="#exampleModal" onclick="set_form('Tambah Data')" data-whatever="@mdo">Tambah Data</a> </h4>
                <div class="table-responsive m-t-40">
                    <table id="mydatatable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
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
                                <td>{{$list->barang_stok}}</td>
                                <td>@rp($list->barang_hargabeli)</td>
                                <td>@rp($list->barang_hargajual)</td>   
                                <td>
                                    <a class="btn btn-info text-white" data-toggle="modal" data-target="#exampleModal" onclick="set_form('Edit Data', '{{$list->barang_id}}', '{{$list->barang_nama}}', '{{$list->barang_hargabeli}}', '{{$list->barang_hargajual}}', '{{$list->barang_stok}}', '{{$list->barang_kategori_id}}' )" data-whatever="@mdo">Edit</a>
                                    <a class="btn btn-danger text-white" onclick="del_data('{{$list->barang_id}}')">Hapus</a>

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
                            <label for="barang_nama" class="control-label">Nama Barang</label>
                            <input type="text" class="form-control" required id="barang_nama" name="barang_nama">
                        </div>
                        <div class="form-group">
                            <label for="barang_hargabeli" class="control-label">Harga Beli</label>
                            <input type="number" min="0" class="form-control" required id="barang_hargabeli" name="barang_hargabeli">
                        </div>
                        <div class="form-group">
                            <label for="barang_hargajual" class="control-label">Harga Jual</label>
                            <input type="number" min="0" class="form-control" required id="barang_hargajual" name="barang_hargajual">
                        </div>
                        <div class="form-group">
                            <label for="barang_stok" class="control-label">Stok</label>
                            <input type="number" min="0" class="form-control" required id="barang_stok" name="barang_stok">
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>

</div>

@endsection

@section('js_after')
<script>
    function set_form(title, barang_id, barang_nama, barang_hargabeli, barang_hargajual, barang_stok, barang_kategori_id) {
        $('#titleModal').text(title);
        $('#barang_id').val(barang_id);
        $('#barang_nama').val(barang_nama);
        $('#barang_hargabeli').val(barang_hargabeli);
        $('#barang_hargajual').val(barang_hargajual);
        $('#barang_stok').val(barang_stok);
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