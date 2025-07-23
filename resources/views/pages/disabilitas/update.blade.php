@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <h2>Data Disabilitas</h2>
    <div class="row">
        <div class="col-md-6"> {{-- Ubah angkanya untuk menyesuaikan lebar --}}
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Data</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('warga.update', $data->id) }}">
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
                            <label class="col-sm-2 col-form-label">Kecamatan <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="kecamatan_id" id="kecamatan" class="form-control" required>
                                    <option value="">Pilih Kecamatan</option>
                                    @foreach ($kecamatan as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $data->kel_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- kelurahan --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Kelurahan <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="kelurahan_id" id="kelurahan" class="form-control" required>
                                    <option value="">Pilih Kelurahan</option>
                                    {{-- Saat pertama kali load, isi dengan kelurahan yang sesuai --}}
                                    @if ($kelurahan)
                                        @foreach ($kelurahan as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $data->kel_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
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
                                <button type="submit" class="btn btn-primary">Ubah Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
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
                            $('#kelurahan').empty().append(
                                '<option value="">Pilih Kelurahan</option>');
                            $.each(data, function(key, value) {
                                $('#kelurahan').append('<option value="' + value.id +
                                    '">' + value.nama + '</option>');
                            });
                        }
                    });
                } else {
                    $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
                }
            });

            // trigger change jika sudah ada kecamatan dan kelurahan terpilih
            let selectedKecamatan = "{{ $data->kecamatan_id }}";
            let selectedKelurahan = "{{ $data->kelurahan_id }}";
            if (selectedKecamatan) {
                $('#kecamatan').val(selectedKecamatan).trigger('change');

                // tunggu ajax selesai dulu sebelum set kelurahan (optional improvement pakai callback/promise)
                setTimeout(function() {
                    $('#kelurahan').val(selectedKelurahan);
                }, 500);
            }
        });
    </script>

@endsection
