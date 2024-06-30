@extends('layouts.template')
@section('css')
<link href="{{ url('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-4">
            <div class="card overflow-hidden">
                <div class="bg-primary-subtle bg-soft-primary">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">Member Vita Fashion Store !</h5>
                                <p>Exlusive Member</p>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="{{ url('assets/images/profile-img.png') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="avatar-md profile-user-wid mb-4">
                                <img src="https://ui-avatars.com/api/?name={{ $member->nama }}&color=556EE6" alt=""
                                    class="img-thumbnail rounded-circle">
                            </div>
                            <h5 class="font-size-15 text-truncate">{{ $member->nama }}</h5>
                            <p class="text-muted mb-0 text-truncate">{{ $member->keterangan }}</p>
                        </div>

                        <div class="col-sm-8">
                            <div class="pt-4">

                                <div class="row">
                                    <div class="col-6">
                                        Tanggal Registrasi
                                        <p class="text-muted mb-4">{{ date('d F Y',
                                            strtotime($member->tanggal_registrasi)) }}</p>
                                    </div>
                                    <div class="col-6">
                                        Tanggal Expired
                                        <p class="text-truncate mb-4">{{ date('d F Y',
                                            strtotime($member->tanggal_expired)) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Personal Information</h4>

                    <p class="text-muted mb-4">Informasi pribadi member yang terdaftar dalam sistem.</p>
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">Kode</th>
                                    <td>: {{ $member->kode }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Nama</th>
                                    <td>: {{ $member->nama }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Jenis Kelamin</th>
                                    <td>:
                                        @if($member->jenis_kelamin == 'L')
                                        <span class="badge badge-pill badge-soft-danger font-size-11">Laki-laki</span>
                                        @else
                                        <span class="badge badge-pill badge-soft-primary font-size-11">Perempuan</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">No Whatsapp</th>
                                    <td><a href="tel:{{ $member->no_hp }}">: {{ $member->no_hp }}</a></td>
                                </tr>
                                <tr>
                                    <th scope="row">Tanggal Lahir</th>
                                    <td>:
                                        @if($member->tanggal_lahir)
                                        {{ date('d F Y', strtotime($member->tanggal_lahir)) }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Alamat</th>
                                    <td>: {{ $member->alamat . ', ' . $member->kelurahan->name . ', ' .
                                        $member->kecamatan->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row"></th>
                                    <td>: {{ $member->kabupaten->name . ', ' . $member->provinsi->name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-primary mt-2" onclick="memberModal()"><i
                                class="mdi mdi-pencil me-1"></i> Edit</button>
                        <button type="button" onclick="deleteButton({{ $member->id }})" class="btn btn-danger mt-2"><i
                                class="mdi mdi-delete me-1"></i> Delete</button>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>

        <div class="col-xl-8">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium mb-2">Total Point</p>
                                    <h4 class="mb-0">{{ number_format($member->total_point) }} Point</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-trophy font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium mb-2">Pengumpulan Point</p>
                                    <h4 class="mb-0">{{ number_format($pengumpulan_point) }} Trx</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-cart font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium mb-2">Penukaran Point</p>
                                    <h4 class="mb-0">{{ number_format($penukaran_point) }} Trx</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-transfer font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">History Transaksi</h4>
                    <div class="table-responsive">
                        <table id="table" class="table table-nowrap table-hover mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Kode</th>
                                    <th scope="col">Total Pembelian</th>
                                    <th scope="col">Total Point</th>
                                    <th scope="col">Kasir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksi as $data)
                                <tr>
                                    <th scope="row">{{ date('d/m/Y', strtotime($data->tanggal_transaksi)) }}</th>
                                    <td>{{ $data->kode }}</td>
                                    <td>
                                        @if($data->jenis == 'penukaran-emas')
                                        {{ number_format($data->total_pembelian) }} Penukaran Emas
                                        @else
                                        {{ number_format($data->total_pembelian) }}
                                        @endif
                                    </td>
                                    <td>{{ number_format($data->total_point) }}</td>
                                    <td>{{ $data->kasir->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    <!-- Modal -->
    <div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrasi Member Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form">

                        <div id="kyc-verify-wizard">
                            <!-- Personal Info -->
                            <h3>Informasi Pribadi</h3>
                            <section>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="kycfirstname-input" class="form-label">Kode</label>
                                            <input type="hidden" name="id" value="{{ $member->id }}">
                                            <input type="number" name="kode" class="form-control"
                                                id="kycfirstname-input" value="{{ $member->kode }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="kyclastname-input" class="form-label">Nama</label>
                                            <input type="text" name="nama" class="form-control" id="kyclastname-input"
                                                value="{{ $member->nama }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="kycphoneno-input" class="form-label">No WA</label>
                                            <input type="text" name="no_hp" class="form-control"
                                                value="{{ $member->no_hp }}" id="kycphoneno-input"
                                                placeholder="Masukan nomor whatsapp">
                                            <small class="text-muted">Gunakan format 62, Contoh: 6281234567890</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="kycbirthdate-input" class="form-label">Tanggal Lahir</label>
                                            <input type="date" name="tanggal_lahir" class="form-control"
                                                value="{{ $member->tanggal_lahir }}" id="kycbirthdate-input"
                                                placeholder="Opsional">
                                            <small class="text-muted">Opsional</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="kycselectcity-input" class="form-label">Jenis Kelamin</label>
                                            <select name="jenis_kelamin" class="form-select" id="kycselectcity-input"
                                                required>
                                                <option selected disabled>-- Pilih Jenis Kelamin --</option>
                                                @if($member->jenis_kelamin == 'L')
                                                <option value="L" selected>Laki-laki</option>
                                                <option value="P">Perempuan</option>
                                                @else
                                                <option value="L">Laki-laki</option>
                                                <option value="P" selected>Perempuan</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Confirm email -->
                            <h3>Alamat</h3>
                            <section>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Provinsi</label>
                                            <select id="provinsi" name="provinsi_id" class="form-control" required>
                                                <option selected>-- Pilih Provinsi --</option>
                                                @foreach ($provinsi as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Kota/Kabupaten</label>
                                            <select id="kabupaten" name="kabupaten_id" class="form-control"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Kecamatan</label>
                                            <select id="kecamatan" name="kecamatan_id" class="form-control"></select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Kelurahan</label>
                                            <select id="kelurahan" name="kelurahan_id" class="form-control"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="basicpill-companyuin-input">Alamat</label>
                                            <textarea name="alamat" class="form-control" id="basicpill-companyuin-input"
                                                placeholder="Alamat lengkap">{{ $member->alamat }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Document Verification -->
                            <h3>Registrasi</h3>
                            <section>
                                <div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="kycfirstname-input" class="form-label">Tanggal
                                                    Registrasi</label>
                                                <input type="date" name="tanggal_registrasi" class="form-control"
                                                    value="{{ date('Y-m-d') }}" id="kycfirstname-input" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="kyclastname-input" class="form-label">Registrasi
                                                    Oleh</label>
                                                <input type="text" name="register_by" class="form-control" value="admin"
                                                    id="kyclastname-input" placeholder="Registrasi oleh" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="kyclastname-input" class="form-label">Catatan</label>
                                                <textarea name="keterangan" class="form-control" id="kycfirstname-input"
                                                    placeholder="Catatan registrasi member">{{ $member->keterangan }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<!-- Sweet Alerts js -->
<script src="{{ url('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
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
        
        table = $('#table').DataTable();

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
                    if(data.status) {
                        // reload page
                        location.reload();
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

    function deleteButton(id) {
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
            reverseButtons: true,
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '/member/' + id,
                    type: 'DELETE',
                    success: function(response) {
                        if(response.status) {
                            // redirect to member index
                            window.location.href = "{{ route('member.index') }}";
                        }else{
                            Swal.fire('Error !', response.message, 'error');
                        }
                    }
                });
            } 
        })
    }

</script>

@endsection