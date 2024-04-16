<?php

namespace App\Http\Controllers;

use App\Models\MBentukKekerasan;
use App\Models\MKategoriKasus;
use App\Models\RKategoriJenisBentuk;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class SettingKategoriKasusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = DB::table('m_kategori_kasus as a')
            ->select('a.uuid', 'a.kode as kategori_kode', 'a.nama as kategori_nama', 'c.nama as jenis_nama', 'd.nama as bentuk_nama')
            ->leftJoin('r_kategori_jenis_bentuk as b', 'a.kode', '=', 'b.kategori_kasus_kode')
            ->leftJoin('m_jenis_kekerasan as c', 'b.jenis_kekerasan_kode', '=', 'c.kode')
            ->leftJoin('m_bentuk_kekerasan as d', 'b.bentuk_kekerasan_kode', '=', 'd.kode')
            ->orderBy('a.id', 'DESC')
            ->whereNull('a.deleted_at')
            ->whereNull('b.deleted_at')
            ->whereNull('c.deleted_at')
            ->whereNull('d.deleted_at')
            ->get();

        $formattedData = collect();

        foreach ($data as $row) {
            $jenisBentuk = $formattedData->get($row->kategori_kode, []);
            $jenisBentuk[$row->jenis_nama][] = $row->bentuk_nama;
            $formattedData->put($row->kategori_kode, $jenisBentuk);
        }

        $result = $formattedData->map(function ($jenisBentuk, $kategoriKode) use ($data) {
            $kategoriNama = $data->where('kategori_kode', $kategoriKode)->first()->kategori_nama;

            $formattedJenisBentuk = collect();
            $no = 1;
            foreach ($jenisBentuk as $jenisNama => $bentukList) {
                $formattedJenisBentuk->push("<b>".$no.". $jenisNama : </b><br>" . implode(", ", $bentukList)."");
                $no++;
            }

            return [
                'kategori_kode' => $kategoriKode,
                'kategori_nama' => $kategoriNama,
                'kategori_jenis_bentuk' => $formattedJenisBentuk->implode("<br> "),
                'uuid' => $data->where('kategori_kode', $kategoriKode)->first()->uuid,
            ];
        });

        return DataTables::of($result)->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required'
            ]);
            if ($validator->fails())
            {
                throw new Exception($validator->errors());
            }

            if (!isset($request->uuid)) {
                // jika tidak ada uuid berarti tambah
                $kode = (MKategoriKasus::orderBy('id','DESC')->pluck('id')->first() * 10) + 1;
            }else{
                // jika ada berarti edit, kode tetap sama tidak berubah
                $kode = $request->kode;
            }

            // store data m_kategori_kasus
            $proses = MKategoriKasus::updateOrCreate(['uuid' => $request->uuid],[
                'kode'   => $kode, 
                'nama'     => $request->nama, 
                'usia'     => $request->usia, 
                'jenis_kelamin'     => $request->jenis_kelamin, 
                'terlapor'     => json_encode($request->terlapor), 
                'lokasi'     => json_encode($request->lokasi), 
                'definisi'     => $request->definisi, 
                'dasar_hukum'     => json_encode($request->dasar_hukum), 
                'created_by'   => Auth::user()->id
            ]);

            // remove dulu semua relasi si kategori_kasus di tabel r_kategori_jenis_bentuk
            RKategoriJenisBentuk::where('kategori_kasus_kode', $kode)->delete();
            // kemudian store data r_kategori_jenis_bentuk
            foreach ($request->bentuk_kode as $value) {
                $jenis_kode_once = MBentukKekerasan::where('kode', $value)->pluck('jenis_kekerasan_kode')->first();
                $proses2 = RKategoriJenisBentuk::create([
                    'kategori_kasus_kode' => $kode,
                    'jenis_kekerasan_kode' => $jenis_kode_once,
                    'bentuk_kekerasan_kode' => $value,
                    'created_by' => Auth::user()->id
                ]);
            }

            //return response
            return response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Disimpan!',
                'data'    => $proses  
            ]);
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
            die();
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $data = MKategoriKasus::where('uuid', $uuid)
                    ->select('*')
                    ->first();
        
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        try {
            $kategori_kode = MKategoriKasus::where('uuid', $uuid)->pluck('kode')->first();
            // hapus pada tabel m_kategori_kasus
            $proses = MKategoriKasus::where('uuid', $uuid)
                                        ->delete();
            // hapus pada tabel r_kategori_jenis_bentuk
            $proses = RKategoriJenisBentuk::where('kategori_kasus_kode', $kategori_kode)
                                        ->delete();

            if (!$proses) {
                throw new Exception($proses);
            }
            
            //return response
            return response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Dihapus!',
                'data'    => $proses  
            ]);

        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
            die();
        }
    }
}
