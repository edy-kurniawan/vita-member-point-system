@extends('layouts.template')
@section('css')
@endsection
@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Setting</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Halaman ini hanya bisa diakses oleh admin.</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mx-2 my-2" role="alert">
                <i class="mdi mdi-check-all me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
        <div class="col-xl-5">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">VITA MEMBER POINT SYSTEM</h4>
                    <p class="card-title-desc">Anda dapat mengatur poin member pada halaman ini.</p>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <a class="nav-link mb-2 active" id="v-pills-home-tab" data-bs-toggle="pill"
                                    href="#v-pills-home" role="tab" aria-controls="v-pills-home"
                                    aria-selected="true">General <i class="mdi mdi-chevron-right float-end"></i></a>
                                <a class="nav-link mb-2" id="v-pills-profile-tab" data-bs-toggle="pill"
                                    href="#v-pills-profile" role="tab" aria-controls="v-pills-profile"
                                    aria-selected="false">About <i class="mdi mdi-chevron-right float-end"></i></a>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                    aria-labelledby="v-pills-home-tab">
                                    <form action="{{ route('setting.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="formrow-firstname-input" class="form-label">Range Expired Member
                                                :</label>
                                            <div class="input-group" id="timepicker-input-group1">
                                                <input type="number" class="form-control" name="range_expired_member"
                                                    placeholder="Masukan total hari member baru expired"
                                                    value="{{ $range_expired_member->value }}">
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                            <small class="text-muted">Range waktu expired member baru dalam format
                                                hari.</small>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Perolehan point pertransaksi :</label>
                                            <div class="input-group" id="timepicker-input-group1">
                                                <input name="point_from_trx" type="number" step="0.01" class="form-control" min="0"
                                                    max="100" placeholder="Masukan persentase point"
                                                    value="{{ $point_from_trx->value }}">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <small class="text-muted">Masukan persentase point yang diperoleh dari total
                                                transaksi pembelian.</small>
                                            <p class="text-muted"><a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#settingModal">Contoh perhitungan point</a></p>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan <i
                                                class="mdi mdi-content-save"></i></button>
                                    </form>

                                </div>
                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                    aria-labelledby="v-pills-profile-tab">
                                    <div class="text-center">
                                        <img src="{{ url('logo.png') }}" alt="logo" class="img-fluid"
                                            style="width: 100px;">
                                        <h5 class="mt-3">VITA MEMBER POINT SYSTEM</h5>
                                        <p class="text-muted font-13">Vita Member Point System adalah aplikasi yang
                                            digunakan untuk mengelola poin member.</p>
                                        <p class="text-muted font-13">Versi 1.0.0</p>
                                        <p class="text-muted font-13">© VITA FASHION STORE. {{ date('Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <div class="col-xl-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-1">Dokumentasi</h4>
                    <p class="card-title-desc">Petunjuk dan tutorial pengguaan sistem</p>
                    <iframe src="/dokumentasi-software.pdf" width="100%" height="500px" class="mt-1"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- sample modal content -->
    <div id="settingModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Perhitungan point</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-center">Contoh perhitungan point member</p>
                    <blockquote class="blockquote font-size-12 mb-0">
                    <p>Perolehan point pertransaksi : {{ $point_from_trx->value }}%</p>
                    <p><strong>Total transaksi pembelian : Rp. 1.000.000</strong></p>
                    <p>Point yang diperoleh : (Rp. 1.000.000 * {{ $point_from_trx->value }}%) =
                        {{ number_format($point_from_trx->value / 100 * 1000000) }}</p>
                    <p><strong>Total transaksi pembelian : Rp. 500.000</strong></p>
                    <p>Point yang diperoleh : (Rp. 500.000 * {{ $point_from_trx->value }}%) =
                        {{ number_format($point_from_trx->value / 100 * 500000) }}</p>
                    <p><strong>Total transaksi pembelian : Rp. 100.000</strong></p>
                    <p>Point yang diperoleh : (Rp. 100.000 * {{ $point_from_trx->value }}%) =
                        {{ number_format($point_from_trx->value / 100 * 100000) }}</p>
                    </blockquote>
                    <p class="mt-2">Point yang diperoleh akan diakumulasikan dan dapat digunakan untuk pembelian selanjutnya.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
@endsection
@section('js')
@endsection