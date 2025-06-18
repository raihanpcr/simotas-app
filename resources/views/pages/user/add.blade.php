@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <h2>Data Pengguna</h2>
    <div class="row">
        <div class="col-md-8"> {{-- Ubah angkanya untuk menyesuaikan lebar --}}
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Data Pengguna</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('lansia.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nik" id="inputtext3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputtext3" class="col-sm-2 col-form-label">Username <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="inputtext3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputtext3" class="col-sm-2 col-form-label">Password <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="tempat_lahir" id="inputtext3">
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
