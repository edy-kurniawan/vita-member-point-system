@extends('layouts.template')
@section('css')
@endsection
@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Member</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Pelanggan yang terdaftar sebagai member</li>
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
                            <h4 class="card-title">Data Member</h4>
                            <p class="card-title-desc">Anda dapat mengelola data member yang terdaftar dalam sistem pada halaman ini.</p>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="text-md-end mt-3 mt-md-0">
                                <a href="{{ route('member.create') }}" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-file-export me-1"></i> Export</a>
                                <button onclick="memberModal()" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus-circle me-1"></i> Tambah Member</button>
                            </div>
                        </div>
                    </div>

                    <table id="table" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Total Point</th>
                                <th>Tgl Berlaku</th>
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
@include('master.member.modal')

<div class="position-fixed top-0 end-0 p-3" style="z-index: 1005">
    <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <img src="assets/images/logo.svg" alt="" class="me-2" height="18">
            <strong class="me-auto">Success</strong>
            <small>1 mins ago</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Data berhasil disimpan !
        </div>
    </div>
</div>
</div>
@endsection
@section('js')
<!-- jquery step -->
<script src="{{ url('assets/libs/jquery-steps/build/jquery.steps.min.js') }}"></script>
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
                  url: '{{ route('member.index') }}',
                  type: "GET",
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'kode', name: 'kode'},
                {data: 'nama', name: 'nama'},
                {data: 'jenis_kelamin', name: 'jenis_kelamin'},
                {data: 'total_point', name: 'total_point', render: $.fn.dataTable.render.number( '.', ',',0, '' ), className: 'text-right'},
                {data: 'tanggal_berlaku', name: 'tanggal_berlaku'},
                {data: 'action', name: 'action'},
            ],
        });

        $("#kyc-verify-wizard").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slide"
        })

        // event on wizard finished
        $('#kyc-verify-wizard').on('finished', function(e) {
            e.preventDefault();

            $.ajax({
                url : "{{ route('member.store') }}",
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data){
                    console.log(data);
                    if(data.status) {
                        $('#memberModal').modal('hide');
                        table.draw();
                        new bootstrap.Toast('#successToast', {
                            delay: 2000
                        }).show();
                    }else{
                        // loop all errors
                        $.each(data.errors, function(key, value){
                            alert(value);
                            return false;
                        });
                    }
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    alert(errors.message);
                }
            });

            return false;
        });

        $('#provinsi').change(function() {
            var id = $(this).val();

            $.ajax({
                url: "/api/kabupaten?province_id=" + id,
                method: "GET",
                async: true,
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    var i;
                    html += '<option value="all">-- Pilih Kabupaten --</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i].id + '>' + data[i].name + '</option>';
                    }
                    // select2
                    $('#kabupaten').html(html);
                }
            });


            return false;
        });

        $('#kabupaten').change(function() {
            var id = $(this).val();

            $.ajax({
                url: "/api/kecamatan?regency_id=" + id,
                method: "GET",
                async: true,
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    var i;
                    html += '<option value="all">-- Pilih Kecamatan --</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i].id + '>' + data[i].name + '</option>';
                    }
                    $('#kecamatan').html(html);
                }
            });

            return false;
        });

        $('#kecamatan').change(function() {
            var id = $(this).val();

            $.ajax({
                url: "/api/kelurahan?district_id=" + id,
                method: "GET",
                async: true,
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    var i;
                    html += '<option value="all">-- Pilih Kelurahan --</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i].id + '>' + data[i].name + '</option>';
                    }
                    $('#kelurahan').html(html);
                }
            });

            return false;
        });

    });

    function memberModal() {
        $('#memberModal').modal('show');
    }
</script>

@endsection