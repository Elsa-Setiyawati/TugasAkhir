@extends('layouts.template')
@section('title','Pembelian')
@section('konten')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="/pembelian/save_transaksi" class="row" method="post">
                @csrf
                    <div class="form-group col-4">
                        <input type="hidden" class="form-control" id="beli_id" name="beli_id" value="{{($data->id) ? $data->beli->beli_id : ''}}">
                        <label for="beli_tgl" class="control-label">Tanggal</label>
                        <input type="text" class="form-control" id="beli_tgl" required name="beli_tgl" {{($data->id) ? 'disabled=true' : ''}} value="{{($data->id) ? $data->beli->beli_tgl : ''}}">
                    </div>
                    <div class="form-group col-4">
                        <label for="beli_pemasok_id" class="control-label">Pemasok</label>
                        <select
                                id="beli_pemasok_id"
                                class="form-control select2"
                                name="beli_pemasok_id"
                                required
                                data-placeholder="Pilih Pemasok" data-allow-clear="true"
                                {{($data->id) ? 'disabled=true' : ''}}
                            >
                            <option value="">==Pilih Data==</option>
                                @foreach(@$data->pemasok as $pemasok)
                                    <option value="{{ $pemasok->pemasok_id }}" {{($data->id) ? ($data->beli->beli_pemasok_id==$pemasok->pemasok_id) ? 'selected' : '' : ''}}>{{ $pemasok->pemasok_nama }}</option>
                                @endforeach
                            </select>
                    </div>
                    <!-- <div class="form-group col-3"> -->
                    <input type="hidden" class="form-control" id="beli_user_id" name="beli_user_id" value="{{($data->id) ? $data->beli->beli_user_id : Auth::user()->id}}">
                        <!-- <label for="beli_user_id" class="control-label">Pengguna</label>
                        <select
                                id="beli_user_id_kw"
                                class="form-control select2"
                                name="beli_user_id"
                                required
                                data-placeholder="Pilih Pengguna" data-allow-clear="true"
                                {{($data->id) ? 'disabled=true' : ''}}
                            > -->
                            <!-- <option value="">==Pilih Data==</option> -->
                                <!-- @foreach(@$data->users as $users)
                                    <option value="{{ $users->id }}" 
                                    @if($data->id) 
                                     {{($data->beli->beli_user_id==$users->id) ? 'selected' : '' }}
                                     @else
                                     {{($users->id==Auth::user()->id) ? 'selected' : 'disabled' }}
                                     @endif
                                    >{{ $users->name }}</option>
                                @endforeach
                            </select>
                    </div> -->
                    <div class="form-group col-4">
                        <label for="beli_tot_beli" class="control-label">Total</label>
                        <input type="number" readonly class="form-control" required id="beli_tot_beli" name="beli_tot_beli" {{($data->id) ? 'readonly' : ''}} value="{{($data->id) ? $data->beli->beli_tot_beli : ''}}">
                    </div>
                    @if(!$data->id)
                    <div class="modal-footer col-12">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Barang 
                @if(!$data->id) 
                <a class="btn btn-primary text-white" data-toggle="modal" data-target="#exampleModal" onclick="set_form('Tambah Barang Pembelian')" data-whatever="@mdo">Tambah Data</a> 
                @endif
                </h4>
                <div class="table-responsive m-t-40">
                    <table id="mydatatable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Qty</th>
                                <th>@harga</th>
                                <th>Total</th>
                                @if($data->action!='detail') 
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; $subtotal=0; @endphp
                            @foreach($data->detail_pembelian as $detail)
                            @php $tot = $detail->dbeli_jml*$detail->dbeli_harga; @endphp
                            @php $subtotal = $subtotal + $tot; @endphp
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$detail->barang_nama}}</td>
                                <td>{{$detail->dbeli_jml}}</td>
                                <td>@rp($detail->dbeli_harga)</td>
                                <td>@rp($tot)</td>
                                @if($data->action!='detail')
                                <td>
                                @if( $data->id==null) 
                                <a class="btn btn-success text-white  ti-pencil-alt" data-toggle="modal" data-target="#exampleModal" onclick="set_form('Edit Data', '{{$detail->dbeli_id}}', '{{$detail->dbeli_barang_id}}', '{{$detail->dbeli_jml}}', '{{$detail->dbeli_harga}}',)" data-whatever="@mdo"></a>
                                    <a class="btn btn-warning text-white ti-trash" onclick="del_data('{{$detail->dbeli_id}}')"></a>
                                    @elseif($data->action=='retur')
                                    <a class="btn btn-warning text-white" data-toggle="modal" data-target="#exampleModal1" onclick="set_form_retur('Retur Barang', '{{$detail->dbeli_beli_id}}', '{{$detail->dbeli_barang_id}}', '{{$detail->dbeli_jml}}', '{{$detail->dbeli_harga}}', '{{$detail->barang_stok}}' )" data-whatever="@mdo">Retur</a>
                                    @endif
                                </td>
                                @endif
                            </tr>
                            @php $no++; @endphp
                            @endforeach
                        </tbody>
                        <tfood>
                            <tr>
                                <th colspan="4" class="text-right">Total</th>
                                <th  @if($data->action!='detail') colspan="2" @endif>@rp($subtotal)</th>
                            </tr>
                        </tfood>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if($data->id)
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Retur Barang 
                </h4>
                <div class="table-responsive m-t-40">
                    <table id="mydatatable1" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Qty</th>
                                <th>@harga</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; $subtotal_retur=0; @endphp
                            @foreach($data->retur_pembelian as $return)
                            @php $tot_retur = $return->rb_jml*$return->rb_harga; @endphp
                            @php $subtotal_retur = $subtotal_retur + $tot_retur; @endphp
                            <tr>
                                <td>{{$no}}</td>
                                <td>@date($return->rb_tgl)</td>
                                <td>{{$return->barang_nama}}</td>
                                <td>{{$return->rb_jml}}</td>
                                <td>@rp($return->rb_harga)</td>
                                <td>@rp($tot_retur)</td>
                            </tr>
                            @php $no++; @endphp
                            @endforeach
                        </tbody>
                        <tfood>
                            <tr>
                                <th colspan="5" class="text-right">Total</th>
                                <th  @if($data->action=='return') colspan="2" @endif>@rp($subtotal_retur)</th> 
                            </tr>
                        </tfood>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <form action="/pembelian/store" method="post">
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
                            <input type="hidden" class="form-control" id="dbeli_id" name="dbeli_id">
                            <label for="dbeli_barang_id" class="control-label">Barang</label>
                            <select
                                id="dbeli_barang_id"
                                required
                                class="form-control select2"
                                name="dbeli_barang_id"
                                data-placeholder="Pilih Barang" data-allow-clear="true"
                                onchange="get_select()"
                            >
                            <option value="">==Pilih Data==</option>
                                @foreach(@$data->barang as $barang)
                                    <option harga="{{ $barang->barang_hargabeli }}" value="{{ $barang->barang_id }}">{{ $barang->barang_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dbeli_jml" class="control-label">Jumlah</label>
                            <input type="number" class="form-control" min="1" required id="dbeli_jml" name="dbeli_jml">
                        </div>
                        <div class="form-group">
                            <label for="dbeli_harga" class="control-label">Harga</label>
                            <input type="number" class="form-control" min="1" required id="dbeli_harga" name="dbeli_harga">
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

<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <form id="form_retur" action="/pembelian/return_store" method="post">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titleModal_retur">New message</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="rb_id" name="rb_id">
                            <input type="hidden" class="form-control" id="rb_beli_id" name="rb_beli_id" >
                            <label for="rb_barang_id" class="control-label">Barang</label>
                            <input type="hidden" class="form-control" id="rb_barang_id" name="rb_barang_id">
                            <select 
                            readonly disabled

                                id="rb_barang_id_kw" 
                                class="form-control "
                                data-allow-clear="true"
                                onchange="get_select()"
                                style="width: 100%"
                            >
                            <option value="">==Pilih Data==</option>
                                 @foreach(@$data->barang as $barang)
                                    <option harga="{{ $barang->barang_hargabeli }}"  readonly value="{{ $barang->barang_id }}">{{ $barang->barang_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="rb_tgl" class="control-label">Tanggal</label>
                            <input type="text" class="form-control" required id="rb_tgl" name="rb_tgl">
                            <span id="alert_rb_tgl" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="rb_jml" class="control-label">Jumlah</label>
                            <input type="number" class="form-control" min="1" required id="rb_jml" name="rb_jml">
                            <span id="alert_rb_jml" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="rb_harga" class="control-label">Harga</label>
                            <input type="number" class="form-control" min="1" readonly required id="rb_harga" name="rb_harga">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" onclick="submit_form();" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>

</div>

@endsection

@section('js_after')
<script>

    function submit_form(){
        var form_valid = true;
        $('#alert_rb_tgl').text('');
        $('#alert_rb_jml').text('');
        
        if($('#rb_tgl').val()==''){
            form_valid = false;
            $('#alert_rb_tgl').text('tanggal tidak boleh kosong');
        }

        if($('#rb_jml').val()==''){
            form_valid = false;
            $('#alert_rb_jml').text('jumlah tidak boleh kosong');
        }else if($('#rb_jml').val()< $("#rb_jml").attr('min')){
            form_valid = false;
            $('#alert_rb_jml').text('jumlah minimal tidak sesuai');
        }else if($('#rb_jml').val()>$("#rb_jml").attr('max')){
            form_valid = false;
            $('#alert_rb_jml').text('jumlah maximal tidak sesuai');
        }

        if(form_valid == true ){
            swal({
                title: "Simpan Data",
                text: "Anda Yakin Benar ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya",
                cancelButtonText: "Tidak",
                confirmButtonColor: "#DD6B55",
                closeOnConfirm: false
            }, function() {
                $('#form_retur').submit()
            });
        }
        
    }
    
$('#beli_tgl').datepicker({
    format: "yyyy-mm-dd",
    endDate: '+1d',
datesDisabled: '+1d'
});
$('#rb_tgl').datepicker({
    format: "yyyy-mm-dd",
    startDate: '{{($data->id) ? $data->beli->beli_tgl : ''}}'
});

  @if($data->id)
    var retur_pembelian = @json($data->retur_pembelian, JSON_PRETTY_PRINT) ;
    @endif

    var subtotal = '{{$subtotal}}';
    $("#beli_tot_beli").val(subtotal);
    // $("#beli_bayar").val(subtotal-0);
    // $("#beli_diskon_beli").val(0);
    // function potongan(val){
    //     hasil = parseFloat(subtotal)-parseFloat(val);
    //     $("#beli_bayar").val(hasil);
    // }

    function get_select(){
        let harga = $("#dbeli_barang_id option:selected").attr('harga');
        let dbeli_hargapokok = $("#dbeli_barang_id option:selected").attr('dbeli_hargapokok');
        $("#dbeli_harga").val(harga);
        $("#dbeli_hargapokok").val(dbeli_hargapokok);
    }
    

    function set_form(title, dbeli_id, dbeli_barang_id, dbeli_jml, dbeli_harga) {
        $('#titleModal').text(title);
        $('#dbeli_id').val(dbeli_id);
        $('#dbeli_barang_id').val(dbeli_barang_id);
        $('#dbeli_jml').val(dbeli_jml);
        $('#dbeli_harga').val(dbeli_harga);
        // $('#dbeli_hargapokok').val(dbeli_hargapokok);
    }

    function set_form_retur(title, rb_beli_id, rb_barang_id, rb_jml, rb_harga, stok_barang ) {
        let jml_retur = 0;
        retur_pembelian.forEach(retur_pembelian => {
            if(retur_pembelian.barang_id==rb_barang_id){
                stok_barang = retur_pembelian.barang_stok
                jml_retur = jml_retur + parseFloat(retur_pembelian.rb_jml)
            }
        })
        let sisa = parseFloat(rb_jml) - jml_retur;
        let sisanya = (stok_barang<=sisa) ? stok_barang :sisa ;
        
        // console.log('sias',sisa);
        // console.log('stok_barang',stok_barang);
        // console.log('goblok',(stok_barang<=sisa) ? stok_barang :sisa);
        // if(stok_barang==0){
        //     sisa=0
        //     }
        $('#titleModal_retur').text(title);
        // $('#rb_id').val(rb_id);
        $('#rb_beli_id').val(rb_beli_id);
        $('#rb_barang_id').val(rb_barang_id);
        $("#rb_barang_id_kw").val(rb_barang_id);
        // $('#rb_barang_id').val(rb_barang_id);
        // $('#rb_tgl').val(rb_tgl);
        $('#rb_jml').val(sisanya);
        $('#rb_harga').val(rb_harga);
        // $('#rb_hargapokok').val(rb_hargapokok);
        document.getElementById('rb_jml').max = sisanya;
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
            window.location.href = window.location.origin + "/pembelian/delete/" + id;
        });
    }
</script>
@endsection