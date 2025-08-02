@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <h2>Data Bantuan Sosial</h2>
    @can('viewAny', \App\Models\User::class)
        <a href="{{ route('bansos.create') }}" class="btn btn-primary mb-3">Tambah Data</a>
    @endcan
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kecamatan</th>
                            <th>Kelurahan</th>
                            <!-- <th>Link Google Map</th> -->
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($datas as $bansos)
                            <tr>
                                <td>{{ $bansos->kecamatan?->nama ?? '-' }}</td>
                                <td>{{ $bansos->kelurahan?->nama ?? '-' }}</td>
                                <!-- <td><a href="{{ $bansos->link_map }}">{{ $bansos->link_map }}</a> </td> -->
                                <td>{{ $bansos->alamat }}</td>
                                <td>
                                    <a href="{{ route('bansos.show', $bansos->id) }}"><span class="btn btn-sm btn-info"><i
                                                class="fas fa-eye"></i></span></a>
                                    @can('viewAny', \App\Models\User::class)
                                        <a href="{{ route('bansos.edit', $bansos->id) }}"><span
                                                class="btn btn-sm btn-warning"><i class="fas fa-solid fa-pen"></i></span></a>

                                        <form action="{{ route('bansos.destroy', $bansos->id) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $datas->links() }}
            </div>
        </div>
    </div>
@endsection
