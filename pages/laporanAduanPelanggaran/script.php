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
            lengthMenu: [5, 10, 25, 50, 100],
        language: {
            lengthMenu: "Show _MENU_ items per page"
        },
            ajax: {
                url: '/tataTertib/system/laporan-aduan-pelanggaran.php',
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

                        let html = ``;
                        if (row.status == 3) {

                            html = `
                                <button class="btn btn-success btn-sm fs-5" type="button" data-bs-toggle="tooltip"  title="Disetujui">
                                    <i class="fa fa-check" ></i>
                                </button>
                            `;
                        } else {
                            html = `
                                <button class="btn btn-danger btn-sm fs-5" type="button" title="Ditolak">
                                    <i class="fa fa-times" ></i>
                                </button>
                            `;
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
                        if (row.verify_at && row.verify_at.date) {
                            const rawDateString = row.verify_at.date; 
                            var formattedDate = moment(rawDateString).format('DD MMM YYYY HH:mm');

                            if (!moment(rawDateString).isValid()) {
                                var formattedDate = '-';
                            }
                        } else {
                            var formattedDate = '-'; 
                        }
                        let html = `
                            <div>
                                <span>Diverifikasi Oleh : ${row.verifikator_staff_nama} (staff)</span><br>
                                <span>Tanggal verifikasi : ${formattedDate}</span>
                            </div>
                        `;
                        return html;
                    }
                }
            ],
        });
    };
</script>