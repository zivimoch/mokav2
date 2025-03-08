<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class SettingUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = DB::table('users as a')
            ->select('a.*', 'b.name as kota', 'c.name as supervisor')
            ->leftJoin('indonesia_cities as b', 'a.kotkab_id', '=', 'b.code')
            ->leftJoin('users as c', 'a.supervisor_id', '=', 'c.id')
            // ->whereNull('a.deleted_at')
            ->orderBy('a.id'); 

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-primary">Action</button>';
            })
            ->filter(function ($query) use ($request) {
                // Filtering based on search input
                if ($request->has('search') && !empty($request->search['value'])) {
                    $value = $request->search['value'];
                    $query->where(function ($q) use ($value) {
                        $q->where('a.name', 'like', "%$value%")
                            ->orWhere('a.jabatan', 'like', "%$value%")
                            ->orWhere('b.name', 'like', "%$value%")
                            ->orWhere('c.name', 'like', "%$value%");
                    });
                }
            })
            ->rawColumns(['action']) 
            ->make(true);
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
                'name' => 'required',
                'email' => 'required',
            ]);
            if ($validator->fails())
            {
                throw new Exception($validator->errors());
            }
            
            $data = [
                'name'   => $request->name, 
                'email'     => $request->email, 
                'jabatan'     => $request->jabatan, 
                'active'     => $request->active, 
            ];

            if (isset($request->password)) {
                $data['password'] = Hash::make($request->password);
            }

            if (isset($request->supervisor_id)) {
                $data['supervisor_id'] = $request->supervisor_id;
            }

            if (isset($request->kotkab_id)) {
                $data['kotkab_id'] = $request->kotkab_id;
            }



            if ($request->active == 0) {
                $user = User::where('uuid', $request->uuid)->first();
                // jika mengubah menjadi tidak aktif, maka semua kasus dijadikan 0 (sekunder)
                $update = Petugas::where('user_id', $user->id)->update(['active' => 0]);

            }
            
            //create data
            $proses = User::updateOrCreate(['uuid' => $request->uuid],$data);
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
        $data = User::where('uuid', $uuid)
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
            $proses = User::where('uuid', $uuid)->first();

            if (!$proses) {
                throw new Exception("User not found");
            }
            
            // Nonaktifkan user sebelum dihapus
            $proses->update(['active' => 0]);
            
            // Semua kasus dijadikan sekunder
            Petugas::where('user_id', $proses->id)->update(['active' => 0]);
            
            // Hapus user setelah update
            $proses->delete();
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
