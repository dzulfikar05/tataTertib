<script type="text/javascript">
    const listForm = [
        'id',
        'pelapor_id',
        'pelaku_id',
        'keterangan',
    ];
    let listKategori;

    let action = '';
    let historyMhs = [];

    let bobotUpper = 0;

    $(() => {
        index();

        $('.jurusan_id-select2').select2({
            dropdownParent: $('#modal_form')
        });

        $('.pelaku_id-select2').select2({
            dropdownParent: $('#modal_form')
        });

        $('.karegori_id-select2').select2({
            dropdownParent: $('#modal_verifikasi')
        });

        getJurusan();
        getKategori();
    });

    changeJurusan = () => {
        getMahasiswa();   
    }

    changeKategori = () => {
        $('#kategori_id').on('select2:select', function (e) {
            let id = $('#kategori_id').val();   
        
            let selectedOption = e.params.data.element; 
            let bobot = $(selectedOption).data('bobot');

            for (i = 0; i < listKategori.length; i++) {
                if (listKategori[i]['id'] == id) {
                    $('#deskripsi_kategori').html(listKategori[i]['keterangan']);
                    $('#bobot').val(listKategori[i]['bobot']);
                    $('#bobotKategori').val(listKategori[i]['bobot']);
                }
            }

            if(historyMhs.stat[bobot] > 3){
                bobotUpper = 1;
            }else{
                bobotUpper = 0;
            }

        });
    }

    index = () => {
        if ($.fn.DataTable.isDataTable('#table')) {
            $('#table').DataTable().clear().destroy();
        }

        let table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '/tataTertib/system/aduan-pelanggaran.php',
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
                    data: 'tanggal',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row, meta) {

                        const dateObject = new Date(data.date);
                        const formatter = new Intl.DateTimeFormat('id-ID', {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric'
                        });

                        const formattedDate = formatter.format(dateObject);
                        
                        return formattedDate;
                    }
                },
                {
                    targets: 2,
                    data: 'terlapor_mahasiswa_nim',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        html = `
                            <div class="d-flex align-items-center">
                                <div class="d-flex justify-content-start flex-column">
                                    <span class="text-dark fw-bolder fs-6 text-start">${row.terlapor_mahasiswa_nim}</span>
                                    <span class="text-muted fw-bold text-muted d-block fs-7 text-start">${row.terlapor_mahasiswa_nama} (mahasiswa)</span>
                                </div>
                            </div>
                        `;
                        return html;
                    }
                },
                {
                    targets: 3,
                    data: 'pelapor_dosen_nidn',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        if(row.pelapor_role == 3){
                            html = `
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-dark fw-bolder fs-6 text-start">${row.pelapor_dosen_nidn}</span>
                                        <span class="text-muted fw-bold text-muted d-block fs-7 text-start">${row.pelapor_dosen_nama} (dosen)</span>
                                    </div>
                                </div>
                            `;
                        }else if(row.pelapor_role == 2){
                            html = `
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-dark fw-bolder fs-6 text-start">${row.pelapor_staff_nip}</span>
                                        <span class="text-muted fw-bold text-muted d-block fs-7 text-start">${row.pelapor_staff_nama} (staff)</span>
                                    </div>
                                </div>
                            `;
                        }

                        return html;
                    }
                },
                {
                    targets: 4,
                    data: 'keterangan',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data;
                    }
                },
                {
                    targets: 5,
                    data: 'id',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {

                        let html = `
                            <button class="btn btn-warning btn-sm fs-5" type="button" onclick="onVerifikasi(${row.id},${row.terlapor_mahasiswa_id}, ${row.pelaku_id})" title="Menuggu Verifikasi">
                                <i class="fa fa-clock" ></i>
                            </button>
                        `;
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
            url: '/tataTertib/system/aduan-pelanggaran.php',
            data: {
                action: 'getById',
                id: id
            },
            type: 'POST',
            success: (data) => {
                var data = JSON.parse(data);
                action = 'update';

                $('#jurusan_id').val(data.mahasiswa.jurusan_id).trigger('change');            


                setTimeout(() => {
                    for (i = 0; i < listForm.length; i++) {
                        $('#' + listForm[i]).val(data[listForm[i]]).trigger('change');            
                    }
                    $('#modal_form').modal('show');
                }, 800);

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
                onAlert("Gagal !", "Data gagal tersimpan.", "error");
            }
        });
    }

    saveData = () => {
        const form = $('#form_aduan-pelanggaran').get(0);
        let formData = new FormData(form);
        formData.append('action', action);
        $.ajax({
            url: '/tataTertib/system/aduan-pelanggaran.php',
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
            url: '/tataTertib/system/aduan-pelanggaran.php',
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

    getKategori = () => {
        $.ajax({
            url: '/tataTertib/system/kategori.php',
            data: {
                action: 'getAll'
            },
            type: 'POST',
            success: (data) => {
                data = JSON.parse(data);
                listKategori = data;
                var html = '<option value="" class="drop-pilih" >-- PILIH --</option>';

                for (i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i]['id'] + '" data-bobot="' + data[i]['bobot'] + '">' + data[i]['nama'] + '</option>';
                }

                $('#kategori_id').html(html);
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })
    }

    getMahasiswa = () => {
        let jurusanId = $('#jurusan_id').val();
        $.ajax({
            url: '/tataTertib/system/mahasiswa.php',
            data: {
                id: jurusanId,
                action: 'getByJurusan'
            },
            type: 'POST',
            success: (data) => {
                data = JSON.parse(data);

                var html = '<option value="" class="drop-pilih" >-- PILIH --</option>';

                for (i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i]['user_id'] + '">' +data[i]['nim'] + ' - ' + data[i]['nama'] + ' || ' + data[i]['prodi_nama'] + ' - ' + data[i]['kelas_nama'] +'</option>';
                }

                $('#pelaku_id').html(html);
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })
    }

    onVerifikasi = (id, mhsId, mhsUserId) => {
        $('#id_verifikasi').val(id);
        $('#mahasiswa_id').val(mhsId);
        historyMhs = [];

        $.ajax({
            url: '/tataTertib/system/aduan-pelanggaran.php',
            data: {
                action: 'getStatMahasiswa',
                mhsId : mhsUserId,
                id: id
            },
            type: 'POST',
            success: (data) => {
                data = JSON.parse(data);

                var html = `<p>Riwayat Pelanggaran :</p>`;
                $.each(data.stat, (index, value) => {
                    html += `<span> Pelanggaran dengan Tingkat ${index} : ${value} kali</span><br>`;
                })

                $('.history_mhs').html(html);
                $('#modal_verifikasi').modal('show');
                $('#keterangan_pelanggaran').html(data.data_keterangan);

                historyMhs = data;
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })
    }

    onSaveVerifikasi = (status) => {
        let messageAlert = bobotUpper==1 ? "Data Aduan akan tersimpan dengan status disetujui pada database. Pelanggaran dilakukan melebihi 3x, sehingga bobot akan dinaikkan 1 poin." : "Data Aduan akan tersimpan dengan status disetujui pada database."; 

        onConfirm(status == 2 ? messageAlert : "Data Aduan akan tersimpan dengan status ditolak pada database.", (result) => {
            if (result.isConfirmed) {
                const form = $('#form_verifikasi').get(0);
                let formData = new FormData(form);
                formData.append('action', 'verifikasiAduan');
                formData.append('status', status);
                formData.append('bobotUpper', bobotUpper);
                $.ajax({
                    url: '/tataTertib/system/aduan-pelanggaran.php',
                    data: formData,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    success: (data) => {
                        if (data == 1) {
                            $('#modal_verifikasi').modal('hide');
                            index();
                            onAlert("Sukses !", status == 2 ? "Data Telah disetujui dan tersimpan :)" : "Data Telah ditolak dan tersimpan :)", "success");
                        } else {
                            onAlert("Gagal !", "Data Gagal Tersimpan :( . Silahkan Hubungi Administrator.", "warning");
                        }
                    },
                    error: (jqXHR, textStatus, errorThrown) => {
                        console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
                    }
                });
            } else {
                $('#modal_verifikasi').modal('hide');
                onAlert("Gagal !", "Data gagal tersimpan.", "error");
            }
        });
    }

    
</script>