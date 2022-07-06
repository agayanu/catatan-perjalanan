<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function index(Request $r)
    {
        $col  = $r->input('col') ?? 'date';
        $sort = $r->input('sort') ?? 'asc';
        return view('note',['col'=>$col,'sort'=>$sort]);
    }

    public function data(Request $r)
    {
        $col  = $r->input('col');
        $sort = $r->input('sort');
        if($r->ajax())
        {
            try {
                $dataRead = Storage::disk('local')->exists('data.txt') ? json_decode(Storage::disk('local')->get('data.txt')) : [];
                if($sort === 'asc')
                {
                    $data = collect($dataRead)->sortBy($col)->all();
                }
                if($sort === 'desc')
                {
                    $data = collect($dataRead)->sortByDesc($col)->all();
                }
                foreach ($data as $d) {
                    $date = date('d-m-Y', $d->date);
                    $time = date('H:m', $d->time);
                    $createdAt = date('d-m-Y H:i:s', $d->created_at);
                    $dataFix[] = [
                        'date'        => $date,
                        'time'        => $time,
                        'place'       => $d->place,
                        'temperature' => $d->temperature,
                        'created_at'  => $createdAt,
                    ];
                }
            } catch (Exception $e) {
                return redirect()->back()->with('error', 'Gagal register: '.$e->getMessage());
            }

            return DataTables::of($dataFix)->make(true);
        }
    }

    public function store(Request $r)
    {
        $rules = [
            'date'        => 'required|string',
            'time'        => 'required|string',
            'place'       => 'required|string',
            'temperature' => 'required|string',
        ];
  
        $messages = [
            'date.required'        => 'Tanggal wajib diisi',
            'date.string'          => 'Tanggal harus berupa string',
            'time.required'        => 'Jam wajib diisi',
            'time.string'          => 'Jam harus berupa string',
            'place.required'       => 'Lokasi wajib diisi',
            'place.string'         => 'Lokasi harus berupa string',
            'temperature.required' => 'Suhu wajib diisi',
            'temperature.string'   => 'Suhu harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
        
        $date         = strtotime($r->input('date'));
        $time         = strtotime($r->input('time'));
        $place        = $r->input('place');
        $temperaturex = $r->input('temperature');
        $temperature  = number_format((float)$temperaturex, 1, '.', '');
        $createdAt    = strtotime(now());

        $dataRead = Storage::disk('local')->exists('data.txt') ? json_decode(Storage::disk('local')->get('data.txt')) : [];
        
        if(empty($dataRead))
        {
            $id = 1;
        }
        else
        {
            $dataReadDesc = collect($dataRead)->sortByDesc('id')->first();
            $id = $dataReadDesc->id + 1;
        }

        $data = [
            'id'          => $id,
            'date'        => $date,
            'time'        => $time,
            'place'       => $place,
            'temperature' => $temperature,
            'created_at'  => $createdAt,
        ];
        array_push($dataRead,$data);
        Storage::disk('local')->put('data.txt', json_encode($dataRead));
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }
}
