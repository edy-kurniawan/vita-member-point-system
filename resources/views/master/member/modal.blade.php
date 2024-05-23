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
                                        <input type="number" name="kode" class="form-control" id="kycfirstname-input"
                                            placeholder="Kode member">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="kyclastname-input" class="form-label">Nama</label>
                                        <input type="text" name="nama" class="form-control" id="kyclastname-input"
                                            placeholder="Masukan nama member">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="kycphoneno-input" class="form-label">No WA</label>
                                        <input type="text" name="no_hp" class="form-control" id="kycphoneno-input"
                                            placeholder="Masukan nomor whatsapp">
                                        <small class="text-muted">Gunakan format 62, Contoh: 6281234567890</small>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="kycbirthdate-input" class="form-label">Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" class="form-control"
                                            id="kycbirthdate-input" placeholder="Opsional">
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
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
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
                                        placeholder="Contoh : Jl. Nuri No. 129"></textarea>
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
                                        <label for="kycfirstname-input" class="form-label">Tanggal Registrasi</label>
                                        <input type="date" name="tanggal_registrasi" class="form-control"
                                            value="{{ date('Y-m-d') }}" id="kycfirstname-input"
                                            placeholder="Tanggal registrasi member">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="kyclastname-input" class="form-label">Registrasi Oleh</label>
                                        <input type="text" name="register_by" class="form-control" value="admin"
                                            id="kyclastname-input" placeholder="Registrasi oleh" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="kyclastname-input" class="form-label">Catatan</label>
                                        <textarea name="keterangan" class="form-control" id="kycfirstname-input"
                                            placeholder="Opsional"></textarea>
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