

<div class="modal fade modal-md" tabindex="1" id="modal_verifikasi">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form  
                    Tugas Sanksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mx-3">
                <form id="form_approval-sanksi">  

                    <div class="row">
                        <input type="hidden" id="id_sanksi" name="id_sanksi">
                        <input type="hidden" id="id_pelanggaran" name="id_pelanggaran">
                        <input type="hidden" id="id_mhs" name="id_mhs">
                        
                        <div class="row mb-1">
                            <span class="mb-1">Tenggat Waktu</span>
                            <div class="col-md-6">
                                <input type="date" class="form-control" id="v_deadline_date" disabled>
                            </div>
                            <div class="col-md-4">
                                <input type="time" class="form-control" id="v_deadline_time" disabled>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <span id="v_terlambat" class="text-danger"></span>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="mb-1">Tugas</label>
                            <input type="text" class="form-control " id="v_tugas" disabled/>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="mb-1">Keterangan</label>
                            <textarea class="form-control " rows="5" id="v_keterangan" disabled></textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="mb-1">Komentar </label>
                            <textarea class="form-control " rows="5" id="v_komentar" disabled></textarea>
                        </div>
                        <div class="col-12 mb-3">
                            
                            <div class="text-muted fs-5">
                                Unggah berkas :  <a href="" id="v_file_path" target="_blank"></a>
                            </div>
                           
                        </div>
                        <div class="col-12 mb-3">
                            <label class="mb-1">Komentar Revisi</label>
                            <textarea class="form-control " rows="5" id="v_komentar_revisi" name="komentar_revisi" placeholder="jika tidak ada revisi tidak perlu di isi"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer footer-form">
                        <button type="button" class="btn btn-warning btn-sm" onclick="onVerification(3)">Revisi</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="onVerification(4)">Verifikasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-md" tabindex="-1" id="modal_form">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form
                    Sanksi Pelanggaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-3">
                <form id="form_list-pelanggaran">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" id="id" name="id">
                            <input type="hidden" id="pelanggaran_id" name="pelanggaran_id">
                            <input type="hidden" id="mhs_id" name="mhs_id">
                        </div>
                        <div class="col-12 mb-3">
                            <label class=" mb-1">Pelanggaran</label>
                            <textarea type="text" class="form-control " rows="5" id="pelanggaran_keterangan" disabled></textarea>
                        </div>
                        <div class="row">
                            <div class="col-9 mb-3">
                                <label class=" mb-1">Kategori</label>
                                <div class="form-group mb-2">
                                    <input type="text" id="pelanggaran_kategori_nama" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-3 mb-3">
                                <label class=" mb-1">Tingkat</label>
                                <div class="form-group mb-2">
                                    <input type="number" id="kategori_bobot" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                                <label class="required-label mb-1">Sanksi Tugas</label>
                                <div class="form-group mb-2">
                                    <input type="text" id="tugas" name="tugas" class="form-control" >
                                </div>
                            </div>
                        <div class="col-12">
                            <label class="required-label mb-1">Keterangan</label>
                            <div class="form-group mb-2">
                                <textarea type="text" class="form-control textarea-keterangan" rows="5" id="keterangan" name="keterangan" placeholder="sanksi yang harus di lakukan ole pelaku" required></textarea>
                            </div>
                        </div>
                        <div class="col-12 row mb-3">
                            <label class="required-label mb-1">Tenggat Waktu</label>
                            <div class="col-6">
                                <input type="date" class="form-control" id="deadline_date" name="deadline_date" required>
                            </div>
                            <div class="col-4">
                                <input type="time" class="form-control" id="deadline_time" name="deadline_time" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="onReset()">Ulang</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="onSave()">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

