@extends('layouts.template_horizontal')
@section('css')
<link href="{{ url('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Transaksi Penukaran Point</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Halaman yang digunakan untuk menukarkan
                            point member</a></li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-6 col-12">
                        <h5 class="card-title">Reward Cart</h5>
                    </div> <!-- end col -->
                    <div class="col-md-6 col-12">
                        <div class="text-sm-end">
                            <button onclick="rewardModal()" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i> Cari Reward</button>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row-->
                <div class="table-responsive">
                    <table id="table-cart" class="table align-middle mb-0 table-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Point</th>
                                <th>Qty</th>
                                <th colspan="2">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3 text-center">Ringkasan Penukaran Point</h4>
                <hr style="border-top: 1px solid #3b3b3b;">

                <div class="row">
                    <div class="col-12 col-md-7">
                        <div class="mb-2">
                            <label for="formrow-firstname-input" class="form-label">Kode Transaksi :</label>
                            <input type="text" class="form-control" value="TRX-{{ date('Ymd') }}" disabled>
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="mb-2">
                            <label for="formrow-firstname-input" class="form-label">Tanggal :</label>
                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="mb-2 ajax-select mt-2 mt-lg-0">
                    <label class="form-label">Member :</label>
                    <select id="cari-member" class="form-control select2-ajax"></select>

                </div>

                <div class="table-responsive">
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <td>Total Point Member :</td>
                                <td class="text-end"><span id="point-member">0</span>
                            </tr>
                            <tr>
                                <td>Total Point Reward :</td>
                                <td class="text-end">25</td>
                            </tr>
                            <tr>
                                <th>Sisa Point Member:</th>
                                <th class="text-end">22</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    <button type="button" class="btn btn-primary mt-3">Simpan Transaksi Penukaran Point <i
                            class="fas fa-save ms-2"></i></button>
                </div>
                <!-- end table-responsive -->
            </div>
        </div>
        <!--  Extra Large modal example -->
        <div id="rewardModal" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">Cari reward yang akan ditukarkan</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table id="table" class="table table-bordered dt-responsive align-middle nowrap w-100 mt-1">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Point</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <small class="text-muted">*)Hanya menampilkan reward yang pointnya cukup untuk ditukarkan oleh member</small>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
    <!-- end card -->
</div>
<!-- end row -->
@endsection
@section('js')
<script src="{{ url('assets/libs/select2/js/select2.min.js') }}"></script>
<script src="{{ url('assets/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
<!-- Bootrstrap touchspin -->
<script src="{{ url('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ url('assets/js/pages/ecommerce-cart.init.js') }}"></script>
<script>
    ! function(s) {
    "use strict";

    function e() {}
    e.prototype.init = function() {
        s(".select2").select2(), s(".select2-ajax").select2({
            ajax: {
                url: "/member/1/edit",
                dataType: "json",
                delay: 250,
                data: function (params) {
                    var query = {
                        keyword: params.term,
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data
                    };
                },
                cache: !0
            },
            placeholder: "Masukan kode / nama member",
            minimumInputLength: 1
        })
    }, s.AdvancedForm = new e, s.AdvancedForm.Constructor = e
}(window.jQuery),
function() {
    "use strict";
    window.jQuery.AdvancedForm.init()
}();

</script>
<script>
    let table;
    let table_cart;

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                  url: '{{ route('point.create') }}',
                  type: "GET",
            },
            columns: [
                {data: 'foto', name: 'foto'},
                {data: 'kode', name: 'kode'},
                {data: 'reward', name: 'reward'},
                {data: 'point', name: 'point', render: $.fn.dataTable.render.number( '.', ',',0, '' ), className: 'text-right'},
                {data: 'action', name: 'action'},
            ]
        });

    });

    $('#cari-member').on('select2:select', function (e) {
        // change format number
        var point = e.params.data.total_point.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        $('#point-member').text(point);
    });

    function rewardModal() {
        // open modal
        $('#rewardModal').modal('show');
    }

    function cartButton(id){
        $.ajax({
            url: '{{ route('point.update', 10) }}',
            data: {
                id:id
            },
            type: 'PUT',
            success: function(response) {
                console.log(response);
                if(response.status) {
                    table.draw();
                }
            }
        });
    }

</script>
@endsection
