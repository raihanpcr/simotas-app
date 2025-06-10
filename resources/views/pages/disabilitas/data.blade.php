@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <h2>Data Disabilitas</h2>
    <a href="{{ route('warga.add') }}" class="btn btn-primary mb-3">Tambah Data</a>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tempat, Tanggal lahir</th>
                            <th>Umur</th>
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
                                <td>{{ $warga->alamat }}</td>
                                <td>
                                    <a href="{{ route('lansia.edit', $warga->id) }}"><span class="btn btn-sm btn-info"><i
                                                class="fas fa-solid fa-pen"></i></span></a>

                                    <form action="{{ route('lansia.destroy', $warga->id) }}" method="POST"
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
