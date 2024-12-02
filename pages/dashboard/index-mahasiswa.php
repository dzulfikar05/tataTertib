<style>
    .stat-warning {
        background-color: #fff0c2;
    }

    .stat-danger {
        background-color: #edd3d6;
    }

    .stat-success {
        background-color: #C8E6C9;
    }
</style>
<h1 class="h3 mb-3"> Dashboard</h1>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-6">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Informasi Tata Tertib</h5>
                        <div id="listKategori" style="max-height: 350px; overflow-y: auto;">
                            <div class="bg-light p-3 mb-3 text-center rounded">Tidak ada data</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Buku Panduan</h5>
                        <div id="bukuPanduan">
                            <div class="bg-light p-3 text-center rounded">Tidak ada data</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Total Pelanggaran</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="stat text-danger stat-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 2l10 18H2L12 2z"></path>
                                            <line x1="12" y1="9" x2="12" y2="13"></line>
                                            <circle cx="12" cy="17" r="1"></circle>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <span class="mt-1 fw-bold count-pelanggaran" style="font-size: 48px;">0</span>
                        </div>
                    </div>


                </div>
                <!-- Pelanggaran Card -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Total Tugas Selesai</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="stat text-success stat-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <!-- Clipboard -->
                                            <path d="M9 2h6a2 2 0 0 1 2 2v1H7V4a2 2 0 0 1 2-2z"></path>
                                            <rect x="3" y="6" width="18" height="16" rx="2" ry="2"></rect>

                                            <!-- Checkmark -->
                                            <path d="M9 13l2 2 4-4"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <span class="mt-1 fw-bold count-tugas-selesai" style="font-size: 48px;">0</span>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tugas Terbaru</h5>
                            <div id="listPelanggaran">
                                <div class="bg-light p-3 text-center rounded">Tidak ada data</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(() => {
        getCountStatMhs();
        getLatestTask();
        getKategori();
    })

    let listBobot = [5,4,3,2,1];

    getCountStatMhs = () => {
        $.ajax({
            url: "system/dashboard.php",
            method: "POST",
            data: {
                action: "getCountStatMhs"
            },
            success: (data) => {
                data = JSON.parse(data);

                $(".count-pelanggaran").text(data.totalPelanggaran);
                $(".count-tugas-selesai").text(data.resolvedPelanggaran);
            }
        });
    }

    getLatestTask = () => {
        $.ajax({
            url: "system/dashboard.php",
            method: "POST",
            data: {
                action: "getLatestTask"
            },
            success: (data) => {
                data = JSON.parse(data);
                var html = '';

                for (i = 0; i < data.length; i++) {
                    var colorDl = "d-none";
                    var status = "";
                    if (data[i]['status'] != 4) {
                        colorDl = "text-danger";
                    }

                    if (data[i]['status'] == 4) {
                        status = "<span class='badge text-bg-success text-white'>Belum Upload</span>";
                    }
                    if (data[i]['status'] == 3) {
                        colorDl = "d-none";
                        status = "<span class='badge text-bg-warning text-white'>Revisi</span>";
                    }

                    html += '<div class="bg-light mb-3 rounded">';
                    html += '<div class="p-3">';
                    html += '<span class="mt-2 text-secondary fw-bold">' + data[i]['tugas'] + '</span><br>';
                    html += '<span class="text-secondary">' + data[i]['keterangan'] ?? +'</span><br>';
                    html += '<br><span class="mt-2 ' + colorDl + ' fw-light "> <i class="fa fa-clock"></i> ' + data[i]['deadline_time'] + ' &nbsp;&nbsp;&nbsp;' +
                        moment(data[i]['deadline_date']['date']).format('DD MMMM YYYY') +
                        ' </span>' + status + '<br>';
                    html += '</div>';
                    html += '</div>';
                }

                if (data.length == 0) {
                    html += `
                                <div class="bg-light mb-3 rounded">
                                    <div class="p-3 d-flex justify-content-center ">
                                        <span class=" text-secondary fw-bold">Tidak ada data</span>
                                    </div>
                                </div>
                        `;
                }

                $("#listPelanggaran").html(html);
            }
        });
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

                var html = '';
                for (i = 0; i < data.length; i++) {
                    html += `
        <div class="card bg-light">
            <div class="card-body">
                <div class="row">
                    <span class="col-6 fw-bold fs-5">${data[i]['nama']}</span>
                    <div class="col-6">
                        <b class="fw-bold text-danger d-flex justify-content-end">Tingkat ${listBobot[data[i]['bobot']-1]}</b>
                    </div>
                </div>
                <p class="card-text">${data[i]['keterangan']}</p>
            </div>
        </div>`;

                }

                $('#listKategori').html(html);
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        })
    }
</script>