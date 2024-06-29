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
                <h4 class="mb-sm-0 font-size-18">Log System</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Aktivitas yang dilakukan akan terekam disini.</li>
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
                        <h5 class="mb-0 card-title flex-grow-1">Data Log</h5>
                    </div>
                </div>
                <div class="card-body border-bottom">
                    <div class="row g-3">
                        <div class="col-xxl-4 col-lg-4">
                            <input type="search" name="keyword" class="form-control" id="keyword" placeholder="Masukan keyword ...">
                        </div>
                        <div class="col-xxl-2 col-lg-2">
                            <select name="created_by" id="created_by" class="form-control select2">
                                <option value="all" selected>-- Semua Kasir --</option>
                                @foreach($kasir as $data)
                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xxl-4 col-lg-3">
                            <div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy"
                                data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                <input type="text" class="form-control" name="start" id="start" value="{{ date('d M, Y') }}"
                                    placeholder="Start" />
                                <input type="text" class="form-control" name="end" id="end" value="{{ date('d M, Y') }}"
                                    placeholder="End" />
                            </div>
                        </div>
                        <div class="col-xxl-2 col-lg-3">
                            <button type="button" onclick="table.draw()" class="btn btn-soft-secondary w-100"><i
                                    class="mdi mdi-filter-outline align-middle"></i> Filter</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="table" class="table table-bordered align-middle nowrap">
                            <thead>
                                <tr>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Kasir</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Param</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->

    </div>
    <!--end row-->
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
<script>
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
                  url: '{{ route('log.create') }}',
                  type: "GET",
                  data: function(data) {
                    data.start = $('#start').val();
                    data.end       = $('#end').val();
                    data.created_by = $('#created_by').val();
                    data.keyword   = $('#keyword').val();
                  }
            },
            columns: [
                {data: 'tanggal', name: 'tanggal'},
                {data: 'user.name', name: 'user.name'},
                {data: 'text', name: 'text'},
                {data: 'body', name: 'body'},
            ],
        });

    });

</script>

@endsection