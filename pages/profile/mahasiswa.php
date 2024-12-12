<div class="modal fade modal-md" tabindex="-1" id="p_modal_form">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-title-p">Form Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-3">
                <form id="p_form_mahasiswa">
                    <div class="col-5 row">
                        <label class="mb-3">DATA USER</label>

                        <label class="required-label mb-1">username</label>
                        <div class="form-group mb-2">
                            <div class="form-line">
                                <input type="text" class="form-control" id="p_username" name="username" required />
                            </div>
                        </div>
                        <label class="required-label mb-1">password</label>
                        <div class="form-group mb-3">
                            <div class="form-line">
                                <input type="password" class="form-control" id="p_password" name="password" required />
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="col-12 row">
                        <label class="my-3 ">DATA MAHASISWA </label>
                        <div class="col-md-8">
                            <input type="hidden" id="p_id" name="id">
                            <input type="hidden" id="p_user_id" name="user_id">
                            <label class="required-label mb-1">NIM</label>
                            <div class="form-group mb-2">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="p_nim" name="nim" maxlength="10" required />
                                </div>
                            </div>

                            <label class="required-label mb-1">Nama</label>
                            <div class="form-group mb-2">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="p_nama" name="nama" required />
                                </div>
                            </div>

                            <label class=" mb-1">No Hp</label>
                            <div class="form-group mb-2">
                                <div class="form-line">
                                    <input type="text" class="form-control " id="p_no_hp" name="no_hp" maxlength="13" />
                                </div>
                            </div>

                            <div class="col-12 row d-none">
                                <div class="col-md-6">
                                    <label class="required-label mb-1">Jurusan</label>
                                    <div class="form-group mb-2 ">
                                        <div class="form-line">
                                            <select class="form-control  jurusan_id-select2 " style="width: 100%;" id="p_jurusan_id" name="jurusan_id" onchange="pJurusanChange()">
                                                <option value="">-- PILIH --</option>
                                            </select>
                                        </div>
                                    </div>

                                    <label class="required-label mb-1">Prodi</label>
                                    <div class="form-group mb-2 ">
                                        <div class="form-line">
                                            <select class="form-control  prodi_id-select2 " style="width: 100%;" id="p_prodi_id" name="prodi_id" onchange="pProdiChange()">
                                                <option value="">-- PILIH --</option>
                                            </select>
                                        </div>
                                    </div>

                                    <label class="required-label mb-1">Kelas</label>
                                    <div class="form-group mb-2 ">
                                        <div class="form-line">
                                            <select class="form-control  kelas_id-select2 " style="width: 100%;" id="p_kelas_id" name="kelas_id">
                                                <option value="">-- PILIH --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                <label class=" mb-1">Jenis Kelamin</label>
                                    <div class="form-group mb-2">
                                        <div class="form-line " >
                                            <select type="text" class="form-control jk" style="width: 240px;" id="p_jk" name="jk">
                                                <option value="" selected disabled>-- PILIH --</option>
                                                <option value="L">Laki-laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>

                                   

                                    <label class=" mb-1">Angkatan</label>
                                    <div class="form-group mb-2">
                                        <div class="form-line">
                                            <input type="number" class="form-control" id="p_angkatan" name="angkatan" maxlength="4" />
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
                                        <img src="" class="picture-src" id="p_user_photoPreview" title="">
                                        <input type="file" id="p_user_photo" name="user_photo">
                                    </div>

                                </div>
                                <i class="col-10 remove-img d-flex justify-content-start fa fa-times text-danger fa-2x"
                                    onclick="pRemovePP(this)"></i>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" onclick="resetForm()">Ulang</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="pSave()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var profileListForm = [
        'id',
        'nim',
        'nama',
        'jurusan_id',
        'prodi_id',
        'kelas_id',
        'jk',
        'no_hp',
        'angkatan',
        'user_id',
        'username',
        'password'
    ];

    var profileAction = '';

    $(() => {
        pGetJurusan();

        $("#p_user_photo").change(function() {
            readURL(this);
        });

        $('.jurusan_id-select2').select2({
            dropdownParent: $('#p_modal_form')
        });
        $('.prodi_id-select2').select2({
            dropdownParent: $('#p_modal_form')
        });
        $('.kelas_id-select2').select2({
            dropdownParent: $('#p_modal_form')
        });
        $('.jk').select2({
            dropdownParent: $('#p_modal_form')
        });
        $('.modal-title-p').html('Form Profile');


    });

    pJurusanChange = () => {
        pGetProdi($('#p_jurusan_id').val());
    }

    pProdiChange = () => {
        pGetKelas($('#p_prodi_id').val());
    }
    
    pOnReset = () => {
        pRemovePP();
        resetForm(profileListForm);
    }

    pOnEdit = (id) => {
        $.ajax({
            url: '/tataTertib/system/mahasiswa.php',
            data: {
                action: 'getById',
                id: id
            },
            type: 'POST',
            success: (data) => {
                
                profileAction = 'update';

                var json = JSON.parse(data);

                var dataUser = json['data'];
                var photoUser = json['photo'];

                for (i = 0; i < profileListForm.length; i++) {
                    $('#p_' + profileListForm[i]).val(dataUser[profileListForm[i]]).trigger('change');            
                }

                setTimeout(() => {
                    $('#p_prodi_id').val(dataUser['prodi_id']).trigger('change');
                }, 800);
                setTimeout(() => {
                    $('#p_kelas_id').val(dataUser['kelas_id']).trigger('change');
                }, 3000);
                
                $('#p_user_photoPreview').attr('src', photoUser['path']).fadeIn('slow');
                
                $('#p_password').val('').attr('placeholder', 'Kosongkan jika tidak ingin mengubah password').removeAttr('required');
                
                $('#p_modal_form').modal('show');
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })

        $('#p_modal_form').modal('show');
        
    }

    pSave = () => {
        onConfirm("Data akan tersimpan di database.", (result) => {
            if (result.isConfirmed) {
                pSaveData();
            } else {
                $('#p_modal_form').modal('hide');
                onAlert("Gagal !", "Data gagal tersimpan. Silahkan hubungi Administrator.", "error");
            }
        });
    }

    pSaveData = () => {
        var form = $('#p_form_mahasiswa').get(0);
        var formData = new FormData(form);
        formData.append('action', profileAction);
        $.ajax({
            url: '/tataTertib/system/mahasiswa.php',
            data: formData,
            type: 'POST',
            processData: false,
            contentType: false,
            success: (data) => {
                if (data == 1) {
                    $('#p_modal_form').modal('hide');

                    resetForm();
                    index();

                    onAlert("Sukses !", "Data Tersimpan :)", "success");
                } else {
                    onAlert("Gagal !", "Data Gagal Tersimpan :( . Silahkan Hubungi Administrator.", "warning");
                }
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        });
    }


    readURL = (input) => {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#p_user_photoPreview').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    pRemovePP = () => {
        $('#p_user_photoPreview').attr('src', '').fadeIn('slow');
        $('#p_user_photo').val('');
    }

    pGetJurusan = () => {
        $.ajax({
            url: '/tataTertib/system/jurusan.php',
            data: {
                action: 'getAll'
            },
            type: 'POST',
            success: (data) => {
                data = JSON.parse(data);

                var html = '<option value="" class="drop-pilih" >-- PILIH --</option>';

                for (i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i]['id'] + '"> ' + data[i]['nama'] + '</option>';
                }

                $('#p_jurusan_id').html(html);
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })
    }
    pGetProdi = (id) => {
        $.ajax({
            url: '/tataTertib/system/prodi.php',
            data: {
                action: 'getByJurusan',
                id: id
            },
            type: 'POST',
            success: (data) => {
                data = JSON.parse(data);

                var html = '<option value="" class="drop-pilih">-- PILIH --</option>';

                for (i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i]['id'] + '"> '  + data[i]['nama'] + '</option>';
                }

                $('#p_prodi_id').html(html);
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })
    }
    pGetKelas = (id) => {
        $.ajax({
            url: '/tataTertib/system/kelas.php',
            data: {
                action: 'getByProdi',
                id: id
            },
            type: 'POST',
            success: (data) => {
                data = JSON.parse(data);

                var html = '<option value="" class="drop-pilih">-- PILIH --</option>';


                for (i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i]['id'] + '"> '  + data[i]['nama'] + '</option>';
                }

                $('#p_kelas_id').html(html);
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })
    }

</script>
