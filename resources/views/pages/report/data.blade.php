@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
    <h2>Laporan</h2>
    <form action="{{ route('export.warga') }}" method="GET">
        <div class="form-group row">
            <div class="col-sm-3">
                <input type="number" class="form-control" name="tahun" min="1900" max="2099" step="1"
                    placeholder="Masukkan Tahun">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-3">
                <select name="kategori" id="kategori" class="form-control">
                    <option value="Disabilitas">Disabilitas</option>
                    <option value="Yatim">Yatim</option>
                    <option value="Lansia">Lansia</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-3">
                <select name="kecamatan" class="form-control" id="kecamatan"
                    {{ !in_array(auth()->user()->role, ['super_admin', 'kepala_dinas']) ? 'disabled' : '' }}>
                    <option value="">Pilih Kecamatan</option>
                    @foreach ($kecamatan as $kec)
                        <option value="{{ $kec->id }}"
                            {{ auth()->user()->kecamatan_id == $kec->id ? 'selected' : '' }}>
                            {{ $kec->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        @if (auth()->user()->role == 'kepala_desa')
            <input type="hidden" name="kecamatan" value="{{ auth()->user()->kecamatan_id }}">
        @else
            <input type="hidden" name="kecamatan" value="">
        @endif

        {{-- Dropdown Kelurahan --}}
        <div class="form-group row">
            <div class="col-sm-3">
                <select name="kelurahan_id" id="kelurahan" class="form-control"
                    {{ auth()->user()->role == 'kepala_desa' ? 'disabled' : '' }}>
                    <option value="">Pilih Kelurahan</option>

                    {{-- Untuk kepala_desa: preload kelurahan --}}
                    @if (auth()->user()->role == 'kepala_desa')
                        @php
                            $kelurahanUser = \App\Models\Kelurahan::find(auth()->user()->kelurahan_id);
                        @endphp
                        @if ($kelurahanUser)
                            <option value="{{ $kelurahanUser->id }}" selected>{{ $kelurahanUser->nama }}</option>
                        @endif
                    @endif
                </select>
            </div>
        </div>

        {{-- Hidden input kelurahan untuk kepala_desa --}}
        @if (auth()->user()->role == 'kepala_desa')
            <input type="hidden" name="kelurahan_id" value="{{ auth()->user()->kelurahan_id }}">
        @endif

        <button type="submit" class="btn btn-success">Export Excel</button>
    </form>
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
