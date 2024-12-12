<div class="modal fade modal-md" tabindex="-1" id="modal_form">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-3">
                <form id="form_mahasiswa">
                    <div class="col-5 row">
                        <label class="mb-3">DATA USER</label>

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
                    <hr>
                    <div class="col-12 row">
                        <label class="my-3 ">DATA MAHASISWA </label>
                        <div class="col-md-8">
                            <input type="hidden" id="id" name="id">
                            <input type="hidden" id="user_id" name="user_id">
                            <label class="required-label mb-1">NIM</label>
                            <div class="form-group mb-2">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="nim" name="nim" maxlength="10" required />
                                </div>
                            </div>

                            <label class="required-label mb-1">Nama</label>
                            <div class="form-group mb-2">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="nama" name="nama" required />
                                </div>
                            </div>

                            <div class="col-12 row">
                                <div class="col-md-6">
                                    <label class="required-label mb-1">Jurusan</label>
                                    <div class="form-group mb-2 ">
                                        <div class="form-line">
                                            <select class="form-control  jurusan_id-select2 " style="width: 100%;" id="jurusan_id" name="jurusan_id" onchange="jurusanChange()">
                                                <option value="">-- PILIH --</option>
                                            </select>
                                        </div>
                                    </div>

                                    <label class="required-label mb-1">Prodi</label>
                                    <div class="form-group mb-2 ">
                                        <div class="form-line">
                                            <select class="form-control  prodi_id-select2 " style="width: 100%;" id="prodi_id" name="prodi_id" onchange="prodiChange()">
                                                <option value="">-- PILIH --</option>
                                            </select>
                                        </div>
                                    </div>

                                    <label class="required-label mb-1">Kelas</label>
                                    <div class="form-group mb-2 ">
                                        <div class="form-line">
                                            <select class="form-control  kelas_id-select2 " style="width: 100%;" id="kelas_id" name="kelas_id">
                                                <option value="">-- PILIH --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                <label class=" mb-1">Jenis Kelamin</label>
                                    <div class="form-group mb-2">
                                        <div class="form-line " >
                                            <select type="text" class="form-control jk" style="width: 240px;" id="jk" name="jk">
                                                <option value="" selected disabled>-- PILIH --</option>
                                                <option value="L">Laki-laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <label class=" mb-1">No Hp</label>
                                    <div class="form-group mb-2">
                                        <div class="form-line">
                                            <input type="text" class="form-control " id="no_hp" name="no_hp" maxlength="13" />
                                        </div>
                                    </div>

                                    <label class=" mb-1">Angkatan</label>
                                    <div class="form-group mb-2">
                                        <div class="form-line">
                                            <input type="number" class="form-control" id="angkatan" name="angkatan" maxlength="4" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            


                        </div>
                        <div class="col-md-4">
                            <label class="mb-2">Foto Profil</label>
                            <div class="row">

                                <div class="picture-container  col-2">
                                    <div class="picture">
                                        <img src="" class="picture-src" id="user_photoPreview" title="">
                                        <input type="file" id="user_photo" name="user_photo">
                                    </div>

                                </div>
                                <i class="col-10 remove-img d-flex justify-content-start fa fa-times text-danger fa-2x"
                                    onclick="removePP(this)"></i>
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