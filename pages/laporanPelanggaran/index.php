<div class="d-flex align-items-center w-100" style="background-color: #e9eff7; width: 105.5% !important; margin-left:-2.7%; margin-top: -47px; height: 68px; border: 1px #f2f2f2">
    <div class="mx-4 w-100 row">
        <div class="col-md-3 d-flex justify-content-start">
            <i class="fa fa-tasks text-primary me-4 fs-3" style="position: absolute; top:90px"></i>
            <span style="font-size: 14px; font-weight:600; margin-top: 2px" class="ms-5">Laporan Pelanggaran</span>
        </div>
        <!-- <div class="col-md-9 d-flex justify-content-end">
            <button class="btn btn-primary btn-sm text-white" onclick="onAdd()"><i class="fa fa-calculator"></i> &nbsp;Tambah Data</button>

        </div> -->
    </div>
</div>
<div class="card mt-5">
    <div class="card-body">

        <table id="table" class="table table-bordered table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th width="40px">No</th>
                    <th>Tanggal Aduan</th>
                    <th>Terlapor</th>
                    <th>Pelapor</th>
                    <th width="400px">Keterangan</th>
                    <th>Kategori</th>
                    <th>Verifikasi Oleh</th>
                    <th>Status</th>
                    <th width="52px" style="text-align: center;">Sanksi</th>
                    <th width="52px" style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<div class="modal fade modal-md" tabindex="1" id="modal_verifikasi">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Form Tugas Sanksi</h5>
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
                        <!-- <div class="col-12 mb-3">
                            <label class="mb-1">Komentar </label>
                            <textarea class="form-control " rows="5" id="komentar" disabled></textarea>
                        </div>
                         -->
                        <div class="col-12 mb-3">
                            <label class="mb-1">Tanggal Verifikasi Sanksi </label>
                            <input type="text" class="form-control " id="verifikasi_date" disabled></input>
                        </div>

                        <div class="col-12 mb-3">
                            <a href="#" target="_blank"  id="file_path" class="btn btn-primary">
                                Download File Sanksi
                            </a>
                        </div>
                      
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include 'form.php'; ?>
<?php include 'script.php'; ?>