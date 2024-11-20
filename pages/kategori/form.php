<div class="modal fade modal-md" tabindex="-1" id="modal_form">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-3">
                <form id="form_kategori">
                    <div class="col-12 row">
                        <input type="hidden" id="id" name="id">

                        <div class="row">
                            <div class="col-md-9">
                                <label class="required-label mb-1">Nama</label>
                                <div class="form-group mb-2">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="nama" name="nama" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">

                                <label class="required-label mb-1">Tingkat</label>
                                <div class="form-group mb-2">
                                    <div class="form-line">
                                        <input type="number" class="form-control" id="bobot" name="bobot" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label class="required-label mb-1">Keterangan</label>
                        <div class="form-group mb-2">
                            <div class="form-line">
                                <textarea type="text" class="form-control textarea-keterangan" rows="5" id="keterangan" name="keterangan" required /></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="onReset()">Reset</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="onSave()">Save</button>
                    </div>
            </div>
        </div>
    </div>