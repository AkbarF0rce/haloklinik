@extends('layout')
@section('title', 'Data Obat Masuk')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Tabel Daftar Obat Masuk</h1>
    <br>
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between">
            <h5 class="text-primary">Daftar Obat Masuk</h5>
            <button class="btn btn-primary ms-auto" data-toggle="modal" data-target="#myModal">Tambah <i class="fas fa-fw fa-plus-square"></i></button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Obat</th>
                            <th>Tanggal Masuk</th>
                            <th>Jumlah Masuk</th>
                            <th>Harga Satuan</th>
                            <th>Total Harga</th>
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
					<h4 class="modal-title">Tambah data obat masuk</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<!-- body modal -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Obat</label>
                        <select class="autoSelect form-control" style="width: 100%" id="id_obat" data-placeholder='Pilih obat'>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Masuk</label>
                        <input type="date"  id="tgl_masuk" placeholder="Masukkan tanggal" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Jumlah Masuk</label>
                        <input type="number" id="jml_masuk" placeholder="Masukkan jumlah masuk" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Harga Satuan</label>
                        <input type="text" type-currency="IDR" id="harga_satuan" placeholder="Masukkan harga satuan" class="form-control">
                    </div>
                    
                </div>
                <!-- footer modal -->
                <div class="modal-footer">
                    <button class="btn btn-primary confirmObatMasuk">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
			</div>
		</div>
	</div>
@endsection

@section('footer')
    <script type="module">
        var table = $('.dataTable').DataTable({
            processing : true,
            // serverSide : true,
            ajax : "{!!route('dataObatMasuk')!!}",
            columns : [
                {
                    render: function(data,type,row){
                        return row.obat.nama_obat;
                    }
                },
                {
                    name: 'tgl_masuk',
                    data: 'tgl_masuk'
                },
                {
                    name: 'jml_masuk',
                    data: 'jml_masuk'
                },
                {
                    name: 'harga_satuan',
                    data: 'harga_satuan',
                    render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' )
                },
                {
                    name: 'total_harga',
                    data: 'total_harga',
                    render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' )
                },
            ]
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
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
                dropdownParent : $('#myModal'),
                cache: true,
                ajax: {
                    url: "{{route('selectObat')}}",
                    dataType: 'json',
                    processResults: function(data){
                        $.each(data, function(i,d){
                            // i = iterasi ke n dan d = data dari iterasi
                            data[i]['text'] = d.nama_obat;
                            data[i]['id'] = d.id_obat;
                        });
                        return {
                            results: data,
                        }
                    }
                }
            } );
        });

        $('.confirmObatMasuk').on('click', function(a){
            var form = $(this).closest('form');
            a.preventDefault();
            Swal.fire({
                text: "Anda tidak bisa menghapus/mengedit data ini jadi harap cek dengan benar",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Iya",
                cancelButtonText: "Tidak",
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{route("tambahObatMasuk")}}',
                        type: 'post',
                        data: {
                            id_obat : $('#id_obat').val(),
                            tgl_masuk : $('#tgl_masuk').val(),
                            jml_masuk : $('#jml_masuk').val(),
                            harga_satuan : $('#harga_satuan').val(),
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
                                    $('#myModal').modal('hide');
                                });
                            }
                        }
                    })
                }
            });
        });

    </script>
@endsection