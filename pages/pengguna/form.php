<div class="modal fade modal-md" id="modal_form">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-3">
                <form id="form_pelanggan">
                    <input type="hidden" id="id" name="id">
                    <label>Username</label>
                    <div class="form-group mb-2">
                        <div class="form-line">
                            <input type="text" class="form-control" id="username" name="username" required/>
                        </div>
                    </div>

                    <label>Email</label>
                    <div class="form-group mb-2">
                        <div class="form-line">
                            <input type="text" class="form-control" id="email" name="email" required/>
                        </div>
                    </div>

                    <label>Password</label>
                    <div class="form-group mb-2">
                        <div class="form-line">
                            <input type="password" class="form-control" id="password" name="password" required/>
                        </div>
                    </div>

                    <label>Level</label>
                    <div class="form-group mb-2">
                        <div class="form-line">
                            <select class="form-control show-tick" id="level" name="level">
                                <option value="" selected disabled>-- Pilih Level --</option>
                                <option value="admin">ADMIN</option>
                                <option value="kasir">KASIR</option>

                            </select>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Reset</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="save()">Save</button>
            </div>
        </div>
    </div>
</div>