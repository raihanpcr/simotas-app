@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <h2>Data Pengguna</h2>
    @can('viewAny', \App\Models\User::class)
        <a href="{{ route('user.create') }}" class="btn btn-primary mb-3">Tambah Data</a>
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
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Kecamatan</th>
                            <th>Kelurahan</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($datas as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->password_string }}</td>
                                <td>{{ $user->kecamatan?->nama ?? '-' }}</td>
                                <td>{{ $user->kelurahan?->nama ?? '-' }}</td>
                                <td>{{ $user->role }}</td>

                                <td>
                                    <a href="{{ route('user.edit', $user->id) }}"><span class="btn btn-sm btn-info"><i
                                                class="fas fa-solid fa-pen"></i></span></a>

                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST"
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
                {{ $datas->links() }}
            </div>
        </div>
    </div>
@endsection
