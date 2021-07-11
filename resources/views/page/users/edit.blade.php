@extends('layouts.template')
@section('title','Users')
@section('konten')
<form action="/users/store" method="post">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titleModal">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                    @foreach($data->list as $list)
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="id" name="id" value="{{$list->id }}">
                            <label for="name" class="control-label">Nama <span id="alert" class="text-danger"></span></label>
                            <input type="text" onchange="cek(this.value)" class="form-control" required id="name" name="name" value="{{$list->name}}">
                            </div>
                            <div class="form-group">
                            <label for="email" class="control-label">Email</label> 
                            <input type="text" class="form-control" required id="email" name="email" value="{{$list->email}}">
                            </div>
                            <div class="form-group">
                            <label for="password" class="control-label">password <span id="password_show" class="text-danger">Isi Password jika ingin merubahnya</span></label>
                            <input type="text" class="form-control" id="password" name="password" >
                            </div>
                            @endforeach
                            <div class="form-group">
                            <label for="hak_akses" class="form-label">Hak Akses</label>
                            <select name="hak_akses" class="form-control" class="form-control" id="hak_akses" aria-describedby="nama" required/> 
                                <option value="">--Pilih Hak Akses--</option>
                                <option value="Admin Gudang" @if($data->users->role_id=='1') selected @endif>Admin Gudang</option>
                                @if(Auth::user()->role_id == '2')
                                <option value="Admin Penjualan" @if($data->users->role_id=='2') selected @endif>Admin Penjualan</option>
                                @if(Auth::user()->role_id == '3')
                                <option value="Pemilik" @if($data->users->role_id=='3') selected @endif>Pemilik</option>
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
    
@endsection

@section('js_after')
<script>
var users = @json($data->list, JSON_PRETTY_PRINT) ;
var old_nama = null;

    function cek(value){
        $('#alert').text('');
        $('.btn-submit').prop('disabled', false);
        if(old_nama.toLowerCase() != value.toLowerCase()){
            users.forEach(myget => {
                if(myget.name.toLowerCase() == value.toLowerCase()){
                    $('#alert').text('*Data Sudah digunakan*');
                    $('.btn-submit').prop('disabled', true);
                }
            })
        }
        
    }
    function set_form(title, id,name, email, hak_akses ) {
        old_nama = (name) ? name : '' ;
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

    // function del_data(id) {
    //     swal({
    //         title: "Hapus Data",
    //         text: "Anda Yakin Menghapus Data ini ?",
    //         type: "warning",
    //         showCancelButton: true,
    //         confirmButtonText: "Ya, Hapus!",
    //         cancelButtonText: "Tidak",
    //         confirmButtonColor: "#DD6B55",
    //         closeOnConfirm: false
    //     }, function() {
    //         window.location.href = window.location.origin + "/users/delete/" + id;
    //     });
    // }
</script>
@endsection