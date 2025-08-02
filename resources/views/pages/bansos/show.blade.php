@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <h2>Detail Data Bantuan Sosial</h2>
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Peta</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="{{ $data->link_map }}" allowfullscreen loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Detail</h6>

                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="pt-4 pb-2">
                        <div class="row mb-2">
                            <div class="col-4 font-weight-bold">Kecamatan</div>
                            <div class="col-1">:</div>
                            <div class="col-7">{{ $data->kecamatan->nama }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 font-weight-bold">Kelurahan</div>
                            <div class="col-1">:</div>
                            <div class="col-7">{{ $data->kelurahan->nama }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 font-weight-bold">Alamat</div>
                            <div class="col-1">:</div>
                            <div class="col-7">{{ $data->alamat }}</div>
                        </div>
                        <!-- <div class="row mb-2">
                            <div class="col-4 font-weight-bold">Link Map</div>
                            <div class="col-1">:</div>
                            <div class="col-7">
                                <a href="{{ $data->link_map }}" target="_blank" class="btn btn-sm btn-success">
                                    <i class="fas fa-map-marker-alt"></i> Lihat di Google Maps
                                </a>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
