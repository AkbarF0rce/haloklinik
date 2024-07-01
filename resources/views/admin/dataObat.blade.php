@extends('layout')

@section('title', 'Data Obat')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Tabel Daftar Obat</h1>
    @if ($errors->any())
        <script type="module">
            $(document).ready(function(){
                $('#myModal').modal('show');
            });
        </script>
    @endif
    <br>
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between">
            <h5 class="text-primary">Daftar Obat</h5>
            <button class="btn btn-primary ms-auto" data-toggle="modal" data-target="#myModal">Tambah <i class="fas fa-fw fa-plus-square"></i></button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered dataTables" id="dataTables" style="width:100%"> 
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nama Obat</th>
                            <th>Kategori</th>
                            <th>Kode Obat</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog modal-dialog-centered">
			<!-- konten modal-->
			<div class="modal-content">
				<!-- heading modal -->
				<div class="modal-header">
					<h4 class="modal-title">Tambah data obat</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<!-- body modal -->
                <form action="{{route('simpanObat')}}" id="formTambahObat" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="" class="form-label">Foto Obat</label>
                            <input type="file" id="foto" name="foto" class="form-control-file">
                            @error('foto')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="id_kategori">Kategori</label>
                            <select class="autoSelect form-control" style="width: 100%" id="id_kategori" name="id_kategori" data-placeholder='Pilih kategori'>
                                
                            </select>
                            @error('id_kategori')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Nama Obat</label>
                            <input type="text" placeholder="Masukkan nama" id="nama_obat" name="nama_obat" class="form-control @error('nama_obat') is-invalid @enderror">
                            <input type="hidden" placeholder="Masukkan nama" value="{{$kode}}" id="nama_obat" name="kode_obat" class="form-control">
                            @error('nama_obat')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Harga</label>
                            <input type="text" type-currency="IDR" placeholder="Masukkan harga" id="harga" name="harga" class="form-control @error('harga') is-invalid @enderror">
                            <input type="number" placeholder="Masukkan harga" id="stok" name="stok" class="form-control" value="0" hidden>
                            @error('harga')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- footer modal -->
                    <div class="modal-footer">
                        <button class="btn btn-primary confirmObat" type="submit"><i class="fas fa-fw fa-save"></i> Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </form>
			</div>
		</div>
	</div>
@endsection

@section('footer')
 <script type="module">
    var table = $('#dataTables').DataTable({
        processing : true,
        // serverSide : true,
        ajax : "{{route('dataObat')}}",
        columns : [
            {
                render: function( data, type, row ) { 
                    return "<img src=\"/storage/foto-obat/" + row.foto + "\" height=\"50\"/>";
                }
            },
            {
                name: 'nama_obat',
                data: 'nama_obat'
            },
            {
                "render": function(data,type,row){
                    return row.kategori.nama_kategori;
                },
            },
            {
                name: 'kode_obat',
                data: 'kode_obat'
            },
            {
                name: 'harga',
                data: 'harga',
                render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' )
            },
            {
                name: 'stok',
                data: 'stok'
            },
            {
                render: function(data,type,row){
                    return "<a class='detailBtn' href='{!!url('dashboard/admin/obat/detail/"+row.id_obat+"')!!}'><btn class = 'btn btn-primary'><i class='fas fa-fw fa-eye'></i></btn></a> <a class='editBtn' href='{!!url('dashboard/admin/obat/edit/"+row.id_obat+"')!!}'><btn class='btn btn-warning' ><i class='fas fa-fw fa-edit'></i></btn></a> <btn class='btn btn-danger hpsBtn' attr-id='"+row.id_obat+"' attr-name='"+row.nama_obat+"'><i class='fas fa-fw fa-trash'></i></btn>";
                }
            },
        ]
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

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.confirmObat').on('click', function(a){
        a.preventDefault();
        var form = $(this).parents('form');
        Swal.fire({
            title: "Yakin mau menambah data ini?",
            showCancelButton: true,
            confirmButtonText: "Iya",
            cancelButtonText: "Tidak",
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $('#formTambahObat').submit();
            }
        });
    })

    // $('.dataTable tbody').on('click', '.detailBtn', function(e){
    //     var idObat = $(this).closest('.detailBtn').attr('attr-id');
    //     $.ajax({
    //         url : 'obat/detail/' + idObat,
    //         type : 'GET',
    //     })
    // })

    // $('.dataTable tbody').on('click', '.editBtn', function(e){
    //     var idObat = $(this).closest('.detailBtn').attr('attr-id');
    //     $.ajax({
    //         url : 'obat/detail/' + idObat,
    //         type : 'GET',
    //     })
    // })

    $('.dataTable tbody').on('click', '.hpsBtn', function(e){
            var namaObat = $(this).closest('.hpsBtn').attr('attr-name');
            var idObat = parseInt($(this).closest('.hpsBtn').attr('attr-id'));
            Swal.fire({
                title: "Apa kamu yakin?",
                text: "Data pemasukan dan pengeluaran terkait obat ini akan dihapus!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : 'obat/hapusObat/' + idObat,
                        type : 'POST',
                        data: {
                            id_obat : idObat,
                        },
                        success: function(res){
                            if(res.errors){
                                Swal.fire({
                                    title: "Data Gagal Diproses",
                                    text: res.errors,
                                    icon: "error"
                                })
                            }else{
                                Swal.fire({
                                    title: "Data Berhasil Diproses",
                                    text: res.success,
                                    icon: "success"
                                }).then( () => {
                                    table.ajax.reload();
                                    modal.hide()
                                });
                            }
                        }
                    })
                }
            });
        })
 </script>
@endsection