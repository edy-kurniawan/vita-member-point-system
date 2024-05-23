@extends('layouts.template')
@section('css')
<!-- Sweet Alert-->
<link href="{{ url('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ url('assets/libs/toastr/build/toastr.min.css') }}">
@endsection
@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Reward</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Reward yang dapat ditukarkan oleh member</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6 col-12">
                            <h4 class="card-title">Data Reward</h4>
                            <p class="card-title-desc">Anda dapat mengelola data reward yang dapat ditukarkan oleh member pada halaman ini.</p>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="text-md-end mt-3 mt-md-0">
                                <button onclick="rewardModal()" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus-circle me-1"></i> Tambah Reward</button>
                            </div>
                        </div>
                    </div>

                    <table id="table" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Point</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1005">
        <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="{{ url('assets/images/logo.svg') }}" alt="" class="me-2" height="18">
                <strong class="me-auto">Success</strong>
                <small>1 mins ago</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Data berhasil disimpan !
            </div>
        </div>
    </div>
    @include('master.reward.modal')
</div>
@endsection
@section('js')
<!-- Sweet Alerts js -->
<script src="{{ url('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- toastr plugin -->
<script src="{{ url('assets/libs/toastr/build/toastr.min.js') }}"></script>
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
            ajax: {
                  url: '{{ route('reward.index') }}',
                  type: "GET",
            },
            columns: [
                {data: 'foto', name: 'foto'},
                {data: 'kode', name: 'kode'},
                {data: 'nama', name: 'nama'},
                {data: 'point', name: 'point', render: $.fn.dataTable.render.number( '.', ',',0, '' ), className: 'text-right'},
                {data: 'keterangan', name: 'keterangan'},
                {data: 'action', name: 'action'},
            ],
        });

    });

    function rewardModal() {
        // reset form
        $('#formReward').trigger('reset');
        // set title
        $('#myModalLabel').html('Tambah Reward');
        // open modal
        $('#rewardModal').modal('show');
    }

    function editButton(id) {
        // reset form
        $('#formReward').trigger('reset');
        $.ajax({
            url: '/reward/' + id,
            type: 'GET',
            success: function(response) {
                // set title
                $('#myModalLabel').html('Edit Reward');
                // set data
                $('#id').val(response.id);
                $('#kode').val(response.kode);
                $('#nama').val(response.nama);
                $('#point').val(response.point);
                $('#keterangan').val(response.keterangan);
                // open modal
                $('#rewardModal').modal('show');
            }
        });
    }

    function saveButton() {
        var formData = new FormData($('#formReward')[0]);
        $.ajax({
            url: '{{ route('reward.store') }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if(response.status) {
                    $('#rewardModal').modal('hide');
                    $('#formReward').trigger('reset');
                    $('#successToast').toast('show');
                    table.draw();
                }else{
                    // loop all errors
                    $.each(response.errors, function(key, value){
                        alert(value);
                        return false;
                    });
                }
            }
        });
    }

    function deleteButton(id){
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
            },
        })
        swalWithBootstrapButtons.fire({
            title: 'Konfirmasi !',
            text: "Anda Akan Menghapus Data ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus !',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '/reward/' + id,
                    type: 'DELETE',
                    success: function(response) {
                        if(response.status) {
                            deleteToastr();
                            table.draw();
                        }
                    }
                });
            } 
        })
    }

    function deleteToastr(){
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": 300,
            "hideDuration": 1000,
            "timeOut": 5000,
            "extendedTimeOut": 1000,
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        toastr.success('Data berhasil dihapus !', 'Success');
    }
</script>

@endsection