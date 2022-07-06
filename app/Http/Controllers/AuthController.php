<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function formLogin()
    {
        if (Auth::check()) { 
            return redirect()->route('home');
        }
        return view('login');
    }

    public function login(Request $r)
    {
        $rules = [
            'action' => 'required|in:login,register',
            'nik'    => 'required|string',
            'name'   => 'required|string'
        ];
  
        $messages = [
            'action.required' => 'Aksi wajib diisi',
            'action.in'       => 'Aksi tidak sesuai',
            'nik.required'    => 'NIK wajib diisi',
            'nik.string'      => 'NIK harus berupa string',
            'name.required'   => 'Nama Lengkap wajib diisi',
            'name.string'     => 'Nama Lengkap harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($r->all);
        }

        $action = $r->input('action');
        $nik    = $r->input('nik');
        $name   = $r->input('name');

        if($action === 'register')
        {
            try {
                $photo  = null;
                $dataRead = Storage::disk('local')->exists('config.txt') ? json_decode(Storage::disk('local')->get('config.txt')) : [];
                if(!empty($dataRead)){ 
                    foreach($dataRead as $dr){
                        if($dr->nik === $nik){
                            return redirect()->back()->with('error', 'Data Sudah ada');
                        }
                    }
                }
                $data = $r->only(['nik','name']);
                $data['photo'] = $photo;
                $data['created_at'] = date('Y-m-d H:i:s');
                array_push($dataRead,$data);
                Storage::disk('local')->put('config.txt', json_encode($dataRead));
                $r->session()->put('user', ['nik'=>$nik,'name'=>$name,'photo'=>$photo]);
                return redirect()->route('home');
            } catch (Exception $e) {
                return redirect()->back()->with('error', 'Gagal register: '.$e->getMessage());
            }
        }

        if($action === 'login')
        {
            try {
                $dataRead = Storage::disk('local')->exists('config.txt') ? json_decode(Storage::disk('local')->get('config.txt')) : [];
                if(empty($dataRead)){ 
                    return redirect()->back()->with('error', 'Gagal Login. Silahkan pilih Pengguna Baru');
                }
                foreach($dataRead as $dr){
                    if($dr->nik === $nik){
                        $r->session()->put('user', ['nik'=>$dr->nik,'name'=>$dr->name,'photo'=>$dr->photo]);
                        return redirect()->route('home');
                    }
                }
                return redirect()->back()->with('error', 'NIK tidak sesuai');
            } catch (Exception $e) {
                return redirect()->back()->with('error', 'Gagal Login: '.$e->getMessage());
            }
        }
    }

    public function logout(Request $r)
    {
        $r->session()->forget('user');
        return redirect()->route('login');
    }
}
