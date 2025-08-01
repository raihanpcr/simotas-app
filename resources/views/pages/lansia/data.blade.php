@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <h2>Data Lansia</h2>
    @if (auth()->user()->role != 'kepala_dinas')
        <a href="{{ route('lansia.create') }}" class="btn btn-primary mb-3">Tambah Data</a>
    @endif
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Lansia</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-flex justify-content-end mb-3">
                    <form method="GET" action="{{ route('lansia.index') }}">
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
                            <th>Status</th>
                            @can('viewAny', \App\Models\User::class)
                                <th>Aksi</th>
                            @endcan
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
                                    @if ($warga->status === 'waiting')
                                        <span class="badge bg-warning text-dark">Waiting</span>
                                    @elseif ($warga->status === 'accept')
                                        <span class="badge bg-success text-dark">Accept</span>
                                    @elseif ($warga->status === 'rejected')
                                        <span class="badge bg-danger text-white">Rejected</span>
                                    @else
                                        <span class="badge bg-secondary text-dark">{{ ucfirst($warga->status) }}</span>
                                    @endif
                                </td>
                                @if (auth()->user()->role === 'kepala_dinas' || auth()->user()->role === 'super_admin')
                                    <td>
                                        <a href="{{ route('lansia.edit', $warga->id) }}"><span
                                                class="btn btn-sm btn-info"><i class="fas fa-solid fa-pen"></i></span></a>

                                        <form action="{{ route('lansia.destroy', $warga->id) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                        @if ($warga->status === 'waiting' && auth()->user()->role === 'super_admin')
                                            {{-- Tombol ACC --}}
                                            <form
                                                action="{{ route('warga.updateStatus', ['id' => $warga->id, 'status' => 'accept']) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-success" title="Terima">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>

                                            {{-- Tombol Tolak --}}
                                            <form
                                                action="{{ route('warga.updateStatus', ['id' => $warga->id, 'status' => 'rejected']) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Tolak">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
