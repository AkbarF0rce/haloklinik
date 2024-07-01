@extends('layout')
@section('title', 'Data Kategori Obat')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Tabel Daftar Kategori Obat</h1>
    <p>*Jika tidak bisa dihapus artinya kategori tersebut sudah digunakan oleh data obat</p>
    <br>
    <div class="card shadow mb-4">
        <div class="card-header justify-content-between d-flex">
            <h5 class="text-primary">Daftar Kategori Obat</h5>
            <button class="btn btn-primary ms-auto" data-toggle="modal" data-target="#myModal">Tambah <i class="fas fa-fw fa-plus-square"></i></button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
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
					<h4 class="modal-title">Tambah data kategori obat</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<!-- body modal -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Kategori</label>
                        <input type="text" placeholder="Masukkan nama" id="nama_kategori" name="nama_kategori" class="form-control">
                    </div>
                </div>
                <!-- footer modal -->
                <div class="modal-footer">
                    <button class="btn btn-primary confirmKatObat">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
			</div>
		</div>
	</div>
@endsection

@section('footer')
    <script type="module">
         // Tampilkan data kedalam datatable
         var table = $('.dataTable').DataTable({
            processing : true,
            serverSide : true,
            ajax : "{!!route('katData')!!}",
            columns : [
                {
                    name: 'id_kategori',
                    data: 'id_kategori'
                },
                {
                    name: 'nama_kategori',
                    data: 'nama_kategori'
                },
                {
                    render: function(data,type,row){
                        return "<btn class='btn btn-danger hpsBtn' attr-id='"+row.id_kategori+"' attr-name='"+row.nama_kategori+"'><i class='fas fa-fw fa-trash'></i> Delete</btn>";
                    }
                },
            ]
        });

        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.confirmKatObat').on('click', function(a){
            a.preventDefault();
            a.stopImmediatePropagation();
            Swal.fire({
                title: "Yakin mau menambah data ini?",
                showCancelButton: true,
                confirmButtonText: "Iya",
                cancelButtonText: "Tidak",
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{route("tambahKategori")}}',
                        type: 'post',
                        data: {
                            nama_kategori : $('#nama_kategori').val(),
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
        });

        $('.dataTable tbody').on('click', '.hpsBtn', function(e){
            var namaKat = $(this).closest('.hpsBtn').attr('attr-name');
            var idKat = parseInt($(this).closest('.hpsBtn').attr('attr-id'));
            Swal.fire({
                title: "Apa kamu yakin?",
                text: "Data " + namaKat + " akan dihapus!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : 'hapusKat/' + idKat,
                        type : 'POST',
                        data: {
                            id_kategori : idKat,
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