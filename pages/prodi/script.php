<script type="text/javascript">
    const listForm = [
        'id',
        'nama',
        'jurusan_id',

    ];

    let action = '';

    $(() => {
        index();
        getJurusan();

        $('.jurusan_id-select2').select2({
            dropdownParent: $('#modal_form')
        });
    });

    index = () => {
        if ($.fn.DataTable.isDataTable('#table')) {
            $('#table').DataTable().clear().destroy();
        }

        let table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '/tataTertib/system/prodi.php',
                type: 'POST',
                data: function(d) {
                    d.action = 'index';
                }
            },
            columnDefs: [{
                    targets: 0,
                    data: 'nama',
                    searchable: false,
                    orderable: false,
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    targets: 1,
                    data: 'nama',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data;
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
                    data: 'id',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        let html = `
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

    onAdd = () => {
        resetForm(listForm);
        $('#modal_form').modal('show');
        action = 'store';
    }

    onEdit = (id) => {
        $.ajax({
            url: '/tataTertib/system/prodi.php',
            data: {
                action: 'getById',
                id: id
            },
            type: 'POST',
            success: (data) => {
                var data = JSON.parse(data);
                action = 'update';

                for (i = 0; i < listForm.length; i++) {
                    $('#' + listForm[i]).val(data[listForm[i]]).trigger('change');            
                }

                $('#modal_form').modal('show');
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })

        $('#modal_form').modal('show');
        
    }    

    onReset = () => {
        resetForm(listForm);
    }

    onSave = () => {
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
        const form = $('#form_jurusan').get(0);
        let formData = new FormData(form);
        formData.append('action', action);
        $.ajax({
            url: '/tataTertib/system/prodi.php',
            data: formData,
            type: 'POST',
            processData: false,
            contentType: false,
            success: (data) => {
                if (data == 1) {
                    $('#modal_form').modal('hide');

                    onReset();
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
            url: '/tataTertib/system/prodi.php',
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
                    html += '<option value="' + data[i]['id'] + '">' + data[i]['nama'] + '</option>';
                }

                $('#jurusan_id').html(html);
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })
    }
    
</script>