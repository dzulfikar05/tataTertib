<script>
    var listForm = [
        'id',
        'username',
        'email',
        'password',
        'level'
    ];

    var action = '';

    $(() => {
        index();
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
                url: '/tataTertib/system/pengguna.php',
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
                    data: 'username',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data;
                    }
                },
                {
                    targets: 2,
                    data: 'email',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data;
                    }
                },
                {
                    targets: 3,
                    data: 'role',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data;
                    }
                },
                {
                    targets: 4,
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
                                        <a class="dropdown-item" href="#" onclick="edit(${data})"><i class="fa fa-edit"></i> Edit Data</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"  onclick="destroy(${data})" data-id="${data}"><i class="fa fa-trash"></i> Hapus</a>
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

    resetForm = () => {
        for (i = 0; i < listForm.length; i++) {
            $('#' + listForm[i]).val('');            
        }
    }

    add = () => {
        $('#password').attr('placeholder', '');
        $('#modal_form').modal('show');
        action = 'store';
    }

    edit = (id) => {
        $.ajax({
            url: '/tataTertib/system/pengguna.php',
            data: {
                action: 'getById',
                id: id
            },
            type: 'POST',
            success: (data) => {
                action = 'update';

                var json = JSON.parse(data);
                for (i = 0; i < listForm.length; i++) {
                    $('#' + listForm[i]).val(json[listForm[i]]);            
                }
                $('#password').val('');
                $('#password').attr('placeholder', 'Kosongkan jika tidak ingin mengganti password');

                $('#modal_form').modal('show');
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })

        $('#modal_form').modal('show');
        
    }

    save = () => {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Data akan tersimpan di database.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#0abb87",
            cancelButtonColor: "#d33",
            confirmButtonText: "Simpan",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                saveData();
            } else {
                $('#modal_form').modal('hide');
                Swal.fire({
                    title: "Gagal !",
                    text: "Data gagal tersimpan.",
                    icon: "error",
                    confirmButtonColor: "#3b7ddd",
                });
            }
        });
    }

    saveData = () => {
        var form = $('#form_pelanggan').get(0);
        var formData = new FormData(form);
        formData.append('action', action);
        $.ajax({
            url: '/tataTertib/system/pengguna.php',
            data: formData,
            type: 'POST',
            processData: false,
            contentType: false,
            success: (data) => {
                if (data == 1) {
                    $('#modal_form').modal('hide');

                    resetForm();
                    index();

                    Swal.fire({
                        title: "Sukses!",
                        text: "Data Tersimpan :)",
                        icon: "success",
                        confirmButtonColor: "#3B7DDD",
                    });
                } else {
                    Swal.fire({
                        title: "Gagal!",
                        text: "Data Gagal Tersimpan :( . Silahkan Hubungi Administrator.",
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
    
    
    destroy = (id) => {
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
            url: '/tataTertib/system/pengguna.php',
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
</script>