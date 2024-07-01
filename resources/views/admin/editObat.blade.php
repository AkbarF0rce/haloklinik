@extends('layout')

@section('title', 'Detail Obat')

@section('content')
<div class="section-1-container section-container">
    <div class="container">
        <div class="row">
            <div class="col-10 offset-1 col-lg-8 offset-lg-2 div-wrapper d-flex justify-content-center align-items-center">
                <div class="div-to-align">
                    <h2>Edit Data Obat</h2>
                    <div class="card">
                        <div class="card-header">
                            <h3>{{ $detail->nama_obat }}</h3>
                        </div>
                        <div class="card-body d-flex">
                            <img class="my-auto mr-2" src="{{asset('storage/foto-obat/'.$detail->foto)}}" width="300" height="300" alt="">
                            <div class="mx-auto my-auto">
                                <form action="{{route('editObat')}}" method="POST" id="formEditObat" enctype="multipart/form-data"> 
                                    @csrf
                                    <div class="form-group">
                                        <label for="inputAddress">Foto obat</label>
                                        <input type="file" class="form-control-file" id="foto" name="foto">
                                        <p>*bisa dikosongkan jika tidak ingin diubah</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail4">Nama Kategori</label>
                                        <select class="autoSelect form-control" style="width: 100%" id="id_kategori" name="id_kategori" data-placeholder='Pilih kategori'>
                                            
                                        </select>
                                        <p>*bisa dikosongkan jika tidak ingin diubah</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword4">Nama obat</label>
                                        <input type="text" class="form-control @error('nama_obat') is-invalid @enderror" id="inputPassword4" name="nama_obat" value="{{$detail->nama_obat}}">
                                        @error('nama_obat')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        <input type="hidden" class="form-control" id="inputPassword4" name="id_obat" value="{{$detail->id_obat}}">
                                        <input type="hidden" class="form-control" id="inputPassword4" name="stok" value="{{$detail->stok}}">
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputPassword4">Harga obat</label>
                                            <input type="text" type-currency="IDR" class="form-control" id="nama_obat" name="harga" value="{{$rupiah}}">
                                            @error('harga')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputPassword4">Kode obat</label>
                                            <input type="text" class="form-control" id="inputPassword4" name="kode_obat" value="{{$detail->kode_obat}}">
                                            @error('kode_obat')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('obat') }}" class="btn btn-secondary mt-3 mb-4"><i class="fas fa-fw fa-angle-double-left"></i> Kembali</a>
                        <button type="button" class="btn btn-success mt-3 mb-4 editSimpan">Simpan <i class="fas fa-fw fa-save"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    <script type="module">
        $(document).ready(function() {
            $('.autoSelect').select2({
                theme: 'bootstrap4',
                placeholder: $( this ).data( 'placeholder' ),
                cache: true,
                ajax: {
                    url: "{{route('selectKat')}}",
                    dataType: 'json',
                    processResults: function(data){
                        $.each(data, function(i,d){
                            // i = iterasi ke n dan d = data dari iterasi
                            data[i]['text'] = d.nama_kategori;
                            data[i]['id'] = d.id_kategori;
                        });
                        return {
                            results: data,
                        }
                    }
                }
            } );
        });

        document.querySelectorAll('input[type-currency="IDR"]').forEach((element) => {
            element.addEventListener('keyup', function(e) {
                let cursorPostion = this.selectionStart;
                let value = parseInt(this.value.replace(/[^,\d]/g, ''));
                let originalLenght = this.value.length;
                if (isNaN(value)) {
                    this.value = "";
                } else {    
                    this.value = value.toLocaleString('id-ID', {
                        currency: 'IDR',
                        style: 'currency',
                        minimumFractionDigits: 0
                    });
                    cursorPostion = this.value.length - originalLenght + cursorPostion;
                    this.setSelectionRange(cursorPostion, cursorPostion);
                }
            });
        });

        $('.editSimpan').on('click', function(a){
            a.preventDefault();
            Swal.fire({
                title: "Yakin mau mengubah data ini?",
                showCancelButton: true,
                confirmButtonText: "Iya",
                cancelButtonText: "Tidak",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#formEditObat').submit();
                    }
                })
        })
    </script>
@endsection