@extends('layouts.template')
@section('title','Penjualan')
@section('konten')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="/penjualan/save_transaksi" class="row" method="post">
                @csrf
                    <div class="form-group col-4">
                        <input type="hidden" class="form-control" id="jual_id" name="jual_id" value="{{($data->id) ? $data->jual->jual_id : ''}}">
                        <label for="jual_tgl" class="control-label">Tanggal</label>
                        <input type="text" class="form-control" required id="jual_tgl" name="jual_tgl" {{($data->id) ? 'disabled=true' : ''}} value="{{($data->id) ? $data->jual->jual_tgl : ''}}">
                    </div>
                    <div class="form-group col-4">
                        <label for="jual_pelanggan_id" class="control-label">Pelanggan</label>
                        <select
                                id="jual_pelanggan_id"
                                class="form-control select2"
                                name="jual_pelanggan_id"
                                required
                                data-placeholder="Pilih Pelanggan" data-allow-clear="true"
                                {{($data->id) ? 'disabled=true' : ''}}
                            >
                            <option value="">==Pilih Data==</option>
                                @foreach(@$data->pelanggan as $pelanggan)
                                    <option value="{{ $pelanggan->pelanggan_id }}" {{($data->id) ? ($data->jual->jual_pelanggan_id==$pelanggan->pelanggan_id) ? 'selected' : '' : ''}}>{{ $pelanggan->pelanggan_nama }}</option>
                                @endforeach
                            </select>
                    </div>
                    <input type="hidden" class="form-control" id="jual_user_id" name="jual_user_id" value="{{($data->id) ? $data->jual->jual_user_id : Auth::user()->id}}">
                    <div class="form-group col-4">
                        <label for="jual_tot_jual" class="control-label">Total</label>
                        <input type="number" readonly class="form-control" required id="jual_tot_jual" name="jual_tot_jual" value="{{($data->id) ? $data->jual->jual_tot_jual : ''}}">
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
                <a class="btn btn-primary text-white" data-toggle="modal" data-target="#exampleModal" onclick="set_form('Tambah Data')" data-whatever="@mdo">Tambah Data</a> 
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
                            @foreach($data->detail_penjualan as $detail)
                            @php $tot = $detail->djual_jml*$detail->djual_harga; @endphp
                            @php $subtotal = $subtotal + $tot; @endphp
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$detail->barang_nama}}</td>
                                <td>{{$detail->djual_jml}}</td>
                                <td>@rp($detail->djual_harga)</td>
                                <td>@rp($tot)</td>
                                @if($data->action!='detail')
                                <td>
                                @if( $data->id==null) 
                                <a class="btn btn-success text-white  ti-pencil-alt" data-toggle="modal" data-target="#exampleModal" onclick="set_form('Edit Data', '{{$detail->djual_id}}', '{{$detail->djual_barang_id}}', '{{$detail->djual_jml}}', '{{$detail->djual_harga}}', '{{$detail->djual_hargapokok}}' )" data-whatever="@mdo"></a>
                                    <a class="btn btn-warning text-white ti-trash" onclick="del_data('{{$detail->djual_id}}')"></a>
                                    @elseif($data->action=='retur')
                                    <a class="btn btn-warning text-white" data-toggle="modal" data-target="#exampleModal1" onclick="set_form_retur('Retur Barang', '', '{{$detail->djual_jual_id}}', '{{$detail->djual_barang_id}}', '', '{{$detail->djual_jml}}', '{{$detail->djual_harga}}', '{{$detail->djual_hargapokok}}' )" data-whatever="@mdo">Retur</a>
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
                            @foreach($data->retur_penjualan as $return)
                            @php $tot_retur = $return->rj_jml*$return->rj_harga; @endphp
                            @php $subtotal_retur = $subtotal_retur + $tot_retur; @endphp
                            <tr>
                                <td>{{$no}}</td>
                                <td>@date($return->rj_tgl)</td>
                                <td>{{$return->barang_nama}}</td>
                                <td>{{$return->rj_jml}}</td>
                                <td>@rp($return->rj_harga)</td>
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
    <form action="/penjualan/store" method="post">
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
                            <input type="hidden" class="form-control" id="djual_id" name="djual_id">
                            <input type="hidden" class="form-control" id="djual_hargapokok" name="djual_hargapokok">
                            <label for="djual_barang_id" class="control-label">Barang</label>
                            <select
                                readonly required 
                                id="djual_barang_id"
                                class="form-control select2"
                                name="djual_barang_id"
                                data-placeholder="Pilih Barang" data-allow-clear="true"
                                onchange="get_select()"
                                
                            >
                            <option value="">==Pilih Data==</option>
                                @foreach(@$data->barang as $barang)
                                    <option harga="{{ $barang->barang_hargapokok + ($barang->barang_profit/100 * $barang->barang_hargapokok) }}" djual_hargapokok="{{$barang->barang_hargapokok}}" stok="{{$barang->barang_stok}}" value="{{ $barang->barang_id }}" @if($barang->barang_stok==0) disabled @endif>{{ $barang->barang_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="djual_jml" class="control-label">Jumlah</label>
                            <input type="number" class="form-control" min="1" max="" required id="djual_jml" name="djual_jml">
                        </div>
                        <div class="form-group">
                            <label for="djual_harga" class="control-label">Harga</label>
                            <input type="text" min="0" readonly class="form-control"  required id="djual_harga" name="djual_harga">
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
<form id="form_retur" action="/penjualan/return_store" method="post">
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
                            <input type="hidden" class="form-control" id="rj_id" name="rj_id">
                            <input type="hidden" class="form-control" id="rj_jual_id" name="rj_jual_id" >
                            <input type="hidden" class="form-control" id="rj_hargapokok" name="rj_hargapokok" >
                            <label for="rj_barang_id" class="control-label">Barang</label>
                            <input type="hidden" class="form-control" id="rj_barang_id" name="rj_barang_id">
                            <select
                            readonly disabled 
                            
                                id="rj_barang_id_kw"
                                class="form-control"
                                data-allow-clear="true"
                                onchange="get_select()"
                                style="width: 100%"
                            >
                            <option value="">==Pilih Data==</option>
                                @foreach(@$data->barang as $barang)
                                    <option harga="{{ $barang->barang_hargapokok + ($barang->barang_profit/100 * $barang->barang_hargapokok)}}" readonly value="{{ $barang->barang_id }}">{{ $barang->barang_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="rj_tgl" class="control-label">Tanggal</label>
                            <input type="text" class="form-control" required id="rj_tgl" name="rj_tgl">
                            <span id="alert_rj_tgl" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="rj_jml" class="control-label">Jumlah</label>
                            <input type="number" class="form-control" min="1" required id="rj_jml" name="rj_jml">
                            <span id="alert_rj_jml" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="rj_harga" class="control-label">Harga</label>
                            <input type="text" class="form-control" min="0" readonly required id="rj_harga" name="rj_harga">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" onclick="submit_form();" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>

</div>

@endsection

@section('js_after')
<script>

function submit_form(){
        var form_valid = true;
        $('#alert_rj_tgl').text('');
        $('#alert_rj_jml').text('');
        
        if($('#rj_tgl').val()==''){
            form_valid = false;
            $('#alert_rj_tgl').text('tanggal tidak boleh kosong');
        }
        if($('#rj_jml').val()==''){
            form_valid = false;
            $('#alert_rj_jml').text('jumlah tidak boleh kosong');
        }else if($('#rj_jml').val()< $("#rj_jml").attr('min')){
            form_valid = false;
            $('#alert_rj_jml').text('jumlah minimal tidak sesuai');
        }else if($('#rj_jml').val()>$("#rj_jml").attr('max')){
            form_valid = false;
            $('#alert_rj_jml').text('jumlah maximal tidak sesuai');
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
    
    

$('#jual_tgl').datepicker({
    format: "yyyy-mm-dd",
    endDate: '+1d',
datesDisabled: '+1d'
});

$('#rj_tgl').datepicker({
    format: "yyyy-mm-dd",
    startDate: '{{($data->id) ? $data->jual->jual_tgl : ''}}'
});
    @if($data->id)
    var retur_penjualan = @json($data->retur_penjualan, JSON_PRETTY_PRINT) ;
    @endif
    

    var subtotal = '{{$subtotal}}';
    $("#jual_tot_jual").val(subtotal);
    // $("#jual_bayar").val(subtotal-0);
    // $("#jual_diskon_jual").val(0);
    // function potongan(val){
    //     hasil = parseFloat(subtotal)-parseFloat(val);
    //     $("#jual_bayar").val(hasil);
    // }
    function get_select(){
        let harga = $("#djual_barang_id option:selected").attr('harga');
        let djual_hargapokok = $("#djual_barang_id option:selected").attr('djual_hargapokok');
        let stok = $("#djual_barang_id option:selected").attr('stok');
        $("#djual_harga").val(harga);
        document.getElementById('djual_jml').max = stok;
        $("#djual_hargapokok").val(djual_hargapokok);
    }
    

    function set_form(title, djual_id, djual_barang_id, djual_jml, djual_harga, djual_hargapokok) {
        $('#titleModal').text(title);
        $('#djual_id').val(djual_id);
        $('#djual_barang_id').val(djual_barang_id);
        $('#djual_jml').val(djual_jml);
        $('#djual_harga').val(djual_harga);
        $('#djual_hargapokok').val(djual_hargapokok);
    }

    function set_form_retur(title, rj_id, rj_jual_id, rj_barang_id, rj_tgl, rj_jml, rj_harga, rj_hargapokok) {
        let jml_retur = 0
        retur_penjualan.forEach(retur_penjualan => {
            if(retur_penjualan.barang_id==rj_barang_id){
                jml_retur = jml_retur + parseFloat(retur_penjualan.rj_jml)
            }
        })
        $('#titleModal_retur').text(title);
        $('#rj_id').val(rj_id);
        $('#rj_jual_id').val(rj_jual_id);
        $('#rj_barang_id').val(rj_barang_id);
        $("#rj_barang_id_kw").val(rj_barang_id);
        $('#rj_tgl').val(rj_tgl);
        $('#rj_jml').val(parseFloat(rj_jml) - jml_retur);
        $('#rj_harga').val(rj_harga);
        $('#rj_hargapokok').val(rj_hargapokok);
        document.getElementById('rj_jml').max = parseFloat(rj_jml) - jml_retur;
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
            window.location.href = window.location.origin + "/penjualan/delete/" + id;
        });
    }
</script>
@endsection