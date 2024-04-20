<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Helpers\NotifHelper;
use App\Helpers\StatusHelper;
use App\Models\Agenda;
use App\Models\DokumenTl;
use App\Models\Klien;
use App\Models\MKeyword;
use App\Models\Notifikasi;
use App\Models\TindakLanjut;
use App\Models\TKeyword;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use PhpParser\Node\Expr\New_;
use Yajra\DataTables\Facades\DataTables;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Env;

class AgendaController extends Controller
{
    protected $fpdf;
    public function __construct()
    {
        $this->fpdf = new Fpdf;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if($request->ajax()) {
       
            // $data = DB::table('agenda as a')
            //             ->select(DB::raw('CONCAT(COUNT(a.id), " agenda") as title, a.tanggal_mulai as start'))
            //             ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id')
            //             ->whereDate('a.tanggal_mulai', '>=', $request->start)
            //             ->whereDate('a.tanggal_mulai', '<=', $request->end)
            //             ->groupBy('a.tanggal_mulai')
            //             ->get();
            $data = Agenda::select(DB::raw('CONCAT(COUNT(*), " agenda") as title, tanggal_mulai as start'))
                            ->whereDate('tanggal_mulai', '>=', $request->start)
                            ->whereDate('tanggal_mulai', '<=', $request->end)
                            ->whereNotNull('klien_id') // filter agenda layanan saya yang muncul
                            ->groupBy('tanggal_mulai')
                            ->get();
            return response()->json($data);
       }
 
       return view('agenda.index');
    }

    //untuk select2 list agenda, dia methodnya POST
    public function get_agenda(Request $request)
    {
        $search = $request->search;

        if($search == ''){
            $data = DB::table('agenda as a')
                        ->select(DB::raw('a.*, b.uuid as uuid_tindak_lanjut'))
                        ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id')
                        ->where('b.created_by', Auth::user()->id)
                        ->whereNull('b.deleted_at')
                        ->orderBy('a.tanggal_mulai', 'DESC')
                        ->orderBy('a.jam_mulai', 'DESC')
                        ->limit(10)->get();
        }else{
            $data = DB::table('agenda as a')
                             ->select(DB::raw('a.*, b.uuid as uuid_tindak_lanjut'))
                             ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id')
                             ->where('b.created_by', Auth::user()->id)
                             ->where('a.judul_kegiatan', 'like', '%' .$search . '%')
                             ->whereNull('b.deleted_at')
                             ->orderBy('a.tanggal_mulai', 'DESC')
                             ->orderBy('a.jam_mulai', 'DESC')
                             ->limit(10)->get();
        }
  
        $response = array();
        foreach($data as $value){
           $response[] = array(
                "id"=>$value->uuid_tindak_lanjut,
                "text"=>$value->judul_kegiatan." (Tanggal ".date('d M Y', strtotime($value->tanggal_mulai)).", Pukul ".$value->jam_mulai.")"
           );
        }
        return response()->json($response); 
        
    }

