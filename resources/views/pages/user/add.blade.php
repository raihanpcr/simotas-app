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
                    <form method="POST" action="{{ route('user.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama" id="inputtext3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputtext3" class="col-sm-2 col-form-label">Username <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="username" id="inputtext3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputtext3" class="col-sm-2 col-form-label">Password <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="password" id="inputtext3">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputtext3" class="col-sm-2 col-form-label">Kecamatan<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="kecamatan_id" id="kecamatan" class="form-control" required>
                                    <option value="">Pilih Kecamatan</option>
                                    @foreach ($kecamatan as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Kelurahan<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="kelurahan_id" id="kelurahan" class="form-control">
                                    <option value="">Pilih Kelurahan</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputtext3" class="col-sm-2 col-form-label">Role<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="role" id="role" class="form-control" required>
                                    <option value="">Pilih Role</option>
                                    <option value="super_admin">Super Admin</option>
                                    <option value="kepala_dinas">Kepala Dinas</option>
                                    <option value="kepala_desa">Admin Desa</option>
                                </select>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#kecamatan').on('change', function() {
            var kecamatanID = $(this).val();

            $('#kelurahan').empty().append('<option value="">Loading...</option>');

            if (kecamatanID) {
                $.ajax({
                    url: "{{ route('get.kelurahan') }}",
                    type: "GET",
                    data: {
                        kecamatan_id: kecamatanID
                    },
                    success: function(data) {
                        $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
                        $.each(data, function(key, value) {
                            $('#kelurahan').append('<option value="' + value.id + '">' + value
                                .nama + '</option>');
                        });
                    }
                });
            } else {
                $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
            }
        });
    </script>
@endsection
