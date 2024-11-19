<script type="text/javascript">
    var listForm = [
        'id',
        'nip',
        'nama',
        'jurusan_id',
        'prodi_id',
        'jk',
        'no_hp',
        'user_id',
        'username',
        'password'
    ];

    var action = '';

    $(() => {
        index();
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
       
        $('.jk').select2({
            dropdownParent: $('#modal_form')
        });

    });

    index = () => {
        if ($.fn.DataTable.isDataTable('#table')) {
            $('#table').DataTable().clear().destroy();
        }

        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '/tataTertib/controllers/staff.php',
                type: 'POST',
                data: function(d) {
                    d.action = 'index';
                }
            },
            columnDefs: [{
                    targets: 0,
                    data: 'username',
                    searchable: false,
                    orderable: false,
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    targets: 1,
                    data: 'nim',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        var urlPhoto = row.photo.path ? '/tataTertib/'+ row.photo.path : '/tataTertib/assets/img/noImage.jpg';

                        html = `
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50px me-2 ">
                                    <img src="${urlPhoto}" class="rounded" alt="image" height="50" width="50" style="object-fit: cover;">
                                </div>
                                <div class="d-flex justify-content-start flex-column">
                                    <span class="text-dark fw-bolder fs-6 text-start">${row.nip}</span>
                                    <span class="text-muted fw-bold text-muted d-block fs-7 text-start">${row.nama}</span>
                                </div>
                            </div>
                        `;

                        return html;
                    }
                },
                {
                    targets: 2,
                    data: 'jurusan_nama',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data;
                    }
                },
                {
                    targets: 3,
                    data: 'prodi_nama',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data;
                    }
                },
                
                {
                    targets: 4,
                    data: 'no_hp',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data;
                    }
                },
                {
                    targets: 5,
                    data: 'jk',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        var html = ``;
                        if (data == 'L') {
                            html = `<span class="badge bg-success">Laki-Laki</span>`;           
                        }else{
                            html = `<span class="badge bg-info">Perempuan</span>`;
                        }
                        return html;
                    }
                },
                {
                    targets: 6,
                    data: 'id',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        var html = `
                            <div class="dropleft">
                                <button class="btn btn-light btn-sm" type="button" id="dropdownMenuButton-${data}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-${data}">
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="onEdit(${data})"><i class="fa fa-edit"></i> Edit Data</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"  onclick="onDestroy(${data})" data-id="${data}"><i class="fa fa-trash"></i> Hapus</a>
                                    </li>
                                </ul>
                            </div>
                        `;
                        return html;
                    }
                }
            ],
        });
    };

    jurusanChange = () => {
        getProdi($('#jurusan_id').val());
    }

    onReset = () => {
        removePP();
        resetForm(listForm);
    }

    onAdd = () => {
        onReset();
        $('#password').attr('placeholder', '').attr('required', 'required');
        $('#modal_form').modal('show');
        action = 'store';
    }

    onEdit = (id) => {
        $.ajax({
            url: '/tataTertib/controllers/staff.php',
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
                onAlert("Gagal !", "Data gagal tersimpan.", "error");
            }
        });
    }

    saveData = () => {
        var form = $('#form_dosen').get(0);
        var formData = new FormData(form);
        formData.append('action', action);
        $.ajax({
            url: '/tataTertib/controllers/staff.php',
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
    
    
    onDestroy = (id) => {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Data akan terhapus dari database.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#0abb87",
            cancelButtonColor: "#d33",
            confirmButtonText: "Hapus",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                destroyData(id);
            } else {
                $('#modal_form').modal('hide');
                Swal.fire({
                    title: "Gagal !",
                    text: "Data gagal terhapus.",
                    icon: "error",
                    confirmButtonColor: "#3b7ddd",
                });
            }
        });
    }

    destroyData = (id) => {
        $.ajax({
            url: '/tataTertib/controllers/staff.php',
            data: {
                action: 'destroy',
                id: id
            },
            type: 'POST',
            success: (data) => {
                if (data == 1) {
                    index();
                    Swal.fire({
                        title: "Sukses!",
                        text: "Data Terhapus :)",
                        icon: "success",
                        confirmButtonColor: "#3B7DDD",
                    });
                } else {
                    Swal.fire({
                        title: "Gagal!",
                        text: "Data Gagal Terhapus :( . Silahkan Hubungi Administrator.",
                        icon: "warning",
                        confirmButtonColor: "#3B7DDD",
                    });
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
            url: '/tataTertib/controllers/jurusan.php',
            data: {
                action: 'getAll'
            },
            type: 'POST',
            success: (data) => {
                data = JSON.parse(data);

                var html = '<option value="" class="drop-pilih" >-- PILIH --</option>';

                for (i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i]['id'] + '">' + data[i]['kode'] + ' - ' + data[i]['nama'] + '</option>';
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
            url: '/tataTertib/controllers/prodi.php',
            data: {
                action: 'getByJurusan',
                id: id
            },
            type: 'POST',
            success: (data) => {
                data = JSON.parse(data);

                var html = '<option value="" class="drop-pilih">-- PILIH --</option>';

                for (i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i]['id'] + '">' + data[i]['kode'] + ' - '  + data[i]['nama'] + '</option>';
                }

                $('#prodi_id').html(html);
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })
    }
</script>