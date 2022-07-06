<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function update(Request $r)
    {
        $rules = [
            'nik_old' => 'required|string',
            'nik_new' => 'required|string',
            'name'    => 'required|string',
            'photo'   => 'nullable|mimes:jpg,jpeg|max:2048',
        ];
  
        $messages = [
            'nik_old.required' => 'NIK Lama wajib diisi',
            'nik_old.string'   => 'NIK Lama harus berupa string',
            'nik_new.required' => 'NIK Baru wajib diisi',
            'nik_new.string'   => 'NIK Baru harus berupa string',
            'name.required'    => 'Nama Lengkap wajib diisi',
            'name.string'      => 'Nama Lengkap harus berupa string',
            'photo.mimes'      => 'Photo harus berekstensi JPG atau JPEG',
            'photo.max'        => 'Photo maksimal 2MB',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($r->all);
        }
        
        $nikOld = $r->input('nik_old');
        $photoOld = $r->input('photo_old');
        $nikNew = $r->input('nik_new');
        $name = $r->input('name');
        $tujuanUploadPhoto = 'photo/user';
        
        $dataRead = json_decode(Storage::disk('local')->get('config.txt'));
        
        if($nikOld != $nikNew)
        {
            if(empty($r->file('photo')))
            {
                return redirect()->back()->with('error','Update Gagal! Silahkan upload ulang photo!');
            }
        }

        if($r->hasFile('photo'))
        {
            $photo = $r->file('photo');
            $namaPhotoX = $photo->getClientOriginalName();
            $imageInfo = explode(".", $namaPhotoX);
            $ext = end($imageInfo);
            $namaPhoto = $nikNew.".".$ext;
            if(!file_exists($tujuanUploadPhoto)) {
                mkdir($tujuanUploadPhoto, 0777, true);
            }
            if(!file_exists($tujuanUploadPhoto)) {
                return redirect()->back()->with('error','Update Gagal! Directory cannot be created! Silahkan hubungi Administrator!'); 
            }
            $photo->move($tujuanUploadPhoto,$namaPhoto);

            $photoNew = $tujuanUploadPhoto.'/'.$namaPhoto;
            foreach ($dataRead as $key => $entry) {
                if ($entry->nik === $nikOld) {
                    $dataRead[$key]->photo = $photoNew;
                }
            }
        } else {
            $photoNew = $photoOld;
        }

        foreach ($dataRead as $key => $entry) {
            if ($entry->nik === $nikOld) {
                $dataRead[$key]->nik = $nikNew;
                $dataRead[$key]->name = $name;
            }
        }

        Storage::disk('local')->put('config.txt', json_encode($dataRead));
        $r->session()->put('user', ['nik'=>$nikNew,'name'=>$name,'photo'=>$photoNew]);
        return redirect()->back()->with('success', 'Data berhasil di update');
    }
}
