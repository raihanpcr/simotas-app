@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <h2>Data Lansia</h2>
    <div class="row">
        <div class="col-md-8"> {{-- Ubah angkanya untuk menyesuaikan lebar --}}
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Data</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('lansia.update', $data->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">NIK</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nik" id="inputtext3"
                                    value="{{ $data->nik }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputtext3" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="{{ $data->name }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputtext3" class="col-sm-2 col-form-label">Tempat Lahir</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="tempat_lahir"
                                    value="{{ $data->place_of_birth }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputtext3" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="tanggal_lahir"
                                    value="{{ $data->date_of_birth }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputtext3" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <textarea name="alamat" class="form-control" name="alamat" cols="30" rows="10">{{ $data->alamat }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Tambah Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
