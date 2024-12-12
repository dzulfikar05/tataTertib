<div class="modal fade modal-md" tabindex="-1" id="modal_form">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-3">
                <form id="form_admin">
                    <div class="col-5 row">
                        <input type="hidden" id="id" name="id">
                        <label class="required-label mb-1">username</label>
                        <div class="form-group mb-2">
                            <div class="form-line">
                                <input type="text" class="form-control" id="username" name="username" required />
                            </div>
                        </div>
                        <label class="required-label mb-1">password</label>
                        <div class="form-group mb-3">
                            <div class="form-line">
                                <input type="password" class="form-control" id="password" name="password" required />
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" onclick="resetForm()">Ulang</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="save()">Simpan</button>
            </div>
        </div>
    </div>
</div>