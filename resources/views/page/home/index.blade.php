@extends('layouts.template')
@section('title','home')
@section('konten')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            <div class="card-header">
            <b>{{ __('TOKO BINTANG ELEKTRONIK') }}</b></div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('Selamat Datang') }} {{ Auth::user()->name }}  {{ __('😉') }}
                </div>
            </div>
        </div>
    </div>
</div>

                @endsection