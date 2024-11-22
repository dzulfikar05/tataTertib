<div class="modal fade modal-md" tabindex="-1" id="modal_form">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form  
                    Tugas Sanksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mx-3">
                <form id="form_upload-sanksi">  

                    <div class="row">
                        <div class="col-12 mb-3">
                            <input type="hidden" id="id" name="id">
                            <input type="hidden" id="status" name="status">
                            <input type="hidden" id="verifikator_id" name="verifikator_id">
                        </div>
                        <div class="row mb-1">
                            <label class="mb-1">Tenggat Waktu</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control" id="deadline_date" disabled>
                            </div>
                            <div class="col-md-4">
                                <input type="time" class="form-control" id="deadline_time" disabled>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <span id="terlambat" class="text-danger"></span>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="mb-1">Tugas</label>
                            <input type="text" class="form-control " id="tugas" disabled/>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="mb-1">Keterangan</label>
                            <textarea class="form-control " rows="5" id="keterangan" disabled></textarea>
                        </div>
                        <div class="col-12 mb-3 komentar_revisi">
                            <label class="mb-1">Komentar Revisi</label>
                            <textarea class="form-control " rows="5" id="komentar_revisi" disabled></textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="mb-1 required-label input-file-x">Upload Tugas </label>
                            <input type="file" class="form-control input-file-x" id="file" name="file">
                            <div class="text-muted " id="uploaded_text">
                                uploaded file :  <a href="" id="file_path" target="_blank"></a>
                            </div>
                           
                        </div>
                        <div class="col-12 mb-3">
                            <label class="mb-1">Komentar</label>
                            <textarea class="form-control " rows="5" id="komentar" name="komentar"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer footer-form">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="onReset()">Reset</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="onSave()">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>