@extends('layouts.template_horizontal')
@section('css')
<!-- Sweet Alert-->
<link href="{{ url('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
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
                <table id="table-cart" class="table align-middle mb-0 table-nowrap" style="width: 100%;">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 15%;">Foto</th>
                            <th style="width: 35%;">Nama</th>
                            <th style="width: 10%;">Point</th>
                            <th style="width: 10%;">Qty</th>
                            <th style="width: 20%;">Total</th>
                            <th style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
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
                            <input type="text" class="form-control" value="{{ $kode }}" disabled>
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
                                <td>Kode Member :</td>
                                <td class="text-end"><span id="kode-member">xxx</span>
                            </tr>
                            <tr>
                                <td>Expired Member :</td>
                                <td class="text-end"><span id="expired-member">d/m/Y</span>
                            </tr>
                            <tr>
                                <td>Total Point Member :</td>
                                <td class="text-end"><span id="point-member">0</span>
                            </tr>
                            <tr>
                                <td>Total Point Reward :</td>
                                <td class="text-end"><span id="total-point">0</span>
                            </tr>
                            <tr>
                                <th>Sisa Point Member:</th>
                                <th class="text-end"><span id="sisa-point">0</span>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    <button type="button" onclick="saveButton()" class="btn btn-primary mt-3">Simpan Transaksi Penukaran
                        Point <i class="fas fa-save ms-2"></i></button>
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
                        <small class="text-muted">*)Hanya menampilkan reward yang pointnya cukup untuk ditukarkan oleh
                            member</small>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
    <!-- end card -->
</div>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1005">
    <div id="liveToast" class="toast align-items-center text-white bg-primary border-0" role="alert"
        aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-check me-2"></i>
                Transaksi berhasil disimpan !
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1005">
    <div id="cartLiveToast" class="toast align-items-center text-white bg-success border-0" role="alert"
        aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-check me-2"></i>
                Reward berhasil ditambahkan ke cart !
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>
</div>
<!-- end row -->
@endsection
@section('js')
<!-- Sweet Alerts js -->
<script src="{{ url('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
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
    let total_point_member = 0;
    let total_point_reward = 0;
    let member_id = 0;

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
                  data: function(data) {
                    data.table   = 'reward';
                    data.total_point_member = total_point_member;
                  }
            },
            columns: [
                {data: 'foto', name: 'foto'},
                {data: 'kode', name: 'kode'},
                {data: 'reward', name: 'reward'},
                {data: 'point', name: 'point', render: $.fn.dataTable.render.number( '.', ',',0, '' ), className: 'text-right'},
                {data: 'action', name: 'action'},
            ]
        });

        table_cart = $('#table-cart').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                  url: '{{ route('point.create') }}',
                  type: "GET",
                  data: function(data) {
                    data.table   = 'cart';
                    data.member_id = member_id;
                  }
            },
            columns: [
                {data: 'foto', name: 'foto'},
                {data: 'nama', name: 'nama'},
                {data: 'reward.point', name: 'reward.point', render: $.fn.dataTable.render.number( '.', ',',0, '' ), className: 'text-right'},
                {data: 'input_qty', name: 'input_qty'},
                {data: 'total_point', name: 'total_point', render: $.fn.dataTable.render.number( '.', ',',0, '' ), className: 'text-right'},
                {data: 'action', name: 'action'},
            ],
            drawCallback: function(settings) {
                var api = this.api();
                var total = api.column(4).data().reduce(function(a, b) {
                    return parseInt(a) + parseInt(b);
                }, 0);
                $('#total-point').text(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                total_point_reward = total;
                // sisapoint
                var sisa = total_point_member - total_point_reward;
                $('#sisa-point').text(sisa.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            }
        });

    });

    $('#cari-member').on('select2:select', function (e) {
        // change format number
        var point = e.params.data.total_point.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        $('#point-member').text(point);
        total_point_member = e.params.data.total_point;
        // change format date
        var date = e.params.data.tanggal_expired.split('-').reverse().join('/');
        $('#expired-member').text(date);
        // kode member
        $('#kode-member').text(e.params.data.kode);
        // member_id
        member_id = e.params.data.id;
        console.log(member_id);
        // table reload
        table_cart.draw();
    });

    function rewardModal() {
        // check member is selected
        if($('#cari-member').val() == null) {
            // sweetalert2
            Swal.fire({
                title: 'Peringatan',
                text: 'Pilih member terlebih dahulu !',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return false;
        }
        // table reload
        table.draw();
        // open modal
        $('#rewardModal').modal('show');
    }

    function cartButton(id){
        $.ajax({
            url: '{{ route('point.update', 10) }}',
            data: {
                reward_id:id,
                member_id:member_id,
                total_point_member:total_point_member
            },
            type: 'PUT',
            success: function(response) {
                if(response.status) {
                    table_cart.draw();
                    // show alert toast
                    var toastLiveExample = document.getElementById('cartLiveToast');
                    var toast = new bootstrap.Toast(toastLiveExample);
                    toast.show();
                }else{
                    Swal.fire({
                        title: 'Peringatan',
                        text: response.message,
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    table_cart.draw();
                }
            }
        });
    }

    function updateQty(id){
        var qty = $('#qty_'+id).val();
        $.ajax({
            url: '{{ route('point.update', 10) }}',
            data: {
                reward_id:id,
                member_id:member_id,
                qty:qty,
                total_point_member:total_point_member
            },
            type: 'PUT',
            success: function(response) {
                if(response.status) {
                    table_cart.draw();
                }else{
                    Swal.fire({
                        title: 'Peringatan',
                        text: response.message,
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    table_cart.draw();
                }
            }
        });
    }

    function deleteCart(id){
        $.ajax({
            url: '{{ route('point.destroy', 10) }}',
            data: {
                cart_id:id
            },
            type: 'DELETE',
            success: function(response) {
                if(response.status) {
                    table_cart.draw();
                }
            }
        });
    }

    function saveButton(){
        if(member_id == 0) {
            Swal.fire({
                title: 'Peringatan',
                text: 'Pilih member terlebih dahulu !',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return false;
        }
        if(total_point_reward == 0) {
            Swal.fire({
                title: 'Peringatan',
                text: 'Pilih reward terlebih dahulu !',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return false;
        }

        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Transaksi penukaran point akan disimpan !",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, simpan !",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('point.store') }}',
                    data: {
                        member_id:member_id,
                        type:'penukaran_point'
                    },
                    type: 'POST',
                    success: function(response) {
                        console.log(response);
                        if(response.status) {
                            // show alert toast
                            var toastLiveExample = document.getElementById('liveToast');
                            var toast = new bootstrap.Toast(toastLiveExample);
                            toast.show();
                            // reset
                            $('#cari-member').val(null).trigger('change');
                            $('#point-member').text('0');
                            $('#expired-member').text('d/m/Y');
                            $('#kode-member').text('xxx');
                            $('#total-point').text('0');
                            $('#sisa-point').text('0');
                            total_point_member = 0;
                            total_point_reward = 0;
                            member_id = 0;
                            table_cart.draw();
                        }else{
                            Swal.fire({
                                title: 'Peringatan',
                                text: response.message,
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            }
        });
        
    }

</script>
@endsection