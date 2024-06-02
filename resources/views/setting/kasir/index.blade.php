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
                <h4 class="mb-sm-0 font-size-18">DATA Kasir</h4>

                <div class="page-title-right">
                    <button type="button" class="btn btn-primary waves-effect waves-light" onclick="tambahKasir(0)"><i
                            class="bx bx-plus-circle me-1"></i> Tambah Kasir</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-12">
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
        @foreach($user as $k)
        <div class="col-xl-3 col-sm-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="avatar-sm mx-auto mb-4">
                        <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-16">
                            {{ substr($k->name, 0, 1) }}
                        </span>
                    </div>
                    <h5 class="font-size-15 mb-1"><a href="javascript: void(0);" class="text-dark">{{ $k->name }}</a>
                    </h5>
                    <p class="text-muted">{{ strtoupper($k->username)}}</p>

                    <div>
                        @if($k->role == 'admin')
                        <a href="javascript: void(0);" class="badge bg-primary font-size-11 m-1">ADMIN</a>
                        @else
                        <a href="javascript: void(0);" class="badge bg-success font-size-11 m-1">KASIR</a>
                        @endif
                        @if($k->is_active == '1')
                        <a href="javascript: void(0);" class="badge bg-warning font-size-11 m-1">AKTIF</a>
                        @else
                        <a href="javascript: void(0);" class="badge bg-secondary font-size-11 m-1">NON-AKTIF</a>
                        @endif
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item me-3">
                            <i class="bx bx-calendar me-1"></i> Created At : {{ date('d/m/Y H:i',
                            strtotime($k->created_at)) }}
                        </li>
                        <li class="list-inline-item me-3">
                            <i class="fas fa-clock me-1"></i> Last Active : {{ date('d/m/Y H:i',
                            strtotime($k->last_active)) }}
                        </li>
                    </ul>
                    <div class="text-center">
                        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="editKasir({{ $k->id }})"><i
                                class="bx bx-edit-alt me-1"></i>Edit</button>
                        <button type="button" class="btn btn-sm btn-danger mt-2" onclick="deleteKasir({{ $k->id }})"><i
                                class="bx bx-trash me-1"></i>Delete</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- end row -->
    <!-- sample modal content -->
    <div id="kasirModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Default Modal Heading</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formKasir" method="post" action="{{ route('kasir.store') }}">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label for="formrow-firstname-input" class="form-label">Nama Karyawan / Kasir </label>
                            <input type="text" name="username" class="form-control" id="username"
                                placeholder="Masukkan Nama Karyawan / Kasir">
                        </div>
                        <div class="mb-3">
                            <label for="formrow-firstname-input" class="form-label">Username</label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Username untuk login">
                        </div>

                        <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="formrow-email-input" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="password"
                                        placeholder="Masukkan Password">
                                    <small id="hiddenText" class="text-muted">Kosongkan jika tidak ingin mengganti
                                        password</small>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="formrow-password-input" class="form-label">Ulangi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        id="password_confirmation" placeholder="Ulangi Password">
                                    <small id="hiddenText2" class="text-muted">Kosongkan jika tidak ingin mengganti
                                            password</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="formrow-inputCity" class="form-label">Status</label>
                                <select name="is_active" id="is_active" class="form-select">
                                    <option value="1">Aktif</option>
                                    <option value="0">Non-Aktif</option>
                                </select>
                            </div>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                </div>
                </form>

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
<script>
    var table;

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    });

    function editKasir(id) {
        // reset form
        $('#formKasir').trigger('reset');
        // show hidden text
        $('#hiddenText').show();
        $('#hiddenText2').show();
        $.ajax({
            url: "/kasir/" + id + "/edit",
            type: "GET",
            success: function(res) {
                $('#kasirModal').modal('show');
                $('#myModalLabel').html('Edit Data Kasir');
                $('#id').val(res.id);
                $('#username').val(res.username);
                $('#name').val(res.name);
                $('#is_active').val(res.is_active);
            }
        });
    }

    function tambahKasir() {
        // hide hidden text
        $('#hiddenText').hide();
        $('#hiddenText2').hide();
        $('#formKasir').trigger('reset');
        $('#kasirModal').modal('show');
        $('#myModalLabel').html('Tambah Data Kasir');
    }

    function deleteKasir(id){
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
                    url: '/kasir/' + id,
                    type: 'DELETE',
                    success: function(response) {
                        if(response.status) {
                            location.reload();
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message
                            });
                        }
                    }
                });
            } 
        })
    }


</script>
@endsection