    public function api_index(Request $request)
    { 
        // digunakan di datatable detail kasus & agenda
        // nanti benerin lagi, buat lebih sederhana masukin ke function show
        if (isset($request->user_id)) {
            if (is_numeric($request->user_id)) {
                // pakai identifier kayak gini karena dulu ada notif yang user_id nya id ada yang uuid
                $identifier = 'id';
            }else{
                $identifier = 'uuid';
            }
            $user = User::where($identifier, $request->user_id)->first();
            $user_id = $user->id;
        }else{
            $user_id = Auth::user()->id;
        }

        // merubah data jadi format indonesia, termasuk hari
        setlocale(LC_TIME, 'id_ID');
        $data = DB::table('agenda as a')
                    ->leftJoin('tindak_lanjut as b', 'b.agenda_id', 'a.id')
                    ->leftJoin('users as c', 'c.id', 'b.validated_by')
                    ->leftJoin('users as d','d.id','b.created_by')
                    ->leftJoin(DB::raw('(
                        SELECT 
                        a.tindak_lanjut_id, GROUP_CONCAT(CONCAT(",|"),b.judul) AS judul, GROUP_CONCAT(CONCAT(",|"),b.uuid) AS uuid_dokumen
                        FROM dokumen_tl a LEFT JOIN dokumen b ON a.dokumen_id = b.id
                        WHERE b.deleted_at IS NULL
                        GROUP BY a.tindak_lanjut_id) z'), 
                    function($join)
                    {
                    $join->on('z.tindak_lanjut_id', '=', 'b.id');
                    })
                    ->leftJoin(DB::raw('(
                        SELECT 
                        tindak_lanjut_id, GROUP_CONCAT(CONCAT(",|"),value) AS keyword
                        FROM t_keyword
                        GROUP BY tindak_lanjut_id) y'), 
                    function($join)
                    {
                    $join->on('y.tindak_lanjut_id', '=', 'b.id');
                    })
                    ->whereNull('a.deleted_at')
                    ->whereNull('b.deleted_at')
                    ->whereNotNull('b.id')
                    ->orderBy('a.tanggal_mulai')
                    ->orderBy('a.jam_mulai')
                    ->select(DB::raw('a.uuid as uuid_agenda, b.uuid, a.tanggal_mulai, a.jam_mulai, a.klien_id, b.tanggal_selesai, 
                    b.jam_selesai, a.judul_kegiatan, a.keterangan, b.lokasi, b.catatan, b.rtl, b.terlaksana, c.name, b.created_by, z.judul, z.uuid_dokumen, y.keyword, d.name as petugas, d.jabatan, b.validated_by')
                    , DB::raw('DATE_FORMAT(a.tanggal_mulai, "%W") as day'));

                    if ($request->belumtl == 1) { 
                        // menampilkan kasus yang belum ditindak lanjuti saja
                        $data = $data->whereNull('b.jam_selesai');
                    }

                    if ($request->uuid) { //ini untuk di halaman map klien digital
                        $klien = Klien::where('uuid', $request->uuid)->first();
                        $data = $data->where('a.klien_id', $klien->id);
                    } else { //ini untuk di halaman kinerja masing2 user
                        $data =  $data->where('b.created_by', $user_id)
                            ->whereYear('a.tanggal_mulai', $request->tahun)
                            ->whereMonth('a.tanggal_mulai', $request->bulan);
                    }

                    if ($request->jabatan) {  
                        // filter di halaman detail kasus untuk jabatan
                        $jabatan = json_decode($request->jabatan);
                        if (!empty($jabatan)) {
                            $data = $data->whereIn('d.jabatan', $jabatan);
                        }
                    }

                    if ($request->tl) {  
                        // filter di halaman detail kasus untuk yang sudah diTL
                        $data = $data->whereNull('b.jam_selesai');
                    }

                    if ($request->anda) {  
                        // filter di halaman detail kasus untuk agenda saya saja
                        $data = $data->where('b.created_by', Auth::user()->id);
                    }

                    $datas = $data->get();

        foreach ($datas as $datas2) {
            // Format the date
            $datas2->tanggal_mulai_formatted = date('d M Y', strtotime($datas2->tanggal_mulai));
            // Translate the day of the week to Indonesian
            $datas2->hari = $this->translateDayToIndonesian($datas2->day);
        }

        return DataTables::of($datas)->make(true);
    }

    function translateDayToIndonesian($day) {
        $englishDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $indonesianDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    
        return str_replace($englishDays, $indonesianDays, $day);
    }

    public function resume_layanan(Request $request)
    { 
        // digunakan di datatable detail kasus -> resume layanan
        $datas = DB::table('klien as a')
                    ->select(DB::raw('a.nama, b.tanggal_mulai, c.tanggal_selesai, b.jam_mulai, c.jam_selesai, f.keyword, g.name'))
                    ->leftJoin('agenda as b', 'a.id', 'b.klien_id')
                    ->leftJoin('tindak_lanjut as c', 'b.id', 'c.agenda_id')
                    ->leftJoin('dokumen_tl as d', 'c.id', 'd.tindak_lanjut_id')
                    ->leftJoin('dokumen as e', 'd.dokumen_id', 'e.id')
                    ->leftJoin('dokumen_keyword as f', 'e.id', 'f.dokumen_id')
                    ->leftJoin('users as g', 'c.created_by', 'g.id')
                    ->whereNull('b.deleted_at')
                    ->whereNull('c.deleted_at')
                    ->whereNull('e.deleted_at')
                    ->whereNotNull('f.keyword')
                    ->where('a.uuid', $request->uuid)
                    ->get();


        foreach ($datas as $datas2) {
            $datas2->tanggal_mulai_formatted = date('d M Y', strtotime($datas2->tanggal_mulai));
        }
        return DataTables::of($datas)->make(true);
    }

    public function kinerja(Request $request)
    {
        if (!in_array(Auth::user()->jabatan, ['Sekretariat', 'Kepala Instansi', 'Super Admin'])) {
            abort(404);
        }
        $result = DB::table('agenda as a')
                    ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id')
                    ->whereNull('a.deleted_at')
                    ->whereNull('b.deleted_at')
                    ->whereYear('a.tanggal_mulai', $request->tahun)
                    ->whereMonth('a.tanggal_mulai', $request->bulan)
                    ->select(
                        DB::raw('COUNT(*) as total'),
                        DB::raw('SUM(CASE WHEN b.validated_by IS NOT NULL THEN 1 ELSE 0 END) as valid'),
                        DB::raw('SUM(CASE WHEN b.validated_by IS NOT NULL THEN 1 ELSE 0 END) / COUNT(*) * 100 as percentage')
                    )
                    ->first();

        $percentage = $result->percentage;
        return view('agenda.kinerja')->with('persen', $percentage);
    }

    public function kinerja_ajax(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $data = DB::table('users as a')
            ->select(
                'a.id',
                'a.uuid',
                'a.jabatan',
                'a.name',
                DB::raw('COALESCE(z.sudah_ditl, 0) AS sudah_ditl'),
                DB::raw('COALESCE(y.belum_ditl, 0) AS belum_ditl'),
                DB::raw('COALESCE(z.sudah_ditl, 0) + COALESCE(y.belum_ditl, 0) AS total'),
                DB::raw('ROUND(COALESCE(z.sudah_ditl, 0) / NULLIF(COALESCE(z.sudah_ditl, 0) + COALESCE(y.belum_ditl, 0), 0) * 100, 2) AS persen'),
                DB::raw('COALESCE(x.verified, 0) AS verified'),
                DB::raw('ROUND(COALESCE(x.verified, 0) / NULLIF(COALESCE(z.sudah_ditl, 0) + COALESCE(y.belum_ditl, 0), 0) * 100, 2) AS persen_verified')
            )
            ->leftJoin(DB::raw('(SELECT
                    a.created_by,
                    SUM(CASE WHEN a.jam_selesai IS NOT NULL THEN 1 ELSE 0 END) AS sudah_ditl
                FROM
                    tindak_lanjut a
                LEFT JOIN
                    agenda b ON a.agenda_id = b.id
                WHERE
                    YEAR(b.tanggal_mulai) = ' . $tahun . ' AND MONTH(b.tanggal_mulai) = ' . $bulan . '
                    AND a.deleted_at IS NULL AND b.deleted_at IS NULL
                GROUP BY
                    created_by) z'), 'z.created_by', '=', 'a.id')
            ->leftJoin(DB::raw('(SELECT
                    a.created_by,
                    SUM(CASE WHEN a.jam_selesai IS NULL THEN 1 ELSE 0 END) AS belum_ditl
                FROM
                    tindak_lanjut a
                LEFT JOIN
                    agenda b ON a.agenda_id = b.id
                WHERE
                    YEAR(b.tanggal_mulai) = ' . $tahun . ' AND MONTH(b.tanggal_mulai) = ' . $bulan . '
                    AND a.deleted_at IS NULL AND b.deleted_at IS NULL
                GROUP BY
                    created_by) y'), 'y.created_by', '=', 'a.id')
            ->leftJoin(DB::raw('(SELECT
                    a.created_by,
                    COUNT(*) AS verified
                FROM
                    tindak_lanjut a
                LEFT JOIN
                    agenda b ON a.agenda_id = b.id
                WHERE
                    a.validated_by IS NOT NULL
                    AND YEAR(b.tanggal_mulai) = ' . $tahun . ' AND MONTH(b.tanggal_mulai) = ' . $bulan . '
                    AND a.deleted_at IS NULL AND b.deleted_at IS NULL
                GROUP BY
                    created_by) x'), 'x.created_by', '=', 'a.id')
            ->whereNull('a.deleted_at')
            ->whereIn('a.jabatan', ['Tenaga Ahli', 'Manajer Kasus', 'Pendamping Kasus', 'Advokat', 'Paralegal', 'Unit Reaksi Cepat', 'Psikolog', 'Konselor'])
            ->orderBy('a.jabatan')
            ->orderBy('a.name')
            ->get();
        return DataTables::of($data)->make(true);
    }

    public function kinerja_valid(Request $request)
    {
        if (Auth::user()->jabatan == 'Sekretariat') {
            if ($request->valid) {
                $validated_by = Auth::user()->id;
            }else{
                $validated_by = NULL;
            }

            if ($request->user_id == 'allUser') {
                // jika centang semua di halaman kinerja
                $data = DB::table('tindak_lanjut')
                    ->join('agenda', 'tindak_lanjut.agenda_id', '=', 'agenda.id')
                    ->whereYear('agenda.tanggal_mulai', $request->tahun_agenda)
                    ->whereMonth('agenda.tanggal_mulai', $request->bulan_agenda)
                    ->update(['tindak_lanjut.validated_by' => $validated_by]);
            } else {
                if ($request->uuid != 'all') {
                    // jika bukan centang semua dihalaman detail kinerja
                    $data = TindakLanjut::where('uuid', $request->uuid)->first();
                    $data->validated_by = $validated_by;
                    $data->save();
                }else{
                    // jika centang semua dihalaman detail kinerja
                    $data = DB::table('tindak_lanjut')
                        ->join('agenda', 'tindak_lanjut.agenda_id', '=', 'agenda.id')
                        ->whereYear('agenda.tanggal_mulai', $request->tahun_agenda)
                        ->whereMonth('agenda.tanggal_mulai', $request->bulan_agenda)
                        ->where('tindak_lanjut.created_by', $request->user_id)
                        ->update(['tindak_lanjut.validated_by' => $validated_by]);
                }
            }
            
            return $data;
        
        }else{
            return abort(403);
        }
    }

    public function kinerja_detail(Request $request)
    {
        if ($request->get('bulan') == null) {
            return redirect('kinerja');
        }

        // ===========================================================================================
        // Proses read, push notif & log activity ////////////////////////////////////////////////////
        // Jika sudah melihat halaman agenda maka tasknya (T10, N5, N7) selesai
        if (in_array($request->kode, ['N5','N7'])) {
            NotifHelper::read_notif(
                Auth::user()->id, // receiver_id
                NULL, // klien_id
                $request->kode, // kode
                $request->type_notif, // type_notif
                $request->agenda_id // agenda_id
            );
        }
        if (is_numeric($request->user_id)) {
            // pakai identifier kayak gini karena dulu ada notif yang user_id nya id ada yang uuid
            $identifier = 'id';
        }else{
            $identifier = 'uuid';
        }
        $user = User::where($identifier, $request->user_id)->first();

        if ($user->id != Auth::user()->id && !in_array(Auth::user()->jabatan, ['Super Admin', 'Sekretariat', 'Kepala Instansi'])) {
            return redirect(404);
        }

        $persen = DB::table('tindak_lanjut')
                        ->join('agenda', 'tindak_lanjut.agenda_id', '=', 'agenda.id')
                        ->whereYear('agenda.tanggal_mulai', $request->tahun)
                        ->whereMonth('agenda.tanggal_mulai', $request->bulan)
                        ->where('tindak_lanjut.created_by', $user->id)
                        ->selectRaw('(IFNULL(SUM(tindak_lanjut.validated_by IS NOT NULL), 0) / COUNT(*)) * 100 as percentage')
                        ->value('percentage');
        /////////////////////////////////////////////////////////////////////////////////////////////
        return view('agenda.kinerja_detail')->with('user', $user)->with('persen', $persen);
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
            $notif_receiver = NULL;
            $validator = Validator::make($request->all(), [
                'judul_kegiatan' => 'required',
                'tanggal_mulai' => 'required',
                'jam_mulai' => 'required'
                ]);
                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }
            
            // mencegah dobel user
            if (isset($request->user_id)) {
                $user_id = array_unique(($request->user_id));
            }else{
                $user_id = NULL;
            }

            if ($request->klien_id) {
                # jika ada klien_id (agenda layanan) maka input catatan & rtl kosong
                $keterangan = $request->keterangan;
            }else{
                $keterangan = null;
            }
            //simpan data agenda
            $proses = Agenda::updateOrCreate(['uuid' => $request->uuid],[
                'klien_id'     => $request->klien_id, 
                'judul_kegiatan'   => $request->judul_kegiatan, 
                'tanggal_mulai'   => $request->tanggal_mulai,
                'jam_mulai'   => $request->jam_mulai,
                'keterangan'   => $keterangan,
                'created_by'   => Auth::user()->id
            ]);

            $proses_id = $proses->id;

            // untuk kebutuhan notifikasi
            $klien = Klien::find($request->klien_id);
            $tahun = date('Y', strtotime($request->tanggal_mulai));
            $bulan = date('m', strtotime($request->tanggal_mulai));
            $notif_receiver = NULL; 
            
            // ===========================================================================================
            // Proses read, push notif & log activity ////////////////////////////////////////////////////
            // push notifikasi ///////////////////////////////////////////////////////////////////////////
            if (isset($user_id)) {
                // jika ada list user / petugasnya
                foreach ($user_id as $value) {
                    $penerima = User::find($value);
                    // 1. membuat agenda
                    if (!isset($request->uuid)) {
                        // jika tidak ada uuid berarti tambah
    
                        // tambah tindak_lanjut 
                        TindakLanjut::create([
                            'agenda_id' => $proses_id,
                            'created_by' => $value
                        ]);
    
                        if ($value == Auth::user()->id) {
                            $message_notif = 'Anda telah membuat agenda untuk diri anda : <b>'.$request->judul_kegiatan.'</b>. Silahkan buat laporan tindak lanjutnya';
                        } else {
                            $message_notif = Auth::user()->name.' telah membuat agenda untuk anda : <b>'.$request->judul_kegiatan.'</b>. Silahkan buat laporan tindak lanjutnya';
                        }

                        if ($klien && $klien->id) {
                            // jika ada kliennya, maka redirect ke halaman detail kasus dan tab intervensi
                            $url = url('/kasus/show/'.$klien->uuid.'?tab=kasus-layanan&row-layanan='.$proses->uuid);
                        } else {
                            $url = url('/kinerja/detail?tahun='.$tahun.'&bulan='.$bulan.'&user_id='.$value.'&row-agenda='.$proses->uuid.'&kode=T9&type_notif=task&agenda_id='.$proses_id);
                        }
                        
                        NotifHelper::push_notif(
                            $value , //receiver_id
                            ($klien && $klien->id) ? $klien->id : NULL, //klien_id
                            'T9', //kode
                            'task', //type_notif
                            ($klien && $klien->no_klien) ? $klien->no_klien : NULL, //noregis
                            Auth::user()->name, //from
                            $message_notif, //message
                            ($klien && $klien->nama) ? $klien->nama : NULL,  //nama korban 
                            ($klien && $klien->tanggal_lahir) ? $klien->tanggal_lahir : NULL, //tanggal lahir korban
                            $url, //url
                            1, // kirim ke diri sendiri 0 / 1
                            Auth::user()->id, // created_by
                            $proses_id // agenda_id
                        );

                        // untuk kirim realtime notifikasi
                        $notif_receiver[] = 'user_'.$value;
    
                        LogActivityHelper::push_log(
                            //message
                            Auth::user()->name.' membuat laporan tindak lanjut',
                            //klien_id
                            ($klien && $klien->id)? $klien->id : NULL
                        );
                    }
    
                    // 2. merubah data agenda
                    $perubahan = array_keys($proses->getChanges());
                    $variabel_agenda = ['klien_id', 'judul_kegiatan', 'tanggal_mulai', 'jam_mulai', 'keterangan'];
                    $tindak_lanjut = TindakLanjut::where('created_by', $value)->where('agenda_id', $proses_id)->first();

                    if (isset($request->uuid) && (count(array_intersect($perubahan, $variabel_agenda)) > 0 || empty($tindak_lanjut))) {
                        // jika ada perubahan (selain created_by, updated_at atau ada user tambahan) maka kirim notif dan ada uuid (berupa update)
                        
                        // yang dilakukan pertama kali adalah hapus notifikasi T9 & T10 agenda ini jika value bukan yang sedang login, agar tidak dobel notifikasi menambah & merubah                    
                        if ($value != Auth::user()->id) {
                            // jika yang merubah bukan sesuai yang login, maka hapus notif T9 mereka
                            Notifikasi::where('receiver_id', $value)
                                        ->where('agenda_id', $proses_id)
                                        ->whereIn('kode', ['T9','T10'])
                                        ->delete();
                        }
    
                        // jika perubahannya adalah list petugas dan ada petugas baru yang ditambahkan, maka create 
                        if (empty($tindak_lanjut)) {
                            // jika belum ada, maka tambahkan
                            TindakLanjut::create([
                                'agenda_id' => $proses_id,
                                'created_by' => $value
                            ]);

                            $kode = 'T9';
                            $type = 'task';
                            $message_notif = Auth::user()->name.' telah membuat agenda untuk anda : <b>'.$request->judul_kegiatan.'</b>. Silahkan buat laporan tindak lanjutnya';
                            $agenda_id = $proses_id;
                        }else{
                            $kode = 'N10';
                            $type = 'notif';
                            $message_notif = Auth::user()->name.' telah merubah agenda yang berkaitan dengan anda : <b>'.$request->judul_kegiatan.'</b>.';
                            $agenda_id = NULL;
                        }

                        if ($klien && $klien->id) {
                            // jika ada kliennya, maka redirect ke halaman detail kasus dan tab intervensi
                            $url = url('/kasus/show/'.$klien->uuid.'?tab=kasus-layanan&row-layanan='.$proses->uuid);
                        } else {
                            $url = url('/kinerja/detail?tahun='.$tahun.'&bulan='.$bulan.'&user_id='.$value.'&row-agenda='.$proses->uuid.'&kode=T9&type_notif=task&agenda_id='.$agenda_id);
                        }
    
                        NotifHelper::push_notif(
                            $value , //receiver_id
                            ($klien && $klien->id) ? $klien->id : NULL, //klien_id
                            $kode, //kode
                            $type, //type_notif
                            ($klien && $klien->no_klien) ? $klien->no_klien : NULL, //noregis
                            Auth::user()->name, //from
                            $message_notif, //message
                            ($klien && $klien->nama) ? $klien->nama : NULL,  //nama korban 
                            ($klien && $klien->tanggal_lahir) ? $klien->tanggal_lahir : NULL, //tanggal lahir korban
                            $url,
                            0, // kirim ke diri sendiri 0 / 1
                            Auth::user()->id, // created_by
                            $agenda_id // agenda_id
                        );
    
                        // untuk kirim realtime notifikasi
                        if ($value != Auth::user()->id) {
                            $notif_receiver[] = 'user_'.$value;
                        }
                        
                        LogActivityHelper::push_log(
                            //message
                            Auth::user()->name.' merubah agenda '.$request->judul_kegiatan,
                            //klien_id
                            ($klien && $klien->id)? $klien->id : NULL
                        );
                    }
    
                    // 3. mengisi laporan tindak lanjut
                    if($request->klien_id && $request->jam_selesai && in_array($penerima->jabatan, ['Manajer Kasus', 'Supervisor Kasus'])) {
                        // jika ada id klien dan ada jam selesainya, berarti mengisi laporan tindak lanjut. kirim notif ke MK & SPV saja
                        NotifHelper::push_notif(
                            $value , //receiver_id
                            ($klien && $klien->id) ? $klien->id : NULL, //klien_id
                            'N5', //kode
                            'notif', //type_notif
                            ($klien && $klien->no_klien) ? $klien->no_klien : NULL, //noregis
                            Auth::user()->name, //from
                            Auth::user()->name.' telah mengupdate laporan tindak lanjut. Silahkan lihat isinya untuk update informasi kasus.', //message
                            ($klien && $klien->nama) ? $klien->nama : NULL,  //nama korban 
                            ($klien && $klien->tanggal_lahir) ? $klien->tanggal_lahir : NULL, //tanggal lahir korban
                            url('/kasus/show/'.$klien->uuid.'?tab=kasus-layanan&row-layanan='.$proses->uuid.'&kode=N5&type_notif=notif&agenda_id='.$proses_id), //url
                            0, // kirim ke diri sendiri 0 / 1
                            Auth::user()->id, // created_by
                            $proses_id // agenda_id
                        );
    
                        LogActivityHelper::push_log(
                            //message
                            Auth::user()->name.' membuat laporan tindak lanjut',
                            //klien_id
                            ($klien && $klien->id)? $klien->id : NULL
                        );
                    }
                    // 4. menghapus diri
                    if (!in_array(Auth::user()->id, $user_id)) {
                        // jika user yang login tidak ada di list petugas maka hapus diri, tidak bisa menghapus diri orang lain
                        // hapus notif
                        Notifikasi::where('receiver_id', Auth::user()->id)
                                    ->where('agenda_id', $proses_id)
                                    ->whereIn('kode', ['T9', 'T10', 'N5', 'N7'])
                                    ->delete();
                        // hapus user
                        TindakLanjut::where('created_by', Auth::user()->id)
                                    ->where('agenda_id', $proses_id)
                                    ->delete();
                                    
                        NotifHelper::push_notif(
                            $value , //receiver_id
                            ($klien && $klien->id) ? $klien->id : NULL, //klien_id
                            'N7', //kode
                            'notif', //type_notif
                            ($klien && $klien->no_klien) ? $klien->no_klien : NULL, //noregis
                            Auth::user()->name, //from
                            Auth::user()->name.' telah menghapus dirinya dari agenda "'.$request->judul_kegiatan.'" tanggal '.$request->tanggal_mulai, //message
                            ($klien && $klien->nama) ? $klien->nama : NULL,  //nama korban 
                            ($klien && $klien->tanggal_lahir) ? $klien->tanggal_lahir : NULL, //tanggal lahir korban
                            url('/kinerja/detail?tahun='.$tahun.'&bulan='.$bulan.'&user_id='.$value.'&row-agenda='.$proses->uuid.'&kode=N7&type_notif=notif&agenda_id='.$proses->id), //url
                            0, // kirim ke diri sendiri 0 / 1
                            Auth::user()->id, // created_by
                            $proses_id // agenda_id
                        );
    
                        LogActivityHelper::push_log(
                            //message
                            Auth::user()->name.' menghapus dirinya dari agenda "'.$request->judul_kegiatan.'" tanggal '.$request->tanggal_mulai,
                            //klien_id
                            ($klien && $klien->id)? $klien->id : NULL
                        );
                    }
                    // proses update tindak lanjut
                    if ($value == Auth::user()->id) {
                        // jika edit dan id usernya adalah dirinya sendiri meka edit laporan tindak lanjut
                        if ($klien && $klien->id) {
                            # jika ada klien_id (agenda layanan) maka input catatan & rtl kosong
                            $catatan = $request->catatan;
                            $rtl = $request->rtl;
                        }else{
                            $catatan = null;
                            $rtl = null;
                        }
                        TindakLanjut::where('created_by', $value)
                        ->where('agenda_id', $proses_id)
                        ->update([
                            'lokasi' => $request->lokasi,
                            'tanggal_selesai' => $request->tanggal_mulai, //tanggal selesai = tanggal mulai, karna kita main jadwanya per tanggal
                            'jam_selesai' => $request->jam_selesai,
                            'catatan' => $catatan,
                            'rtl' => $rtl,
                            'terlaksana' => $request->terlaksana
                        ]);
    
                        if ($request->jam_selesai) {
                            // jika ada jam selesainya maka T9 dan T10 read = 1
                            // jika ngisi tindak lanjut buat penanganan layanan maka sudah di handle di front end, harus ada dokumennya
                            NotifHelper::read_notif(
                                $value, // receiver_id
                                ($klien && $klien->id)? $klien->id : NULL, // klien_id
                                'T9', // kode ini request dari link 
                                'task', // type_notif
                                $proses_id // agenda_id
                            );
    
                            NotifHelper::read_notif(
                                $value, // receiver_id
                                ($klien && $klien->id)? $klien->id : NULL, // klien_id
                                'T10', // kode ini request dari link 
                                'task', // type_notif
                                $proses_id // agenda_id
                            );
                        }

                        if (isset($request->keyword)) {
                            $tindak_lanjut = TindakLanjut::where('created_by', $value)->where('agenda_id', $proses_id)->first();
                            // hapus dulu dokumen_tl pada tindak lanjut ini, kemudian tambahkan lagi
                            TKeyword::where('tindak_lanjut_id', $tindak_lanjut->id)->delete();
    
                            foreach ($request->keyword as $value_keyword) {
                                TKeyword::create([
                                    'tindak_lanjut_id' => $tindak_lanjut->id,
                                    'value' => $value_keyword,
                                    'created_by' => Auth::user()->id
                                ]);
                            }
                        }else{
                            $tindak_lanjut = TindakLanjut::where('created_by', $value)->where('agenda_id', $proses_id)->first();
                            // hapus Dokumen Pendukung 
                            TKeyword::where('tindak_lanjut_id', $tindak_lanjut->id)->delete();
                        }
    
                        if (isset($request->dokumen_pendukung)) {
                            $tindak_lanjut = TindakLanjut::where('created_by', $value)->where('agenda_id', $proses_id)->first();
                            // hapus dulu dokumen_tl pada tindak lanjut ini, kemudian tambahkan lagi
                            DokumenTl::where('tindak_lanjut_id', $tindak_lanjut->id)->delete();
    
                            foreach ($request->dokumen_pendukung as $value_dokumen) {
                                DokumenTl::create([
                                    'tindak_lanjut_id' => $tindak_lanjut->id,
                                    'dokumen_id' => $value_dokumen
                                ]);
                            }
                        }else{
                            $tindak_lanjut = TindakLanjut::where('created_by', $value)->where('agenda_id', $proses_id)->first();
                            // hapus Dokumen Pendukung 
                            DokumenTl::where('tindak_lanjut_id', $tindak_lanjut->id)->delete();
                        }
                    }
                }

            } else {
                // jika tidak ada array user / petugasnya maka hapus agenda & notifnya
                // tapi hanya hapus agenda ketika user receiver tinggal 1, untuk menghindari notif nyangkut
                $jumlah_receiver = TindakLanjut::where('agenda_id', $proses_id)
                                                ->whereNull('deleted_at')
                                                ->count();
                if ($jumlah_receiver == 1) {
                    Agenda::where('uuid', $request->uuid)->delete();
                }
                
                // hapus notif
                Notifikasi::where('receiver_id', Auth::user()->id)
                            ->where('agenda_id', $proses_id)
                            ->whereIn('kode', ['T9', 'T10', 'N5', 'N7'])
                            ->delete();
                // hapus user
                TindakLanjut::where('created_by', Auth::user()->id)
                            ->where('agenda_id', $proses_id)
                            ->delete();

                LogActivityHelper::push_log(
                    //message
                    Auth::user()->name.' menghapus dirinya dari agenda "'.$request->judul_kegiatan.'" tanggal '.$request->tanggal_mulai,
                    //klien_id
                    ($klien && $klien->id)? $klien->id : NULL
                );
            }

            $jumlah_agenda = Agenda::where('tanggal_mulai', $request->tanggal_mulai)
                                    ->count();
            $proses->jumlah_agenda = $jumlah_agenda." Agenda"; // untuk fullcalendar

            // update status klien //////////////////////////////////////////////////////////////////////
            if (isset($klien->id) && $request->jam_selesai) {
                // jika ada nama kliennya dan sudah buat laporan tindak lanjut, maka statusnya adalah Pelaksanaan intervensi
                StatusHelper::push_status($klien->id, 'Pelaksanaan intervensi');
            }
            /////////////////////////////////////////////////////////////////////////////////////////////

            //return response
            return response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Disimpan!',
                'data'    => $proses,
                'notif_receiver' => $notif_receiver == NULL ? NULL : array_unique($notif_receiver)
            ]);
        } catch (Exception $e){
            return response()->json(['msg' => $e->getMessage()]);
            die();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid) //buat menampilkan agenda (nanti benerin lagi coba)
    {
        try {
            $agenda = DB::table('agenda as a')
                            ->select(DB::raw('a.judul_kegiatan, a.tanggal_mulai, a.jam_mulai, a.keterangan, c.nama, b.lokasi, b.jam_selesai, b.catatan'))
                            ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id') 
                            ->leftJoin('klien as c', 'c.id', 'a.klien_id')
                            ->where('b.uuid', $uuid)
                            ->where('b.created_by', Auth::user()->id)
                            ->first();
            //return response
            return response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Success',
                'data'    => $agenda  
            ]);
        } catch (Exception $e){
            return response()->json(['msg' => $e->getMessage()]);
            die();
        }
    }

    public function showdate($date)
    {
        try {
            $agenda_semua = DB::table('agenda as a')
                            ->select(DB::raw('a.uuid, a.judul_kegiatan, a.tanggal_mulai, a.jam_mulai, a.keterangan, c.nama, c.uuid as uuid_klien, GROUP_CONCAT(" ", d.name) as petugas'))
                            ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id') 
                            ->leftJoin('klien as c', 'c.id', 'a.klien_id')
                            ->leftJoin('users as d', 'd.id', 'b.created_by')
                            ->where('a.tanggal_mulai', $date)
                            ->whereNotNull('a.klien_id') // filter agenda layanan saya yang muncul
                            ->whereNull('a.deleted_at')
                            ->whereNull('b.deleted_at')
                            ->orderBy('a.jam_mulai')
                            ->groupBy('a.id', 'a.uuid', 'a.judul_kegiatan', 'a.tanggal_mulai', 'a.jam_mulai', 'a.keterangan', 'c.nama', 'c.uuid')
                            ->get();

            $agenda_kasus_saya = DB::table('agenda as a')
                            ->select(DB::raw('a.uuid, a.judul_kegiatan, a.tanggal_mulai, a.jam_mulai, a.keterangan, c.nama, c.uuid as uuid_klien, GROUP_CONCAT(" ", d.name) as petugas'))
                            ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id') 
                            ->leftJoin('klien as c', 'c.id', 'a.klien_id')
                            ->leftJoin('users as d', 'd.id', 'b.created_by')
                            ->leftJoin('petugas as e', 'e.klien_id', 'c.id')
                            ->where('a.tanggal_mulai', $date)
                            ->whereNotNull('a.klien_id') // filter agenda layanan saya yang muncul
                            ->whereNull('a.deleted_at')
                            ->whereNull('b.deleted_at')
                            ->whereNull('e.deleted_at')
                            ->orderBy('a.jam_mulai')
                            ->groupBy('a.id', 'a.uuid', 'a.judul_kegiatan', 'a.tanggal_mulai', 'a.jam_mulai', 'a.keterangan', 'c.nama', 'c.uuid');
            $agenda_kasus_saya = $agenda_kasus_saya->where('e.user_id', Auth::user()->id);
            $agenda_kasus_saya = $agenda_kasus_saya->get();

            $agenda_saya = DB::table('agenda as a')
                            ->select(DB::raw('a.uuid, a.judul_kegiatan, a.tanggal_mulai, a.jam_mulai, a.keterangan, c.nama, c.uuid as uuid_klien, b.lokasi, b.jam_selesai, b.catatan, b.created_by'))
                            ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id') 
                            ->leftJoin('klien as c', 'c.id', 'a.klien_id')
                            ->where('a.tanggal_mulai', $date)
                            ->where('b.created_by', Auth::user()->id)
                            ->whereNull('a.deleted_at')
                            ->whereNull('b.deleted_at')
                            ->orderBy('a.jam_mulai')
                            ->get();
            $agenda = array('agenda_semua' => $agenda_semua, 
                            'agenda_kasus_saya' => $agenda_kasus_saya, 
                            'agenda_saya' => $agenda_saya);
            //return response
            return response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Success',
                'data'    => $agenda  
            ]);
        } catch (Exception $e){
            return response()->json(['msg' => $e->getMessage()]);
            die();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $uuid)
    {
        $data = DB::table('agenda as a')
                    ->leftJoin('tindak_lanjut as b', 'b.agenda_id', 'a.id')
                    ->leftJoin('users as c', 'c.id', 'b.validated_by')
                    ->leftJoin('klien as d', 'a.klien_id', 'd.id')
                    // ->where('b.created_by', Auth::user()->id)
                    ->where('a.uuid', $uuid)
                    ->whereNull('b.deleted_at')
                    ->select(DB::raw('a.id, b.id as tindak_lanjut_id, a.tanggal_mulai, a.jam_mulai, a.klien_id, d.nama, a.uuid, b.tanggal_selesai, b.jam_selesai, a.judul_kegiatan, a.keterangan, b.lokasi, b.catatan, b.rtl, c.name, b.created_by'))
                    ->first();
                    
        $data_tindak_lanjut = DB::table('agenda as a')
                    ->leftJoin('tindak_lanjut as b', 'b.agenda_id', 'a.id')
                    ->leftJoin('users as c', 'c.id', 'b.created_by')
                    ->leftJoin('klien as d', 'a.klien_id', 'd.id')
                    ->where('b.created_by', $request->petugas)
                    ->where('a.uuid', $uuid)
                    ->whereNull('b.deleted_at')
                    ->select(DB::raw('a.id as agenda_id, b.id as tindak_lanjut_id, a.tanggal_mulai, a.jam_mulai, a.klien_id, d.nama, a.uuid, b.tanggal_selesai, b.jam_selesai, a.judul_kegiatan, a.keterangan, b.lokasi, b.catatan, b.rtl, c.name, c.jabatan, b.created_by'))
                    ->first();
        $data->data_tindak_lanjut = $data_tindak_lanjut;
                    
        $user_id = DB::table('tindak_lanjut as a')
                        ->leftJoin('users as b', 'a.created_by','b.id')
                        ->where('a.agenda_id', $data->id)
                        ->select('b.id', 'b.name')
                        ->whereNull('a.deleted_at')
                        ->get();
        $data->user_id = $user_id;

        $keyword = DB::table('t_keyword')
                    ->where('tindak_lanjut_id', $data_tindak_lanjut->tindak_lanjut_id)
                    ->select('value')
                    ->get();
        $data->keyword = $keyword;

        $dokumen_id = DB::table('dokumen_tl as a')
                    ->leftJoin('dokumen as b', 'a.dokumen_id','b.id')
                    ->where('a.tindak_lanjut_id', $data->tindak_lanjut_id)
                    ->whereNull('b.deleted_at')
                    ->select('b.id', 'b.judul')
                    ->get();
        $data->dokumen_id = $dokumen_id;
        
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //untuk select2 list klien, dia methodnya POST
    public function get_keyword(Request $request)
    {
                
        $search = $request->search;       

        $data = DB::table('m_keyword')
            ->select('jabatan', 'keyword')
            ->whereNull('deleted_at');
            
        if (Auth::user()->jabatan != 'Super Admin') {
            $data->where('jabatan', Auth::user()->jabatan);
        }

        if($search != ''){
            $data->where('keyword', 'like', '%' .$search . '%');
        }
        
        $data = $data->limit(100)->get();

        $result = [];

        $no = 1;
        foreach ($data as $row) {
            $jabatan = $row->jabatan;
            $keyword = [
                'id'   => $row->keyword,
                'text' => $row->keyword,
            ];

            if (isset($result[$jabatan])) {
                $result[$jabatan]['children'][] = $keyword;
            } else {
                $result[$jabatan] = [
                    'text'     => $no.'. '.$row->jabatan,
                    'children' => [$keyword],
                ];
                $no++;
            }
        }

        // Reindex the result array
        $results = array_values($result);

        // Return the results as JSON
        echo json_encode($results);
    }

public function pdf_kinerja(Request $request)
{

    if (is_numeric($request->user_id)) {
        // pakai identifier kayak gini karena dulu ada notif yang user_id nya id ada yang uuid
        $identifier = 'id';
    }else{
        $identifier = 'uuid';
    }
    $user = User::where($identifier, $request->user_id)->first();
    // Dataset
    $queryResult = DB::table('tindak_lanjut as a')
                ->leftJoin('agenda as b', 'a.agenda_id', 'b.id')
                ->where('a.created_by', $user->id)
                ->whereYear('b.tanggal_mulai', $request->tahun)
                ->whereMonth('b.tanggal_mulai', $request->bulan)
                ->whereNull('a.deleted_at')
                ->whereNull('b.deleted_at')
                // hanya yang sudah divalidasi aja yang bisa muncul
                // ->whereNotNull('a.validated_by')
                ->orderBy('b.tanggal_mulai')
                ->orderBy('b.jam_mulai')
                ->select(DB::raw('b.tanggal_mulai, TIME_FORMAT(b.jam_mulai, "%H:%i") as jam_mulai, TIME_FORMAT(a.jam_selesai, "%H:%i") as jam_selesai, b.judul_kegiatan'))
                ->get();

    $data = [];
    foreach ($queryResult as $row) {
        $data[] = [
            'tanggal_mulai' => date('d-m-Y', strtotime($row->tanggal_mulai)),
            'jam_mulai' => $row->jam_mulai.' s/d '.$row->jam_selesai,
            'judul_kegiatan' => $row->judul_kegiatan,
        ];
    }

    $this->fpdf->SetFont('Arial', 'B', 10);
    $this->fpdf->AddPage();

    // judul
    $this->fpdf->Cell(190,5,'LAPORAN KINERJA',0,1,'C');
    $this->fpdf->Cell(190,5,strtoupper($user->jabatan),0,1,'C');
    $this->fpdf->Cell(190,5,'UPT PPPA PROVINSI DKI JAKARTA',0,1,'C');
    $this->fpdf->Cell(190,5,'TAHUN ANGGARAN '.$request->tahun,0,1,'C');
    $this->fpdf->Ln();

    // metadata
    $this->fpdf->Cell(40, 5, 'Nama', 0);
    $this->fpdf->Cell(5, 5, ' : ', 0);
    $this->fpdf->Cell(100, 5, $user->name, 0);
    $this->fpdf->Ln();
    $this->fpdf->Cell(40, 5, 'Jabatan Pekerjaan', 0);
    $this->fpdf->Cell(5, 5, ' : ', 0);
    $this->fpdf->Cell(100, 5, $user->jabatan, 0);
    $this->fpdf->Ln();
    $this->fpdf->Cell(40, 5, 'Bulan', 0);
    $this->fpdf->Cell(5, 5, ' : ', 0);
    $this->fpdf->Cell(100, 5, Carbon::createFromFormat('m', $request->bulan)->format('F'), 0);
    $this->fpdf->Ln();
    $this->fpdf->Ln();

    // Set table header
    $this->fpdf->Cell(10, 5, 'NO', 1);
    $this->fpdf->Cell(25, 5, 'TANGGAL', 1);
    $this->fpdf->Cell(30, 5, 'WAKTU', 1);
    $this->fpdf->Cell(125, 5, 'URAIAN KEGIATAN', 1);
    $this->fpdf->Ln();

    $this->fpdf->SetFont('Arial', '', 9);

    // Initialize prevtanggal_mulai variable
    $prevtanggal_mulai = null;

    // Iterate through data
    $rowCount = 1;
    $yPos = 0;
    foreach ($data as $row) {
        // Output 'tanggal_mulai' if it's a new date
        if ($row['tanggal_mulai'] !== $prevtanggal_mulai) {
            $this->fpdf->Cell(10, 5, $rowCount, 'LT', 0, 'L'); // Output row number
            $this->fpdf->Cell(25, 5, $row['tanggal_mulai'], 'LTR', 0, 'L');
            $prevtanggal_mulai = $row['tanggal_mulai'];
            $rowCount++;
        } else {
            $this->fpdf->Cell(10, 5, '', 'LR', 0, 'L'); // Output empty cell for row number
            $this->fpdf->Cell(25, 5, '', 'LR', 0, 'L'); // Output empty cell if 'tanggal_mulai' hasn't changed
        }

        // Output 'jam_mulai'
        $this->fpdf->Cell(30, 5, $row['jam_mulai'], 'LTR', 0, 'L');

        // Calculate height for 'judul_kegiatan' cell based on the length of the text
        $judul_kegiatanHeight = ceil(strlen($row['judul_kegiatan']) / 60) * 5; // Assuming each line can hold 60 characters approximately

        // Output 'judul_kegiatan' using MultiCell to allow wrapping and adjust the height
        $this->fpdf->MultiCell(125, 5, $row['judul_kegiatan'], 1, 'L');
        // Get the current y position after MultiCell
        $yPos = $this->fpdf->GetY();

        // Calculate the maximum height between 'judul_kegiatan' cell height and the default cell height
        $maxHeight = max($judul_kegiatanHeight, 5); // 10 is the default cell height

        // Set the height of the cell
        $this->fpdf->SetXY($this->fpdf->GetX(), $yPos - $maxHeight); // Adjust Y position
        $this->fpdf->Cell(10, $maxHeight, '', 'LR', 0, 'L'); // Output empty cell with adjusted height
        $this->fpdf->Cell(25, $maxHeight, '', 'LR', 0, 'L'); // Output empty cell with adjusted height
        
        // Move to the next line
        $this->fpdf->Ln();

    }
    // Set table footer
    $this->fpdf->SetFont('Arial', 'B', 10);
    $this->fpdf->Cell(10, 5, 'NO', 1);
    $this->fpdf->Cell(25, 5, 'TANGGAL', 1);
    $this->fpdf->Cell(30, 5, 'WAKTU', 1);
    $this->fpdf->Cell(125, 5, 'URAIAN KEGIATAN', 1);
    $this->fpdf->Ln();
    $this->fpdf->Ln();

    // tanda tangan
    if($request->server('REMOTE_ADDR') == '127.0.0.1') {
        $imagePath = "https://mokapppa.jakarta.go.id/v2/img/tandatangan/ttd_user/65952117dd4d9.png";
    } else {
        $imagePath = env('APP_URL').'/img/tandatangan/ttd_user/'.$user->tandatangan;
    }

    $this->fpdf->Cell(115, 5, '', 0);
    $this->fpdf->Cell(75, 5, 'Jakarta, '.date('d-m-Y'), '', 0, 'C');
    $this->fpdf->Ln();
    $this->fpdf->Cell(115, 5, '', 0);
    $this->fpdf->Cell(75, 5, 'Yang Membuat,', '', 0, 'C');
    $this->fpdf->Ln();
    $this->fpdf->Cell(115, 5, '', 0);
    $this->fpdf->Cell(75, 5, $user->jabatan, '', 0, 'C');
    $this->fpdf->Ln();
    $this->fpdf->Cell(115, 25, '', 0);
    if ($user->tandatangan) {
        $image = $this->fpdf->Image($imagePath,148,$yPos+26, '', 21);
    }else{
        $image = "Tamda Tangan Tidak Ditemukan";
    }
    $this->fpdf->Cell(75, 24, $image, '', 0, 'C');
    $this->fpdf->Ln();
    $this->fpdf->Cell(115, 5, '', 0);
    $this->fpdf->Cell(75, 5, $user->name, '', 0, 'C');
    // Output the table footer
    $this->fpdf->Output();
    exit;
}

}
