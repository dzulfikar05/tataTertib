<script type="text/javascript">
    const listForm = [
        'id',
        'pelapor_id',
        'pelaku_id',
        'keterangan',
    ];
    let listKategori;

    let action = '';

    $(() => {
        index();

    });

    index = () => {
        if ($.fn.DataTable.isDataTable('#table')) {
            $('#table').DataTable().clear().destroy();
        }

        let table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            lengthMenu: [5, 10, 25, 50, 100],
        language: {
            lengthMenu: "Show _MENU_ items per page"
        },
            ajax: {
                url: '/tataTertib/system/sanksi-pelanggaran.php',
                type: 'POST',
                data: function(d) {
                    d.action = 'index';
                }
            },
            columnDefs: [{
                    targets: 0,
                    data: 'pelanggaran_tanggal',
                    searchable: false,
                    orderable: false,
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    targets: 1,
                    data: 'pelanggaran_tanggal',
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
                    data: 'pelanggaran_mahasiswa_nim',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        html = `
                            <div class="d-flex align-items-center">
                                <div class="d-flex justify-content-start flex-column">
                                    <span class="text-dark fw-bolder fs-6 text-start">${row.pelanggaran_mahasiswa_nim}</span>
                                    <span class="text-muted fw-bold text-muted d-block fs-7 text-start">${row.pelanggaran_mahasiswa_nama} (mahasiswa)</span>
                                </div>
                            </div>
                        `;

                        return html;
                    }
                },
              
                {
                    targets: 3,
                    data: 'pelanggaran_keterangan',
                    searchable: true,
                    orderable: true,
                    className: 'text-start',
                    render: function(data, type, row) {
                        return data;
                    }
                },
               
                {
                    targets: 4,
                    data: 'pelanggaran_kategori_nama',
                    searchable: true,
                    orderable: true,
                    className: 'text-start',
                    render: function(data, type, row) {
                        let html = `
                            <span >${data} </span><br>
                            <span class="text-secondary fw-bold d-block fs-7 text-start">Tingkat : ${row.kategori_bobot - row.bobotUpper}</span>
                        `;
                        return html;
                    }
                },
               
                {
                    targets: 5,
                    data: 'status',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        var dataSpan = [];
                        if (data == 1) { dataSpan['color'] = 'text-bg-secondary'; dataSpan['message'] = 'Sanksi Belum Diupload'; }
                        if (data == 2) { dataSpan['color'] = 'text-bg-primary'; dataSpan['message'] = 'Menunggu Verifikasi'; }
                        if (data == 3) { dataSpan['color'] = 'text-bg-warning'; dataSpan['message'] = 'Revisi'; }
                        if (data == 4) { dataSpan['color'] = 'text-bg-success'; dataSpan['message'] = 'Selesai'; }
                        let html = `
                            <span class="badge ${dataSpan['color']}">${dataSpan['message']}</span>
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
                        var dataBtn = [];
                        if(row.file_upload.length == 0){ dataBtn['color'] = 'btn-secondary'; dataBtn['message'] = 'Buat Tugas'; }

                        if(row.file_upload.length > 0 || row.status == 2){ dataBtn['color'] = 'btn-primary'; dataBtn['message'] = 'Lihat Tugas'; }

                        if(row.file_upload.length > 0 || row.status == 3){ dataBtn['color'] = 'btn-warning'; dataBtn['message'] = 'Lihat Tugas'; }

                        if(row.file_upload.length > 0 || row.status == 4){ dataBtn['color'] = 'btn-success'; dataBtn['message'] = 'Selesai'; }

                        let html = `
                            <button class="btn ${dataBtn['color']} btn-sm" type="button" onclick="onUpload(${data})">
                                <i class="fa fa-edit"></i>
                                ${dataBtn['message']}    
                            </button>
                        `;
                        return html;
                    }
                }
            ],
        });
    };

    
    onUpload = (id) => {
        onReset();
        $.ajax({
            url: '/tataTertib/system/sanksi-pelanggaran.php',
            data: {
                action: 'getById',
                id: id
            },
            type: 'POST',
            success: (data) => {
                var data = JSON.parse(data);

                $('#id').val(data.id);
                $('#status').val(data.status);
                $('#tugas').val(data.tugas);
                $('#keterangan').val(data.keterangan);
                $('#komentar_revisi').val(data.komentar_revisi);
                $('#deadline_date').val(data.deadline_date);
                $('#deadline_time').val(data.deadline_time);
                $('#verifikator_id').val(data.pelanggaran_verify_by);
                $('#komentar').val(data.komentar);

                if(data.deadline_date && data.deadline_time){
                    const deadlineDateTime = `${data.deadline_date}T${data.deadline_time}`;
                    // Hitung waktu relatif dengan moment.js
                    $('#terlambat').text('Overdue ' + moment(deadlineDateTime).fromNow(data.updated_at));
                }

                
                if (data.file_upload.id) {
                    $('#file_path').attr('href', data.file_upload.path).html(data.file_upload.file_name);
                    $('#file_path').attr('href', data.file_upload.path).html(data.file_upload.file_name);
                    $('#uploaded_text').removeClass('d-none');
                }else{
                    $('#terlambat').text("");
                    $('#uploaded_text').addClass('d-none');
                }

                if(data.status == 4){$('.footer-form').addClass('d-none');}else{$('.footer-form').removeClass('d-none');}
                if(data.status == 3){$('.komentar_revisi').removeClass('d-none');}else{$('.komentar_revisi').addClass('d-none');}

            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })
        $('#modal_form').modal('show');
    }  

    onReset = () => {

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
        const form = $('#form_upload-sanksi').get(0);
        let formData = new FormData(form);
        formData.append('action', "uploadSanksi");
        $.ajax({
            url: '/tataTertib/system/sanksi-pelanggaran.php',
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
            url: '/tataTertib/system/sanksi-pelanggaran.php',
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
                    html += '<option value="' + data[i]['id'] + '">' + data[i]['nama'] + '</option>';
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

    onVerifikasi = (id, mhsId) => {
        $('#id_verifikasi').val(id);
        $('#mahasiswa_id').val(mhsId);
        $('#modal_verifikasi').modal('show');
    }

    onSaveVerifikasi = (status) => {
        
        onConfirm(status == 2 ? "Data Aduan akan tersimpan dengan status disetujui pada database." : "Data Aduan akan tersimpan dengan status ditolak pada database.", (result) => {
            if (result.isConfirmed) {
                const form = $('#form_verifikasi').get(0);
                let formData = new FormData(form);
                formData.append('action', 'verifikasiAduan');
                formData.append('status', status);
                $.ajax({
                    url: '/tataTertib/system/sanksi-pelanggaran.php',
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
                onAlert("Gagal !", "Data gagal tersimpan. Silahkan hubungi Administrator.", "error");
            }
        });
    }

    
</script>