@extends('layout')

@section('title', 'Detail Obat')

@section('content')
<div class="section-1-container section-container">
    <div class="container">
        <div class="row">
            <div class="col-10 offset-1 col-lg-8 offset-lg-2 div-wrapper d-flex justify-content-center align-items-center">

                <div class="div-to-align">
                    <h2>Product Details</h2>
                    <div class="card" style="width: 40rem;">
                        <div class="card-header">
                            <h3>{{ $detail->nama_obat }}</h3>
                        </div>
                        <div class="card-body d-flex">
                            <img src="{{asset('storage/foto-obat/'.$detail->foto)}}" width="300" alt="">
                            <div class="ml-4 my-auto">
                                <p><strong>Kategori:</strong> {{ $detail->id_kategori }}</p>
                                <p><strong>Kode obat:</strong> {{ $detail->kode_obat }}</p>
                                <p><strong>Jumlah stok:</strong> {{ $detail->stok }}</p>
                                <p><strong>Harga obat:</strong> {{ $rupiah }}</p>
                                <p><strong>Jumlah masuk:</strong> {{ $jmlMasuk }}</p>
                                <p><strong>Jumlah keluar:</strong> {{ $jmlKeluar }}</p>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('obat') }}" class="btn btn-secondary mt-3 mb-4"><i class="fas fa-fw fa-angle-double-left"></i> Kembali</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection