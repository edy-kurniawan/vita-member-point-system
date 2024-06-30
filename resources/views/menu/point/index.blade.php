@extends('layouts.template')
@section('css')
<!-- Sweet Alert-->
<link href="{{ url('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ url('assets/libs/toastr/build/toastr.min.css') }}">
<link href="{{ url('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
    type="text/css">
@endsection
@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Laporan Transaksi</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Data transaksi yang dilakukan akan terekam disini.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 card-title flex-grow-1">Data transaksi</h5>
                    </div>
                </div>
                <div class="card-body border-bottom">
                    <div class="row g-3">
                        <div class="col-xxl-6 col-lg-4">
                            <div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy"
                                data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                <input type="text" class="form-control" name="start" value="{{ date('d M, Y') }}"
                                    placeholder="Start" />
                                <input type="text" class="form-control" name="end" value="{{ date('d M, Y') }}"
                                    placeholder="End" />
                            </div>
                        </div>
                        <div class="col-xxl-2 col-lg-3">
                            <select name="created_by" id="created_by" class="form-control select2">
                                <option value="all" selected>-- Semua Kasir --</option>
                                @foreach($kasir as $data)
                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xxl-2 col-lg-3">
                            <select name="transaksi" id="transaksi" class="form-control select2">
                                <option value="all" selected>-- Semua Transaksi --</option>
                                <option value="Pengumpulan Point">Pengumpulan Point</option>
                                <option value="Penukaran Point">Penukaran Point</option>
                            </select>
                        </div>
                        <div class="col-xxl-2 col-lg-2">
                            <button type="button" onclick="table.draw()" class="btn btn-soft-secondary w-100"><i
                                    class="mdi mdi-filter-outline align-middle"></i> Filter</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Kode</th>
                                <th scope="col">Member</th>
                                <th scope="col" class="text-right">Total Point</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->

    </div>
    <!--end row-->
    <!-- sample modal content -->
    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="myModalLabel">Transaksi Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="invoice-title">
                        <h4 class="float-end font-size-16">Transaksi # <span id="kode_transaksi">0</span> </h4>
                        <div class="mb-2">
                            <h4>VITA FASHION STORE</h4>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <address>
                                <strong>Member:</strong><br>
                                <span id="nama_member">0</span><br>
                                <span id="no_hp">0</span><br>
                                <span id="alamat">0</span><br>
                            </address>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <address class="mt-2 mt-sm-0">
                                <strong>Tanggal Transaksi:</strong><br>
                                <span id="tanggal_transaksi">0</span>
                            </address>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="table" class="table table-nowrap align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 70px;">No.</th>
                                    <th>Foto</th>
                                    <th>Reward</th>
                                    <th class="text-end">Point</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong><span id="jenis">Total</span></strong></td>
                                    <td class="text-end"><strong id="total_point">0</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
@endsection
@section('js')
<!-- Sweet Alerts js -->
<script src="{{ url('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- toastr plugin -->
<script src="{{ url('assets/libs/toastr/build/toastr.min.js') }}"></script>
<script src="{{ url('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ url('assets/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
<script src="{{ url('assets/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
{{-- <script src="{{ url('assets/js/pages/form-advanced.init.js') }}"></script> --}}
<script>
    var table;

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            ajax: {
                  url: '{{ route('point.index') }}',
                  type: "GET",
                  data: function(data) {
                    data.start  = $('input[name=start]').val();
                    data.end    = $('input[name=end]').val();
                    data.created_by = $('#created_by').val();
                    data.transaksi  = $('#transaksi').val();
                    data.type = 'transaksi';
                  }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'tanggal_transaksi', name: 'tanggal_transaksi'},
                {data: 'kode', name: 'kode'},
                {data: 'member.nama', name: 'member.nama'},
                {data: 'total_point', name: 'total_point', className: 'text-right', render: $.fn.dataTable.render.number( '.', ',',0, '' )},
                {data: 'aksi', name: 'aksi', orderable: false, searchable: false}
            ],
        });

    });

    function modalTransaksi(id) {
        // get data transaksi
        $.ajax({
            url: '/point/' + id + '/edit?type=transaksi',
            type: 'GET',
            success: function(response) {
                console.log(response);
                $('#kode_transaksi').text(response.data.kode);
                $('#nama_member').text(response.data.member.nama);
                $('#no_hp').text(response.data.member.no_hp);
                $('#alamat').text(response.data.member.alamat);
                // change format date
                var date = response.data.tanggal_transaksi.split('-').reverse().join('/');
                $('#tanggal_transaksi').text(response.data.tanggal_transaksi);
                var total_point = response.data.total_point.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                $('#total_point').text(total_point);
                $('#myModal').modal('show');
                $('#myModal tbody').empty();
                // if penukaran point
                if (response.data.detail_transaksi.length != 0) {
                    $('#jenis').text('Total point ditukarkan');
                    $.each(response.data.detail_transaksi, function(index, value) {
                        var point = value.point.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                        $('#myModal tbody').append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td><img src="/storage/images/reward/${value.reward.foto}" alt="${value.reward.nama}" class="rounded" height="50"></td>
                                <td>${value.reward.nama}</td>
                                <td class="text-end">${point}</td>
                            </tr>
                        `);
                    });
                }else{
                    $('#jenis').text('Total point dikumpulkan');
                    var total_pembelian = response.data.total_pembelian.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    if (response.data.jenis == 'penukaran-emas') {
                        $('#myModal tbody').append(`
                            <tr>
                                <td colspan="4" class="text-center">${total_pembelian} Penukaran Emas</td>
                            </tr>
                        `);
                    }else{
                        $('#myModal tbody').append(`
                            <tr>
                                <td colspan="4" class="text-center">Total pembelian Rp. ${total_pembelian}</td>
                            </tr>
                        `);
                    }
                }
            }
        });
    }

    function returButton(id) {
        Swal.fire({
            title: 'Hapus transaksi?',
            text: "Data yang sudah dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#556ee6',
            cancelButtonColor: '#f46a6a',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/point/' + id + '/edit?type=retur',
                    type: 'GET',
                    success: function(response) {
                        table.draw();
                        toastr.success(response.message);
                    }
                });
            }
        });
    }

</script>

@endsection