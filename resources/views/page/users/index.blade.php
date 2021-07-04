@extends('layouts.template')
@section('title','Users')
@section('konten')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data User <a class="btn btn-primary text-white" data-toggle="modal" data-target="#exampleModal" onclick="set_form('Tambah Data')" data-whatever="@mdo">Tambah Data</a> </h4>
                <div class="table-responsive m-t-40">
                    <table id="mydatatable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Hak Akses</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach($data->list as $list)
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$list->name}}</td>
                                <td>{{$list->email}}</td>
                                <td>{{$list->hak_akses}}</td>
                                <td>
                                    <a class="btn btn-info text-white" data-toggle="modal" data-target="#exampleModal" onclick="set_form('Edit Data', '{{$list->id}}', '{{$list->name}}', '{{$list->email}}', '{{$list->hak_akses}}' )" data-whatever="@mdo">Edit</a>
                                    <a class="btn btn-danger text-white" onclick="del_data('{{$list->id}}')">Hapus</a>

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
    <form action="/users/store" method="post">
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
                            <input type="hidden" class="form-control" id="id" name="id">
                            <label for="name" class="control-label">Nama</label>
                            <input type="text" class="form-control" required id="name" name="name">
                            </div>
                            <div class="form-group">
                            <label for="email" class="control-label">Email</label>
                            <input type="text" class="form-control" required id="email" name="email">
                            </div>
                            <div class="form-group">
                            <label for="password" class="control-label">password <span id="password_show" class="text-danger">Isi Password jika ingin merubahnya</span></label>
                            <input type="text" class="form-control" id="password" name="password">
                            </div>
                            <div class="form-group">
                            <label for="hak_akses" class="form-label">Hak Akses</label>
                            <select name="hak_akses" class="form-control" class="form-control" id="hak_akses" aria-describedby="nama" required/>
                                <option value="">--Pilih Hak Akses--</option>
                                <option value="Pemilik">Pemilik</option>
                                <option value="Admin Gudang">Admin Gudang</option>
                                <option value="Admin Penjualan">Admin Penjualan</option>
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
    function set_form(title, id,name, email, hak_akses ) {
        var x = document.getElementById("password_show");
  if (title=='Edit Data') {
    document.getElementById("password").removeAttribute("required"); 
    x.style.display = "block";
  } else {
    document.getElementById("password").setAttribute("required",""); 
    x.style.display = "none";
  }
        $('#titleModal').text(title);
        $('#id').val(id);
        $('#name').val(name);
        $('#email').val(email);
        $('#password').val("");
        $('#hak_akses').val(hak_akses);
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
            window.location.href = window.location.origin + "/users/delete/" + id;
        });
    }
</script>
@endsection