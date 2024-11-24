<?php include 'pages/dosen/mahasiswa.php' ?>

<script type="text/javascript">
    var listForm = [
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

    var action = '';

    $(() => {
        getJurusan();

        $("#user_photo").change(function() {
            readURL(this);
        });

        $('.jurusan_id-select2').select2({
            dropdownParent: $('#modal_form')
        });
        $('.prodi_id-select2').select2({
            dropdownParent: $('#modal_form')
        });
        $('.kelas_id-select2').select2({
            dropdownParent: $('#modal_form')
        });
        $('.jk').select2({
            dropdownParent: $('#modal_form')
        });
        $('.modal-title').html('Form Profile');


    });

    jurusanChange = () => {
        getProdi($('#jurusan_id').val());
    }

    prodiChange = () => {
        getKelas($('#prodi_id').val());
    }
    
    onReset = () => {
        removePP();
        resetForm(listForm);
    }

    onEdit = (id) => {
        $.ajax({
            url: '/tataTertib/system/mahasiswa.php',
            data: {
                action: 'getById',
                id: id
            },
            type: 'POST',
            success: (data) => {
                
                action = 'update';

                var json = JSON.parse(data);

                var dataUser = json['data'];
                var photoUser = json['photo'];

                for (i = 0; i < listForm.length; i++) {
                    $('#' + listForm[i]).val(dataUser[listForm[i]]).trigger('change');            
                }

                setTimeout(() => {
                    $('#prodi_id').val(dataUser['prodi_id']).trigger('change');
                }, 800);
                setTimeout(() => {
                    $('#kelas_id').val(dataUser['kelas_id']).trigger('change');
                }, 3000);
                
                $('#user_photoPreview').attr('src', photoUser['path']).fadeIn('slow');
                
                $('#password').val('').attr('placeholder', 'Kosongkan jika tidak ingin mengubah password').removeAttr('required');
                
                $('#modal_form').modal('show');
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })

        $('#modal_form').modal('show');
        
    }

    save = () => {
        onConfirm("Data akan tersimpan di database.", (result) => {
            if (result.isConfirmed) {
                saveData();
            } else {
                $('#modal_form').modal('hide');
                onAlert("Gagal !", "Data gagal tersimpan. Silahkan hubungi Administrator.", "error");
            }
        });
    }

    saveData = () => {
        var form = $('#form_mahasiswa').get(0);
        var formData = new FormData(form);
        formData.append('action', action);
        $.ajax({
            url: '/tataTertib/system/mahasiswa.php',
            data: formData,
            type: 'POST',
            processData: false,
            contentType: false,
            success: (data) => {
                if (data == 1) {
                    $('#modal_form').modal('hide');

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
                $('#user_photoPreview').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    removePP = () => {
        $('#user_photoPreview').attr('src', '').fadeIn('slow');
        $('#user_photo').val('');
    }

    getJurusan = () => {
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

                $('#jurusan_id').html(html);
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })
    }
    getProdi = (id) => {
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

                $('#prodi_id').html(html);
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })
    }
    getKelas = (id) => {
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

                $('#kelas_id').html(html);
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })
    }

</script>
