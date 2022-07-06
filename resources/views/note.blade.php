@extends('layouts.app')

@section('header')
@include('layouts.app-header')
{{-- JQuery --}}
<script src="{{asset('jquery/jquery-3.6.0.min.js')}}"></script>
{{-- Datatables --}}
<link rel="stylesheet" href="{{asset('DataTables/datatables.min.css')}}">
<script src="{{asset('DataTables/datatables.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('DataTables/Responsive-2.3.0/css/responsive.dataTables.min.css')}}">
<script src="{{asset('DataTables/Responsive-2.3.0/js/responsive.dataTables.min.js')}}"></script>
{{-- DateTimePicker --}}
<script src="{{asset('DateTimePicker/moment/moment.js')}}"></script>
<script src="{{asset('DateTimePicker/bootstrap-4.1.3/js/bootstrap.bundle.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('DateTimePicker/bootstrap-datetimepicker-4.17.47.min.css')}}">
<script src="{{asset('DateTimePicker/bootstrap-datetimepicker-4.17.47.min.js')}}"></script>
@include('layouts.app-header-style')
@endsection

@section('content')
@include('layouts.flash-message')
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Terdapat Kesalahan :
        <ul>
            {!! implode('', $errors->all('<li>:message</li>')) !!}
        </ul>
        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="card">
    <div class="card-header">
        <button class="btn btn-sm btn-primary" type="button" data-coreui-toggle="modal" data-coreui-target="#tambah"><i class="cil-plus" style="font-weight:bold"></i> Tambah</button>
    </div>
    <div class="card-body">
        <form action="" method="get">
            <div class="row">
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Urutkan Berdasarkan <div class="required">*</div></label>
                    <select name="col" class="form-select" required>
                        <option value="date" {{ $col === 'date' ? 'selected' : '' }}>Tanggal</option>
                        <option value="time" {{ $col === 'time' ? 'selected' : '' }}>Waktu</option>
                        <option value="created_at" {{ $col === 'created_at' ? 'selected' : '' }}>Update</option>
                    </select>
                    <div class="invalid-feedback">Urutkan Berdasarkan Wajib Diisi!</div>
                </div>
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Urutan <div class="required">*</div></label>
                    <select name="sort" class="form-select" required>
                        <option value="asc" {{ $sort === 'asc' ? 'selected' : '' }}>Dari Atas</option>
                        <option value="desc" {{ $sort === 'desc' ? 'selected' : '' }}>Dari Bawah</option>
                    </select>
                    <div class="invalid-feedback">Urutan Wajib Diisi!</div>
                </div>
                <div class="col-sm-3 mb-3 align-self-end">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </div>
        </form>
        <hr/>
        <div class="table-responsive">
            <table class="display nowrap" id="datatable" style="width:100%">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Lokasi</th>
                        <th>Suhu Tubuh</th>
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="validation-update" novalidate>
                @csrf
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Tanggal <div class="required">*</div></label>
                            <input type='text' class="form-control" placeholder="dd-mm-yyyy" name="date" id="date" required/>
                            <div class="invalid-feedback">Tanggal Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Jam <div class="required">*</div></label>
                            <input type='text' class="form-control" placeholder="hh:mm" name="time" id="time" required/>
                            <div class="invalid-feedback">Jam Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Lokasi yang dikunjungi <div class="required">*</div></label>
                            <input type="text" class="form-control" name="place" required>
                            <div class="invalid-feedback">Lokasi Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Suhu Tubuh <div class="required">*</div></label>
                            <input type="number" step=".1" max="100" class="form-control" name="temperature" required>
                            <div class="invalid-feedback">Suhu Wajib Diisi! Atau Maksimal 100! Atau Maksimal 1 Angka dibelakang koma</div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
                <img src="{{asset('images/load.gif')}}" id="spinner-update" class="spin hide">
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script>
$('#date').datetimepicker({
    locale: 'id',
    format: 'DD-MM-YYYY'
});
$('#time').datetimepicker({
    locale: 'id',
    format: 'HH:mm'
});
$(function () {        
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('note-data',['col'=>$col,'sort'=>$sort]) }}".replace(/&amp;/g, "&"),
        columns: [
            {data: 'date', name: 'date', orderable: false},    
            {data: 'time', name: 'time', orderable: false},
            {data: 'place', name: 'place'},
            {data: 'temperature', name: 'temperature'},
            {data: 'created_at', name: 'created_at', orderable: false},
        ],
        responsive: true
    });
});
</script>
@include('layouts.validation-update')
@endsection