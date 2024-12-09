<script type="text/javascript">
    var listForm = [
        'id',
        'username',
        'password'
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
            lengthMenu: [5, 10, 25, 50, 100],
        language: {
            lengthMenu: "Menampilkan  _MENU_  data per halaman",
            info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data"
        },
            ajax: {
                url: '/tataTertib/system/admin.php',
                type: 'POST',
                data: function(d) {
                    d.action = 'index';
                }
            },
            columnDefs: [{
                    targets: 0,
                    data: 'id',
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

   
    onReset = () => {
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
            url: '/tataTertib/system/admin.php',
            data: {
                action: 'getById',
                id: id
            },
            type: 'POST',
            success: (data) => {
                
                action = 'update';

                var data = JSON.parse(data);


                for (i = 0; i < listForm.length; i++) {
                    $('#' + listForm[i]).val(data[listForm[i]]).trigger('change');            
                }

                $('#password').val('').attr('placeholder', 'Kosongkan jika tidak ingin mengubah password').removeAttr('required');
                
                $('#modal_form').modal('show');
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })
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
        var form = $('#form_admin').get(0);
        var formData = new FormData(form);
        formData.append('action', action);
        $.ajax({
            url: '/tataTertib/system/admin.php',
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
                }else if(data == 2){
                    onAlert("Gagal !", "Data yang sedang digunakan tidak dapat diubah :)", "warning");

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
        onConfirm("Data akan terhapus dari database.", (result) => {
            if (result.isConfirmed) {
                destroyData(id);
            } else {
                onAlert("Gagal !", "Data Aman, tidak terhapus :)", "error");
            }
        });
    }

    destroyData = (id) => {
        $.ajax({
            url: '/tataTertib/system/admin.php',
            data: {
                action: 'destroy',
                id: id
            },
            type: 'POST',
            success: (data) => {
                if (data == 1) {
                    index();
                    onAlert("Sukses !", "Data Terhapus :)", "success");
                } else {
                    onAlert("Gagal !", "Data Gagal Terhapus :( . Silahkan Hubungi Administrator.", "warning");
                }
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        });
    }

</script>