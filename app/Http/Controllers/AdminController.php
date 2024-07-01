<?php

namespace App\Http\Controllers;

use App\Models\kategoriModel;
use App\Models\obatKeluarModel;
use App\Models\obatMasukModel;
use App\Models\obatModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    //
    protected $katModel;
    protected $obatModel;
    protected $obatMasukModel;
    protected $obatKeluarModel;

    public function __construct()
    {
        $this->katModel = new kategoriModel();
        $this->obatModel = new obatModel();
        $this->obatMasukModel = new obatMasukModel();
        $this->obatKeluarModel = new obatKeluarModel();
    }

    public function index(){
        
        return view('admin.dashboard');
    }
    
    public function obatIndex(){
        $cek = obatModel::count();
        if($cek == 0){
            $noUrut = 10001;
            $kode = 'HLKLNK'.$noUrut;
            // dd($kode);
        }else{
            // Jika ada data
            $cekData = obatModel::all()->last();
            $noUrut = (int)substr($cekData->kode_obat, -5) + 1;
            $kode = 'HLKLNK'.$noUrut;
        }

        return view('admin.dataObat', compact('kode'));
    }

    public function obatMasukIndex(){
        return view('admin.obatMasuk');
    }

    public function obatKeluarIndex(){
        return view('admin.obatKeluar');
    }

    public function katObatIndex(){
        return view('admin.kategoriObat');
    }

    public function tambahKategori(Request $request){
        $validate = Validator::make($request->all(),[
            'nama_kategori' => 'required',
        ]);

        if($validate->fails()){
            return response()->json(['errors' => 'Data tidak lengkap']);
        }else {
            $tambah = kategoriModel::create(['nama_kategori' => $request->nama_kategori]);
            if($tambah){
                return response()->json(['success' => 'Berhasil menyimpan data kategori obat']);
            }
            else{
                return response()->json(['errors' => 'Gagal menyimpan data kategori obat']);
            }
        }
    }

    public function simpanObat(Request $request){
        $validate = Validator::make($request->all(),[
            'id_kategori' => 'required',
            'kode_obat' => 'required|max:11',
            'nama_obat' => 'required|max:100',
            'harga' => 'required|max:10',
            'stok' => 'required|max:10',
            "foto" => 'required|image|max:2048'
        ]);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate);
        }else {
            $foto = $request->file('foto');
            $fileName = date('Y-m-d').$foto->getClientOriginalName();
            $path = 'foto-obat/'.$fileName;
            Storage::disk('public')->put($path, file_get_contents($foto));

            $data = [
                'id_kategori' => $request->id_kategori,
                'kode_obat' => $request->kode_obat,
                'nama_obat' => $request->nama_obat,
                'harga' => preg_replace('/\D/', '' , $request->harga),
                'stok' => $request->stok,
                'foto' => $fileName,
            ];
            $tambah = obatModel::create($data);
            if($tambah){
                return redirect()->back();
            }
        }
    }

    public function tambahObatMasuk(Request $request){
        
        $validate = Validator::make($request->all(),[
            'id_obat' => 'required',
            'tgl_masuk' => 'required',
            'jml_masuk' => 'required',
            'harga_satuan' => 'required',
        ]);
        
        $harga_satuan = preg_replace('/\D/', '' , $request->harga_satuan);
        $jml_masuk = $request->jml_masuk;

        $data = [
            'id_obat' => $request->id_obat,
            'tgl_masuk' => $request->tgl_masuk,
            'jml_masuk' => $jml_masuk,
            'harga_satuan' => $harga_satuan,
            'total_harga' => $harga_satuan * $jml_masuk
        ];

        if($validate->fails()){
            return response()->json(['errors' => 'Data tidak lengkap/salah']);
        }else {
            $tambah = obatMasukModel::create($data);
            if($tambah){
                return response()->json(['success' => 'Berhasil menyimpan data obat masuk']);
            }
            else{
                return response()->json(['errors' => 'Gagal menyimpan data obat masuk']);
            }
        }
    }

    public function tambahObatKeluar(Request $request){
        $validate = Validator::make($request->all(),[
            'id_obat' => 'required',
            'tgl_keluar' => 'required',
            'jml_keluar' => 'required',
            'harga_satuan' => 'required',
            'total_harga' => 'required'
        ]);

        $data = [
            'id_obat' => $request->id_obat,
            'tgl_keluar' => $request->tgl_keluar,
            'jml_keluar' => $request->jml_keluar,
            'harga_satuan' => $request->harga_satuan,
            'total_harga' => $request->total_harga
        ];

        if($validate->fails()){
            return response()->json(['errors' => 'Data tidak lengkap']);
        }else {
            $tambah = obatKeluarModel::create($data);
            if($tambah){
                return response()->json(['success' => 'Berhasil menyimpan data obat keluar']);
            }
            else{
                return response()->json(['errors' => 'Gagal menyimpan data obat keluar']);
            }
        }
    }

    public function dataKategori(Request $req){
        if($req->ajax()):
            $data = $this->katModel->get();
            return DataTables::of($data)->toJson();
        endif;
    }

    public function dataObat(Request $req){
        if($req->ajax()):
            $data = $this->obatModel->with('kategori')->get();
            return DataTables::of($data)->toJson();
        endif;
    }

    public function dataObatMasuk(Request $req){
        if($req->ajax()):
            $data = $this->obatMasukModel->with('obat')->get();
            return DataTables::of($data)->toJson();
        endif;
    }

    public function dataObatKeluar(Request $req){
        if($req->ajax()):
            $data = $this->obatKeluarModel->with('obat')->get();
            return DataTables::of($data)->toJson();
        endif;
    }

    public function hapusKategori(Request $req){
        /**
         * Method ini akan menghapus data yang dikirim dari 
         * form AJAX yang sudah dikonfirmasi.
         * 
         */
        
        $hapus = kategoriModel::where('id_kategori', $req->id_kategori)->delete(); 
        if($hapus){
            return response()->json(['success' => 'Berhasil hapus data kategori']);
        }
        else{
            return response()->json(['errors' => 'Gagal menghapus data kategori']);
        }
    }

    public function hapusObat(Request $req){
        /**
         * Method ini akan menghapus data yang dikirim dari 
         * form AJAX yang sudah dikonfirmasi.
         * 
         */
        $data = obatModel::findOrFail($req->id_obat);

        $hapusFoto = Storage::delete('public/foto-obat/'.$data->foto);

        $hapusData = $data->delete();

        if($hapusData && $hapusFoto){
            return response()->json(['success' => 'Berhasil hapus data obat']);
        }
        else{
            return response()->json(['errors' => 'Gagal menghapus data obat']);
        }
    }

    public function selectKat(Request $req){
        if($req->filled('term')){
            $data = kategoriModel::select('nama_kategori', 'id_kategori')
            ->where('nama_kategori', 'LIKE', '%'.$req->get('q').'%')->get();

            return response()->json($data);
        }
    }

    public function selectObat(Request $req){
        if($req->filled('term')){
            $data = obatModel::select('nama_obat', 'id_obat')
            ->where('nama_obat', 'LIKE', '%'.$req->get('q').'%')->get();

            return response()->json($data);
        }
    }

    public function detailObat($id_obat){
        /**
         * Method ini akan menampilkan form update/ubah data
         * yang dikirim ke method simpan
         * 
         */
        $jmlMasuk = obatMasukModel::where('id_obat', '=', $id_obat)->sum('jml_masuk');
        $jmlKeluar = obatKeluarModel::where('id_obat', '=', $id_obat)->sum('jml_keluar');
        $detail = obatModel::where('id_obat', '=', $id_obat)->first();
        $rupiah = 'Rp '.number_format($detail->harga, 0, ',', '.');

        return view('admin.detailObat', compact('detail', 'jmlMasuk', 'jmlKeluar', 'rupiah'));
    }

    public function editDataObat($id_obat){
        /**
         * Method ini akan menampilkan form update/ubah data
         * yang dikirim ke method simpan
         * 
         */
        $detail = obatModel::where('id_obat', '=', $id_obat)->first();
        $rupiah = 'Rp '.number_format($detail->harga, 0, ',', '.');

        return view('admin.editObat', compact('detail', 'rupiah'));
    }

    public function editObat(Request $request){
        //get post by ID
        $post = obatModel::findOrFail($request->id_obat);

        $validate = Validator::make($request->all(),[
            'id_kategori' => 'nullable',
            'kode_obat' => 'required',
            'nama_obat' => 'required',
            'harga' => 'required|max:10',
            'stok' => 'required',
            "foto" => 'image|max:2048'
        ]);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate);
        }else {
            //check jika ada gambar yang di upload
            if ($request->hasFile('foto')) {
                //upload new image
                $image = $request->file('foto');
                $image->storeAs('public/foto-obat', $image->hashName());

                //hapus gambar lama
                Storage::delete('public/foto-obat/'.$post->foto);

                //update data ke database
                $success = $post->update([
                    'foto'     => $image->hashName(),
                    'id_kategori' => $request->id_kategori,
                    'nama_obat'   => $request->nama_obat,
                    'kode_obat'   => $request->kode_obat,
                    'harga'   => preg_replace('/\D/', '' , $request->harga),
                    'stok'   => $request->stok,
                ]);

                if($success){
                    return redirect()->back();
                }
                
            } if($request->id_kategori) {
                //update data ke database
                $success = $post->update([
                    'id_kategori' => $request->id_kategori,
                    'nama_obat'   => $request->nama_obat,
                    'kode_obat'   => $request->kode_obat,
                    'harga'   => preg_replace('/\D/', '' , $request->harga),
                    'stok'   => $request->stok,
                ]);

                if($success){
                    return redirect()->back();
                }

            } else {
                //update data ke database
                $success = $post->update([
                    'nama_obat'   => $request->nama_obat,
                    'kode_obat'   => $request->kode_obat,
                    'harga'   => preg_replace('/\D/', '' , $request->harga),
                    'stok'   => $request->stok,
                ]);

                if($success){
                    return redirect()->back();
                }
            }
        }
    }
}
