@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <h2>Data Anak Yatim</h2>
    @can('viewAny', \App\Models\User::class)
        <a href="{{ route('yatim.create') }}" class="btn btn-primary mb-3">Tambah Data</a>
    @endcan
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-flex justify-content-end mb-3">
                    <form method="GET" action="{{ route('yatim.index') }}">
                        <div class="input-group" style="max-width: 250px;">
                            <input type="text" name="search" class="form-control" placeholder="Cari NIK..."
                                value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Cari</button>
                            </div>
                        </div>
                    </form>
                </div>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tempat, Tanggal lahir</th>
                            <th>Umur</th>
                            <th>Kecamatan</th>
                            <th>Kelurahan</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($datas as $warga)
                            <tr>
                                <td>{{ $warga->nik }}</td>
                                <td>{{ $warga->name }}</td>
                                <td>{{ $warga->place_of_birth }}, {{ $warga->date_of_birth }}</td>
                                <td>{{ $warga->umur }}</td>
                                <td>{{ $warga->kecamatan?->nama ?? '-' }}</td>
                                <td>{{ $warga->kelurahan?->nama ?? '-' }}</td>
                                <td>{{ $warga->alamat }}</td>
                                <td>
                                    <a href="{{ route('yatim.edit', $warga->id) }}"><span class="btn btn-sm btn-info"><i
                                                class="fas fa-solid fa-pen"></i></span></a>

                                    <form action="{{ route('yatim.destroy', $warga->id) }}" method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
