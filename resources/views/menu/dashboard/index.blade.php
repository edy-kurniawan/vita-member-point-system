@extends('layouts.template')
@section('css')
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&rounded=true&color=7F9CF5&background=EBF4FF" alt=""
                                        class="avatar-md rounded-circle img-thumbnail">
                                </div>
                                <div class="flex-grow-1 align-self-center">
                                    <div class="text-muted">
                                        <p class="mb-2">Welcome to Vita Member Point System</p>
                                        <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                                        <p class="mb-0">
                                            {{ Auth::user()->role }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5 align-self-center">
                            <div class="text-lg-center mt-4 mt-lg-0">
                                <div class="row">
                                    <div class="col-4">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">IP Address</p>
                                            <h5 class="mb-0">{{ Request::ip() }}</h5>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">Last Login</p>
                                            <h5 class="mb-0">{{ date('d/m/Y H:i', strtotime(Auth::user()->last_active)) }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 d-none d-lg-block">
                            <div class="clearfix mt-4 mt-lg-0">
                                <div class="dropdown float-end">
                                    <a href="/user/profile" class="btn btn-primary">
                                        <i class="bx bxs-cog align-middle me-1"></i> Setting
                                </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span
                                        class="avatar-title rounded-circle bg-primary-subtle text-white font-size-18">
                                        <i class="fas fa-coins"></i>
                                    </span>
                                </div>
                                <h5 class="font-size-14 mb-0">Total Pengumpulan Point</h5>
                            </div>
                            <div class="text-muted mt-4">
                                <h4>{{ number_format($pengumpulan)}} Transaksi</h4>
                                <span class="ms-2 text-truncate">Transaksi hari ini oleh anda</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span
                                        class="avatar-title rounded-circle bg-primary-subtle text-white font-size-18">
                                        <i class="bx bx-transfer"></i>
                                    </span>
                                </div>
                                <h5 class="font-size-14 mb-0">Penukaran Point</h5>
                            </div>
                            <div class="text-muted mt-4">
                                <h4>{{ number_format($penukaran_point)}} Transaksi</h4>
                                <span class="ms-2 text-truncate">Transaksi hari ini oleh anda</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span
                                        class="avatar-title rounded-circle bg-primary-subtle text-white font-size-18">
                                        <i class="fas fa-users"></i>
                                    </span>
                                </div>
                                <h5 class="font-size-14 mb-0">Total Member</h5>
                            </div>
                            <div class="text-muted mt-4">
                                <h4>{{ number_format($total_member)}}</h4>
                                <span class="ms-2 text-truncate">Transaksi hari ini oleh anda</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Line with Data Labels</h4>

                    <div id="line_chart_datalabel" data-colors='["--bs-primary", "--bs-success"]' class="apex-charts" dir="ltr"></div>                              
                </div>
            </div><!--end card-->
        </div>
    </div>
</div>
@endsection
@section('js')
<!-- apexcharts -->
<script src="{{ url('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<!-- apexcharts init -->
<script src="{{ url('assets/js/pages/apexcharts.init.js') }}"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    });

</script>

@endsection