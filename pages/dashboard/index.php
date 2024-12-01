<style>
    .stat-warning {
        background-color: #fff0c2;
    }

    .stat-danger {
        background-color: #edd3d6;
    }
</style>
<h1 class="h3 mb-3"> Dashboard</h1>

<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Mahasiswa</h5>
                            </div>

                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-graduation-cap align-middle">
                                        <path d="M22 7l-10-5L2 7l10 5 10-5z"></path>
                                        <path d="M6 10v4c0 3.3 5 5 6 5s6-1.7 6-5v-4"></path>
                                        <line x1="12" y1="21" x2="12" y2="17"></line>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <span class="mt-1 fw-bold count-mahasiswa" style="font-size: 48px;">0 </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Dosen</h5>
                            </div>

                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="7" r="4"></circle>
                                        <path d="M5 22v-5c0-2 1-4 3-5l4-3 4 3c2 1 3 3 3 5v5"></path>
                                        <path d="M8 22h8"></path>
                                        <path d="M9 14l3 3 3-3"></path>
                                        <path d="M12 17v5"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <span class="mt-1 fw-bold count-dosen" style="font-size: 48px;">0</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Aduan</h5>
                            </div>

                            <div class="col-auto">
                                <div class="stat stat-warning text-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <!-- Segitiga -->
                                        <path d="M12 2l10 18H2L12 2z"></path>

                                        <!-- Tanda Seru -->
                                        <line x1="12" y1="9" x2="12" y2="13"></line>
                                        <circle cx="12" cy="17" r="1"></circle>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <span class="mt-1 fw-bold count-aduan" style="font-size: 48px;">0</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Pelanggaran</h5>
                            </div>

                            <div class="col-auto">
                                <div class="stat stat-danger text-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <!-- Segitiga -->
                                        <path d="M12 2l10 18H2L12 2z"></path>

                                        <!-- Tanda Seru -->
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
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col mt-0">
                        <h5 class="card-title">Pelanggaran Terbanyak</h5>
                    </div>
                </div>
                <table class="table table-hover bg-light">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Mahasiswa</td>
                            <td>Asal </td>
                            <td>Angkatan</td>
                            <td>Poin</td>
                        </tr>
                    </thead>
                    <tbody id="list-pelanggaran">
                        <tr>
                            <td colspan="5">
                                <div class="d-flex justify-content-center">
                                    Tidak ada data
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col mt-0">
                        <h5 class="card-title">Aduan Terbaru</h5>
                    </div>
                </div>

                <div id="listAduan">
                    <div class="bg-light mb-3 rounded">
                        <div class="p-3 d-flex justify-content-center ">
                            <span class=" text-secondary fw-bold">Tidak ada data</span>
                        </div>
                    </div>
                </div>
               
                
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col mt-0">
                        <h5 class="card-title">Pelanggaran Terbaru</h5>
                    </div>
                </div>

                <div id="listPelanggaran">
                    <div class="bg-light mb-3 rounded">
                        <div class="p-3 d-flex justify-content-center ">
                            <span class=" text-secondary fw-bold">Tidak ada data</span>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<script>
    $(() => {
        moment.locale('id'); 

        getCount();
        getListMhs();
        getListAduan();
        getListPelanggaran();
    });

    getCount = () => {
        $.ajax({
            url: "system/dashboard.php",
            method: "POST",
            data: {
                action: "getCount"
            },
            success: (data) => {
                data = JSON.parse(data);
                $(".count-mahasiswa").text(data.countMahasiswa);
                $(".count-dosen").text(data.countDosen);
                $(".count-aduan").text(data.countAduan);
                $(".count-pelanggaran").text(data.countPelanggaran);
            }
        });
    }

    getListMhs = () => {
        $("#list-pelanggaran").html("");

        $.ajax({
            url: "system/dashboard.php",
            method: "POST",
            data: {
                action: "getListMhs"
            },
            success: (data) => {
                data = JSON.parse(data);
                var html = '';

                for (i = 0; i < data.length; i++) {
                    html += '<tr>';
                    html += '<td>' + (i + 1) + '</td>';
                    html += '<td><b>NIM. ' + data[i]['nim'] + '</b><br>' + data[i]['nama'] + '</td>';
                    html += '<td> <b>' + data[i]['jurusan_nama'] + '</b> <br> ' + data[i]['prodi_nama'] + '</td>';
                    html += '<td>' + data[i]['angkatan'] + '</td>';
                    html += '<td><b>' + data[i]['poin'] + '</b></td>';
                    html += '</tr>';
                }

                if (data.length == 0) {
                    html += `
                        <tr>
                            <td colspan="5">
                                <div class="d-flex justify-content-center">
                                    Tidak ada data
                                </div>
                            </td>
                        </tr>
                    `;
                }
                $("#list-pelanggaran").html(html);

            }
        });

        getListAduan = () => {
            $.ajax({
                url: "system/dashboard.php",
                method: "POST",
                data: {
                    action: "getListAduan"
                },
                success: (data) => {
                    data = JSON.parse(data);
                    var html = '';

                    for (i = 0; i < data.length; i++) {

                        
                        html += '<div class="bg-light mb-3 rounded">';
                        html += '<div class="p-3">';
                        html += '<span class="mt-2 text-secondary fw-bold">' + data[i]['terlapor_mahasiswa_nama'] + ' - NIM. ' + data[i]['terlapor_mahasiswa_nim'] + '</span><br>';
                        html += '<span class="mt-2 text-secondary "> <i class="fa fa-clock"></i> ' +
                            moment(data[i]['tanggal']['date']).format('DD MMMM YYYY') 
                            + '</span><br>';
                        html += '<span class="text-secondary">' + data[i]['keterangan'] ??  + '</span>';
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

                    $("#listAduan").html(html);
                }
            });
        }

        getListPelanggaran = () => {
            $.ajax({
                url: "system/dashboard.php",
                method: "POST",
                data: {
                    action: "getListPelanggaran"
                },
                success: (data) => {
                    data = JSON.parse(data);

                    var html = '';

                    for (i = 0; i < data.length; i++) {
                        var status = "";
                        if (data[i]['status'] == 2) { 
                            status = '<span class="badge text-bg-warning text-white ms-3">Proses</span>';
                        }
                        if (data[i]['status'] == 3) { 
                            status = '<span class="badge text-bg-success text-white ms-3">Selesai</span>';
                        }

                        html += '<div class="bg-light mb-3 rounded">';
                        html += '<div class="p-3">';
                        html += '<span class="mt-2 text-secondary fw-bold">' + data[i]['terlapor_mahasiswa_nama'] + ' - NIM. ' + data[i]['terlapor_mahasiswa_nim'] + '</span><br>';
                        html += '<span class="mt-2 text-secondary "> <i class="fa fa-clock"></i> ' +
                            moment(data[i]['tanggal']['date']).format('DD MMMM YYYY') 
                            + '</span><br>';
                        html += '<span class="text-secondary">' + data[i]['kategori_nama'] + 
                            ' <span class="fw-bold text-danger">' + data[i]['kategori_bobot'] + ' poin</span>'

                           + status+  

                        '</span>';
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
    }
</script>