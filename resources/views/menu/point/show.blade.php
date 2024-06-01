@extends('layouts.template')
@section('css')
<!-- Sweet Alert-->
<link href="{{ url('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Transaksi Pengumpulan Point</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Halaman yang digunakan untuk mengumpulkan
                            point member</a></li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="container-fluid">
    <div class="account-pages my-2 pt-sm-2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">
                        <div class="card-body">
                            <form id="form" method="POST">
                                <h4 class="card-title mb-3 text-center">Ringkasan Pengumpulan Point</h4>
                                <hr style="border-top: 1px solid #3b3b3b;">

                                <div class="row">
                                    <div class="col-12 col-md-7">
                                        <div class="mb-2">
                                            <label for="formrow-firstname-input" class="form-label">Kode Transaksi
                                                :</label>
                                            <input type="text" class="form-control" value="{{ $kode }}" disabled>
                                            <input type="hidden" name="type" value="pengumpulan_point">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <div class="mb-2">
                                            <label for="formrow-firstname-input" class="form-label">Tanggal :</label>
                                            <input type="date" name="tanggal_transaksi" class="form-control"
                                                value="{{ date('Y-m-d') }}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-2 ajax-select mt-2 mt-lg-0">
                                    <label class="form-label">Member :</label>
                                    <select id="cari-member" name="member_id"
                                        class="form-control select2-ajax"></select>

                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-7">
                                        <div class="mb-2">
                                            <label for="formrow-firstname-input" class="form-label">Kode Member
                                                :</label>
                                            <input type="text" class="form-control" id="kode_member" value="" disabled>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-5">
                                        <div class="mb-2">
                                            <label for="formrow-firstname-input" class="form-label">Expired :</label>
                                            <input type="text" class="form-control" id="expired_member" value=""
                                                disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label for="formrow-firstname-input" class="form-label">Total Pembelian :</label>
                                    <input type="number" class="form-control" name="total_pembelian"
                                        id="total_pembelian" placeholder="Masukan total pembelian"
                                        onkeyup="calculatePoint()" onchange="calculatePoint()">
                                </div>

                                <hr style="border-top: 1px solid #3b3b3b;">

                                <table class="table table-sm mb-0 table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>Point member sekarang :</td>
                                            <td class="text-end"><span id="point-member">0</span></td>
                                        </tr>
                                        <tr>
                                            <td>Point yang akan di dapat :</td>
                                            <td class="text-end"><span id="point-reward">0</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Point Member : </strong></td>
                                            <td class="text-end"><strong><span id="total-point-member">0</span></strong>
                                            </td>
                                        </tr>
                                        <tr>
                                    </tbody>
                                </table>


                                <div class="text-center">
                                    <button type="button" onclick="saveButton()" class="btn btn-primary mt-3">Simpan
                                        Transaksi Pengumpulan Point <i class="fas fa-save ms-2"></i></button>
                                </div>
                            </form>
                            <!-- end table-responsive -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
</div>
@endsection
@section('js')
<!-- Sweet Alerts js -->
<script src="{{ url('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ url('assets/libs/select2/js/select2.min.js') }}"></script>
<script src="{{ url('assets/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
<!-- Bootrstrap touchspin -->
<script src="{{ url('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ url('assets/js/pages/ecommerce-cart.init.js') }}"></script>
<!-- Bootstrap Toasts Js -->
<script src="{{ url('assets/js/pages/bootstrap-toastr.init.js') }}"></script>
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
    let total_point_member = 0;
    let total_point_reward = 0;
    let member_id = 0;

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
        $('#expired_member').val(date);
        // kode member
        $('#kode_member').val(e.params.data.kode);
        // member_id
        member_id = e.params.data.id;
        calculatePoint();
    });

    function calculatePoint(){
        let point = {{ $point }};
        var total_pembelian = $('#total_pembelian').val();
        if(total_pembelian == '') {
            total_pembelian = 0;
        }
        total_point_reward = total_pembelian * point;
        // change format number
        $('#point-reward').text(total_point_reward.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
        total = total_point_member + total_point_reward;
        $('#total-point-member').text(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
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
                text: 'Masukan total pembelian terlebih dahulu !',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return false;
        }
        // form
        form = $('#form').serialize();
        $.ajax({
            url: '{{ route('point.store') }}',
            data: form,
            type: 'POST',
            success: function(response) {
                if(response.status) {
                    // show alert toast
                    var toastLiveExample = document.getElementById('liveToast')
                    var toast = new bootstrap.Toast(toastLiveExample)
                    toast.show();
                    // reset form
                    $('#form').trigger('reset');
                    // reset point
                    $('#point-member').text('0');
                    $('#point-reward').text('0');
                    $('#total-point-member').text('0');
                    // reset select2
                    $('#cari-member').val(null).trigger('change');
                }else{
                    // json pretify
                    var json = JSON.beautify(response);
                    Swal.fire({
                        title: 'Peringatan',
                        text: json,
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    }

</script>
@endsection