<!-- sample modal content -->
<div id="rewardModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Default Modal Heading</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formReward">
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Kode</label>
                        <input type="number" name="kode" class="form-control" id="kode"
                            placeholder="Masukkan Kode">
                    </div>
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" id="nama"
                            placeholder="Masukkan Nama">
                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Foto</label>
                                <input type="file" name="foto" class="form-control" id="foto"
                                    placeholder="Masukan file foto">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="formrow-password-input" class="form-label">Point</label>
                                <input type="number" name="point" class="form-control" id="point"
                                    placeholder="Masukkan Point">
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Point yang dibutuhkan untuk menukarkan reward.
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="formrow-inputCity" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Opsional"></textarea>
                        </div>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="saveButton()" class="btn btn-primary waves-effect waves-light">Submit</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->