<div class="modal fade modal-md" tabindex="-1" id="modal_form">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Aduan Pelanggaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-3">
                <form id="form_aduan-pelanggaran">  

                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" id="id" name="id">
                        </div>
                        <div class="col-12">
                            <label class="required-label mb-1">Jurusan</label>
                            <div class="form-group mb-2">
                                <select class="form-control jurusan_id-select2" style="width: 100%;" id="jurusan_id" onchange="changeJurusan()">
                                    <option value="">-- PILIH --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="required-label mb-1">Prodi</label>
                            <div class="form-group mb-2">
                                <select class="form-control prodi_id-select2" style="width: 100%;" id="prodi_id" onchange="changeProdi()">
                                    <option value="">-- PILIH --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="required-label mb-1">Mahasiswa</label>
                            <div class="form-group mb-2">
                                <select class="form-control pelaku_id-select2" style="width: 100%;" id="pelaku_id" name="pelaku_id">
                                    <option value="">-- PILIH --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="required-label mb-1">Deskripsi Pelanggaran</label>
                            <div class="form-group mb-2">
                                <textarea type="text" class="form-control textarea-keterangan" rows="5" id="keterangan" name="keterangan" placeholder="keterangan pelanggaran yang di lakukan" required></textarea>
                            </div>
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
<div class="modal fade modal-md" tabindex="-1" id="modal_verifikasi">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form  
                    Aduan Pelanggaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-3">
                <form id="form_verifikasi">
                    <input type="hidden" id="id_verifikasi" name="id">
                    <div class="col-12">
                        <label class="mb-1">Deskripsi Pelanggaran</label>
                        <div class="form-group mb-2">
                            <textarea type="text" class="form-control textarea-keterangan" rows="5" id="keterangan_pelanggaran" disabled placeholder="keterangan pelanggaran yang di lakukan"></textarea>
                        </div>
                    </div>
                    <div class="col-12 my-3">
                        <div class="history_mhs text-muted"></div>
                    </div>
                    <div class="col-12">
                        <label class="required-label mb-1">Kategori</label>
                        <div class="form-group mb-2">
                            <select class="form-control karegori_id-select2"  style="width: 100%;" id="kategori_id" name="kategori_id" onchange="changeKategori()">
                                <option value="">-- PILIH --</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 row">
                        <div class="col-md-9">
                            <label class="mb-1">Deskripsi Kategori</label>
                            <div class="form-group mb-2">
                                <textarea class="form-control textarea-keterangan" rows="5" id="deskripsi_kategori" disabled></textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="mb-1">Tingkat</label>
                            <div class="form-group mb-2">
                                <input type="hidden" id="bobotKategori" name="bobot">
                                <input type="hidden" id="mahasiswa_id" name="mahasiswa_id">
                                <input type="number" disabled class="form-control" id="tingkat"/>
                            </div>
                            <!-- <label class="mb-1">Bobot Poin</label>
                            <div class="form-group mb-2">
                                <input type="number" disabled class="form-control" id="bobot"/>
                            </div> -->
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-sm" onclick="onSaveVerifikasi(2)">Verifikasi</button>
                <button type="button" class="btn btn-danger btn-sm" onclick="onSaveVerifikasi(4)">Tolak</button>
            </div>
        </div>
    </div>
</div>