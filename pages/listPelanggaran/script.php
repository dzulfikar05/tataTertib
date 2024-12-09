<script type="text/javascript">
    const listForm = [
        'id',
        'pelapor_id',
        'pelaku_id',
        'keterangan',
    ];
    let listKategori;
    let listBobot = [5,4,3,2,1];
    let isAdmin = <?= $_SESSION['user']['role'] ?>;

    let action = '';

    $(() => {
        index();

    });

    changeJurusan = () => {
        getMahasiswa();
    }

    changeKategori = () => {
        let id = $('#kategori_id').val();
        for (i = 0; i < listKategori.length; i++) {
            if (listKategori[i]['id'] == id) {
                $('#deskripsi_kategori').html(listKategori[i]['keterangan']);
                $('#bobot').val(listKategori[i]['bobot']);
                $('#bobotKategori').val(listKategori[i]['bobot']);
            }
        }
    }

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
                lengthMenu: "Menampilkan  _MENU_  data per halaman"
            },
            ajax: {
                url: '/tataTertib/system/list-pelanggaran.php',
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
                        if (row.pelapor_role == 3) {
                            html = `
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-dark fw-bolder fs-6 text-start">${row.pelapor_dosen_nidn}</span>
                                        <span class="text-muted fw-bold text-muted d-block fs-7 text-start">${row.pelapor_dosen_nama} (dosen)</span>
                                    </div>
                                </div>
                            `;
                        } else if (row.pelapor_role == 2) {
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
                    className: 'text-start',
                    render: function(data, type, row) {
                        return data;
                    }
                },
                {
                    targets: 5,
                    data: 'kategori_nama',
                    searchable: true,
                    orderable: true,
                    className: 'text-start',
                    render: function(data, type, row) {
                        let html = `
                            <span >${data} </span><br>
                            <span class="text-secondary fw-bold d-block fs-7 text-start">Tingkat : ${listBobot[row.kategori_bobot - row.bobotUpper-1]} </span>

                        `;
                        return html;
                    }
                },
                {
                    targets: 6,
                    data: 'verify_by',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        const dateObj = new Date(row.verify_at.date);
                        const formatter1 = new Intl.DateTimeFormat('id-ID', {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit',

                            hour12: false
                        });

                        var formattedDate = formatter1.format(dateObj);

                        var html = `
                            <div class="d-flex align-items-center">
                                <div class="d-flex justify-content-start flex-column">
                                    <span class="text-dark fw-bolder fs-6 text-start">${row.verifikator_staff_nama} <span class="text-muted fw-medium text-muted ">(staff)</span></span>
                                    <span class="text-muted fw-bold text-muted d-block fs-7 text-start">${formattedDate}</span>
                                </div>
                            </div>                                
                        `;
                        return html;
                    }
                },
                {
                    targets: 7,
                    data: 'status',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        let html = `
                            <span class="badge text-bg-primary">${data==2?'Proses Sanksi':'Belum Diverifikasi' } </span>
                        `;
                        return html;
                    }
                },
                {
                    targets: 8,
                    data: 'id',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        var btnColor = row.tugas == null ? 'btn-secondary' : 'btn-success';
                        var disabled = (isAdmin == 1) ? 'disabled' : '';
                        let html = `
                            <button class="btn ${btnColor} btn-sm ${disabled}" type="button" onclick="onSanksi(${data}, ${row.pelaku_id})">
                                <i class="fa fa-edit"></i>
                                Buat Sanksi    
                            </button>
                        `;
                        return html;
                    }
                },
                {
                    targets: 9,
                    data: 'sanksi_status',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        var btnColor = 1;
                        if (data == 1) {
                            btnColor = 'btn-secondary';
                        }
                        if (data == 2) {
                            btnColor = 'btn-primary';
                        }
                        if (data == 3) {
                            btnColor = 'btn-warning';
                        }
                        if (data == 4) {
                            btnColor = 'btn-success disabled';
                        }
                        if (data == null || isAdmin == 1) {
                            btnColor = 'disabled';
                        }

                        let html = `
                            <button class="btn ${btnColor} btn-sm" type="button" onclick="onVerifikasiSanksi(${row.sanksi_id})">
                                <i class="fa fa-check"></i>
                                Verifikasi Sanksi    
                            </button>
                        `;
                        return html;
                    }
                }
            ],
        });
    };

    onVerifikasiSanksi = (id) => {
        $('#file_path').attr('href', '').html("");

        $.ajax({
            url: '/tataTertib/system/sanksi-pelanggaran.php',
            data: {
                action: 'getById',
                id: id
            },
            type: 'POST',
            success: (data) => {
                var data = JSON.parse(data);

                $('#id_sanksi').val(data.id);
                $('#id_mhs').val(data.pelanggaran_pelaku_id);
                $('#id_pelanggaran').val(data.pelanggaran_id);
                $('#status').val(data.status);
                $('#v_tugas').val(data.tugas);
                $('#v_keterangan').val(data.keterangan);
                $('#v_deadline_date').val(data.deadline_date);
                $('#v_deadline_time').val(data.deadline_time);
                $('#v_verifikator_id').val(data.pelanggaran_verify_by);
                $('#v_komentar').val(data.komentar);

                if (data.deadline_date && data.deadline_time) {
                    const deadlineDateTime = moment(`${data.deadline_date}T${data.deadline_time}`);
                    const now = moment(); // Waktu sekarang

                    if (deadlineDateTime.isAfter(now)) {
                        // Jika deadline di masa depan
                        $('#v_terlambat').text('Deadline  ' + deadlineDateTime.fromNow()).addClass('text-muted');
                    } else {
                        $('#v_terlambat').text('Overdue ' + deadlineDateTime.fromNow()).removeClass('text-muted');
                        // Jika deadline telah lewat
                    }
                }

                if (data.file_upload.id) {
                    $('#v_file_path').attr('href', data.file_upload.path).html(data.file_upload.file_name);
                    $('#v_file_path').attr('href', data.file_upload.path).html(data.file_upload.file_name);
                } else {
                    $('#v_terlambat').text("");
                }

                if (data.status == 4) {
                    $('.footer-form').addClass('d-none');
                } else {
                    $('.footer-form').removeClass('d-none');
                }
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })
        $('#modal_verifikasi').modal('show');
    }


    onSanksi = (id, mhsId) => {
        onReset();
        $.ajax({
            url: '/tataTertib/system/sanksi-pelanggaran.php',
            data: {
                action: 'getByPelanggaran',
                id: id
            },
            type: 'POST',
            success: (data) => {
                var data = JSON.parse(data);
                console.log(data[0]);
                if (data[0] && data[0].id) {
                    $('#id').val(data[0].id);
                    $('#keterangan').val(data[0].keterangan);
                    $('#tugas').val(data[0].tugas);
                    $('#deadline_date').val(data[0].deadline_date);
                    $('#deadline_time').val(data[0].deadline_time);
                }
                $('#pelanggaran_id').val(data.pelanggaran.id);
                $('#mhs_id').val(data.pelanggaran.pelaku_id);
                $('#pelanggaran_keterangan').html(data.pelanggaran.keterangan);
                $('#pelanggaran_kategori_nama').val(data.pelanggaran.kategori_nama);
                $('#kategori_bobot').val(data.pelanggaran.kategori_bobot + data.pelanggaran.bobotUpper);
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })

        $('#modal_form').modal('show');
    }


    onReset = () => {
        $('#id').val('');
        $('#keterangan').val('');
        $('#tugas').val('');
        $('#pelanggaran_id').val('');
        $('#mhs_id').val('');
        $('#pelanggaran_keterangan').html('');
        $('#pelanggaran_kategori_nama').val('');
        $('#kategori_bobot').val('');
        $('#deadline_date').val('');
        $('#deadline_time').val('');
    }

    onVerification = (status) => {
        onConfirm(status == 3 ? "Data akan disimpan sebagai revisi dan notifikasi akan dikirimkan kepada yang bersangkutan." : "Data tugas sanksi akan disetujui dan disimpan di database.", (result) => {
            if (result.isConfirmed) {
                const form = $('#form_approval-sanksi').get(0);
                let formData = new FormData(form);
                formData.append('status', status);
                formData.append('action', 'approvalSanksi');
                $.ajax({
                    url: '/tataTertib/system/list-pelanggaran.php',
                    data: formData,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    success: (data) => {
                        if (data == 1) {
                            $('#modal_verifikasi').modal('hide');

                            $('#keterangan_revisi').html('');
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
            } else {
                $('#modal_verifikasi').modal('hide');
                onAlert("Gagal !", "Data gagal tersimpan. Silahkan hubungi Administrator.", "error");
            }
        });
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
        const form = $('#form_list-pelanggaran').get(0);
        let formData = new FormData(form);
        formData.append('action', 'storeSanksi');
        $.ajax({
            url: '/tataTertib/system/list-pelanggaran.php',
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
            url: '/tataTertib/system/list-pelanggaran.php',
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
                    html += '<option value="' + data[i]['user_id'] + '">' + data[i]['nim'] + ' - ' + data[i]['nama'] + ' || ' + data[i]['prodi_nama'] + ' - ' + data[i]['kelas_nama'] + '</option>';
                }

                $('#pelaku_id').html(html);
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })
    }
</script>