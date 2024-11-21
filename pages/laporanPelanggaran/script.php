<script>
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
            ajax: {
                url: '/tataTertib/system/laporan-pelanggaran.php',
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
                            <span class="text-secondary fw-bold d-block fs-7 text-start">Tingkat : ${row.kategori_bobot - row.bobotUpper} </span>
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
                        let formattedDate = "-"; // Default value jika data tidak ada
                        if (row.verify_at && row.verify_at.date) {
                            const dateObj = new Date(row.verify_at.date);
                            const formatter1 = new Intl.DateTimeFormat('id-ID', {
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: false
                            });
                            formattedDate = formatter1.format(dateObj);
                        }

                        const verifikatorNama = row.verifikator_staff_nama || "-"; // Default jika nama verifikator tidak ada

                        const html = `
                            <div class="d-flex align-items-center">
                                <div class="d-flex justify-content-start flex-column">
                                    <span class="text-dark fw-bolder fs-6 text-start">${verifikatorNama} <span class="text-muted fw-medium text-muted ">(staff)</span></span>
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
                            <span class="badge text-bg-success text-white">Selesai</span>
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
                        let html = `
                            <span class="badge text-bg-success text-white">Disetujui</span>
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

                        let html = `
                            <button class="btn btn-outline-info btn-sm" type="button" onclick="onDetail(${row.sanksi_id})">
                                <i class="fa fa-eye"></i>
                                <br> <span style="font-size: 8px">Detail Sanksi</span>
                            </button>
                        `;
                        return html;
                    }
                }
            ],
        });
    };

    onDetail = (id) => {
        $('#file_path').attr('href', '');

        $.ajax({
            url: '/tataTertib/system/sanksi-pelanggaran.php',
            data: {
                action: 'getById',
                id: id
            },
            type: 'POST',
            success: (data) => {
                var data = JSON.parse(data);
                console.log(data);
                $('#id_sanksi').val(data.id);
                $('#id_mhs').val(data.pelanggaran_pelaku_id);
                $('#id_pelanggaran').val(data.pelanggaran_id);
                $('#status').val(data.status);
                $('#tugas').val(data.tugas);
                $('#keterangan').val(data.keterangan);
                $('#deadline_date').val(data.deadline_date);
                $('#deadline_time').val(data.deadline_time);
                $('#verifikator_id').val(data.pelanggaran_verify_by);
                $('#komentar').val(data.komentar);
                if (data.updated_at && data.updated_at.date) {
                    const formattedDate = moment(data.updated_at.date).format('D MMM YYYY');
                    $('#verifikasi_date').val(formattedDate);
                } else {
                    // Jika data tidak ada, beri nilai default
                    $('#verifikasi_date').val('-');
                }
               
                if (data.file_upload.id) {
                    $('#file_path').attr('href', data.file_upload.path);
                }

            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })
        $('#modal_verifikasi').modal('show');
    }
</script>