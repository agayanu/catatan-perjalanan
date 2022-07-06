@extends('layouts.app')

@section('header')
@include('layouts.app-header')
@endsection

@section('content')
<div class="alert alert-info alert-dismissible fade show" role="alert">
    Selamat Datang <strong>{{ Session::get('user')['name'] }}</strong> di aplikasi Catatan Perjalanan
    <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
</div>
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
    <div class="card-body">
        <div class="row">
            <div class="col-photo">
                @if (empty(Session::get('user')['photo']))
                    <img src="{{ asset('photo/profile.png') }}" alt="profile" class="img-profile">
                @else
                    <img src="{{ asset(Session::get('user')['photo']) }}" alt="profile" class="img-profile">
                @endif
            </div>
            <div class="col">
                <div class="row">
                    <div class="profile-name">{{ Session::get('user')['name'] }}</div>
                </div>
                <div class="row">
                    <div class="profile-nik">{{ Session::get('user')['nik'] }}</div>
                </div>
                <div class="row">
                    <button class="btn btn-sm btn-primary btn-size-x" type="button" data-coreui-toggle="modal" data-coreui-target="#edit"><i class="cil-pencil" style="font-weight:bold"></i> Edit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" class="validation-update" novalidate>
                @csrf
                    <input type="hidden" name="nik_old" value="{{ Session::get('user')['nik'] }}">
                    <input type="hidden" name="photo_old" value="{{ Session::get('user')['photo'] }}">
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">NIK <div class="required">*</div></label>
                            <input type="text" class="form-control" name="nik_new" value="{{ Session::get('user')['nik'] }}" required>
                            <div class="invalid-feedback">NIK Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Nama <div class="required">*</div></label>
                            <input type="text" class="form-control" name="name" value="{{ Session::get('user')['name'] }}" required>
                            <div class="invalid-feedback">Nama Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Photo <div class="required">*</div></label>
                            <input type="file" class="form-control" name="photo">
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
@include('layouts.validation-update')
@endsection