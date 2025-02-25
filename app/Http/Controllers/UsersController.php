<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravolt\Indonesia\Models\City;
use Validator;

class UsersController extends Controller
{
    public function show($uuid)
    {
        $data = User::where('uuid', $uuid)->first();
        if (!$data) {
            abort(404);
        }

        $jabatan = User::groupBy('jabatan')->pluck('jabatan');
        $petugas = (new OpsiController)->api_petugas();
        $kotkab = City::get();
        return view('users.show')
                    ->with('data', $data)
                    ->with('jabatan', $jabatan)
                    ->with('petugas', $petugas)
                    ->with('kotkab', $kotkab)
                    ->with('header', ['icon'=>'fas fa-users-cog', 'title' => 'User Settings'])
                    ;
    }

    public function websettings($uuid)
    {
        $data = User::where('uuid', $uuid)->first();
        if (!$data) {
            abort(404);
        }

        return view('users.websettings')
                    ->with('data', $data)
                    ->with('header', ['icon'=>'fas fa-cogs', 'title' => 'Web Settings'])
                    ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         try {
            //simpan tandatangan
            if ($request->tandatangan) {
                $folderPath = public_path('img/tandatangan/ttd_user/');
                $image_parts = explode(";base64,", $request->tandatangan);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);

                $file = uniqid() . '.'.$image_type;
                
                $filepath = $folderPath . $file;
                file_put_contents($filepath, $image_base64);  
            } else {
                $file = NULL;
            }

            if ($file) {
                // jika ada tandatangan
                $request->request->add(['tandatangan' => $file]);
            }else{
                // jika tidak ada jangan masukan ke data yang diupdate
                $request->request->remove('tandatangan');
            }

            $data = User::where('uuid', $request->uuid)->first();
            if (!$request->password) {
                // jangan masukan ke data yang diupdate jika tidak ada password yang dirubah
                $request->request->remove('password');
            }else{
                $request->merge(['password' => Hash::make($request->password)]);
            }

            // hapus foto dari update data, update foto ada fungsi sendiri
            $request->request->remove('image');

            // update navbar background color
            if (isset($request->settings_navbar_bg_color_option)) {
                if ($request->settings_navbar_bg_color_option == 'default') {
                    $request->merge(['settings_navbar_bg_color' => 'default']);
                } else {
                    $request->merge(['settings_navbar_bg_color' => $request->settings_navbar_bg_color]);
                }
                $request->request->remove('settings_navbar_bg_color_option');
            }

            $data->update($request->all());

            $perubahan = $data->getChanges();

            //return response
            $response = "Berhasil mengupdate data";
            return redirect()->back()
                    ->with('perubahan', json_encode($perubahan))
                    ->with('success', true)
                    ->with('response', $response);

        } catch (Exception $e){
            if($request->ajax()) {
                return response()->json(['msg' => $e->getMessage()], 500);
            }else{
                dd($e->getMessage());
                return redirect()->route('users.show', $data->uuid)
                        ->with('error', true)
                        ->with('response', $e->getMessage());
            }
            die();
        }
    }

    public function cropImageUploadAjax(Request $request)
    {
        $folderPath = public_path('img/profile/');
 
        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
 
        $imageName = uniqid() . '.png';
 
        $imageFullPath = $folderPath.$imageName;
 
        file_put_contents($imageFullPath, $image_base64);
 
         $saveFile = User::where('id', Auth::user()->id)->first();
         $saveFile->foto = $imageName;
         $saveFile->save();
    
        return response()->json(['file'=> $imageName]);
    }
}
