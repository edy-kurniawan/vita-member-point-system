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
                                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&rounded=true&color=7F9CF5&background=EBF4FF"
                                        alt="" class="avatar-md rounded-circle img-thumbnail">
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

                        <div class="col-lg-6 align-self-center">
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
                                            <h5 class="mb-0">{{ date('d/m/Y H:i', strtotime(Auth::user()->last_active))
                                                }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-2 d-none d-lg-block">
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
                                    <span class="avatar-title rounded-circle bg-primary-subtle text-white font-size-18">
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
                                    <span class="avatar-title rounded-circle bg-primary-subtle text-white font-size-18">
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
                                    <span class="avatar-title rounded-circle bg-primary-subtle text-white font-size-18">
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
                    <h4 class="card-title mb-4">Grafik Total Transaksi</h4>

                    <div id="line_chart_datalabel" data-colors='["--bs-primary", "--bs-success"]' class="apex-charts"
                        dir="ltr"></div>
                </div>
            </div>
            <!--end card-->
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-2">Daftar Member Ulang Tahun Bulan Ini</h4>
                    <div class="table-responsive">
                        <table id="table" class="table table-centered table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Tanggal Lahir</th>
                                    <th>No. Telp</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($member as $key => $item)
                                {{-- set color red --}}
                                @if(date('m-d', strtotime($item->tanggal_lahir)) == date('m-d'))
                                <tr style="background-color: #ffcccc;">
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->kode }}</td>
                                    <td><a href="/member/{{ $item->id }}">{{ $item->nama }}</a></td>
                                    <td>{{ date('d/m/Y', strtotime($item->tanggal_lahir)) }}</td>
                                    <td><a href="https://wa.me/{{ $item->no_hp }}" target="_blank">{{ $item->no_hp }}</a></td>
                                </tr>
                                @else
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->kode }}</td>
                                    <td><a href="/member/{{ $item->id }}">{{ $item->nama }}</a></td>
                                    <td>{{ date('d/m/Y', strtotime($item->tanggal_lahir)) }}</td>
                                    <td><a href="https://wa.me/{{ $item->no_hp }}" target="_blank">{{ $item->no_hp }}</a></td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<!-- apexcharts -->
<script src="{{ url('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script>
    function getChartColorsArray(e) {
        if (null !== document.getElementById(e)) {
            var t = document.getElementById(e).getAttribute("data-colors");
            if (t) return (t = JSON.parse(t)).map(function(e) {
                var t = e.replace(" ", "");
                if (-1 === t.indexOf(",")) {
                    var r = getComputedStyle(document.documentElement).getPropertyValue(t);
                    return r || t
                }
                var o = e.split(",");
                return 2 != o.length ? t : "rgba(" + getComputedStyle(document.documentElement).getPropertyValue(o[0]) + "," + o[1] + ")"
            });
            console.warn("data-colors Attribute not found on:", e)
        }
    }

    function numberWithDots(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    var lineChartDatalabelColors = getChartColorsArray("line_chart_datalabel");
    lineChartDatalabelColors && (options = {
        chart: {
            height: 380,
            type: "line",
            zoom: {
                enabled: !1
            },
            toolbar: {
                show: !1
            }
        },
        colors: lineChartDatalabelColors,
        dataLabels: {
            enabled: !1
        },
        stroke: {
            width: [3, 3],
            curve: "straight"
        },
        series: [{
            name: "Total Pembelian",
            data: {!! json_encode($total_pembelian) !!}
        }],
        title: {
            text: "Total pembelian per bulan",
            align: "left",
            style: {
                fontWeight: "500"
            }
        },
        grid: {
            row: {
                colors: ["transparent", "transparent"],
                opacity: .2
            },
            borderColor: "#f1f1f1"
        },
        markers: {
            style: "inverted",
            size: 6
        },
        xaxis: {
            categories: {!! json_encode($bulan) !!},
            title: {
                text: "Month"
            }
        },
        yaxis: {
            title: {
                text: "Total Pembelian"
            },
            labels: {
                formatter: function(val) {
                    return numberWithDots(Math.round(val));
                }
            }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return numberWithDots(val);
                }
            }
        },
        legend: {
            position: "top",
            horizontalAlign: "right",
            floating: !0,
            offsetY: -25,
            offsetX: -5
        },
        responsive: [{
            breakpoint: 600,
            options: {
                chart: {
                    toolbar: {
                        show: !1
                    }
                },
                legend: {
                    show: !1
                }
            }
        }]
    }, (chart = new ApexCharts(document.querySelector("#line_chart_datalabel"), options)).render());
</script>
<script>
    var table;

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        table = $('#table').DataTable({});

    });
</script>
@endsection