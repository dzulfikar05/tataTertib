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

    #pdf-controls {
        margin: 10px 0;
        gap: 5px;
    }

    #pdf-controls .btn {
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 14px;
    }

    #page-number {
        width: 90px;
        text-align: center;
    }

    .scrollable-container {
        width: 100%;
        height: 40vh;
        /* Adjust as needed for the desired height */
        overflow-x: auto;
        /* Enable horizontal scrolling */
        overflow-y: auto;
        /* Enable vertical scrolling */
        border: 1px solid #ddd;
        padding: 10px;
        background-color: #f9f9f9;
    }
</style>
<div class="alert-space">
</div>
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
                        <h5 class="card-title">Buku Pedoman Akademik</h5>
                        <div id="bukuPanduan">

                            <div id="pdf-controls" class="p-2 d-flex align-items-center bg-secondary text-white">
                                <button id="first-page" class="btn btn-secondary text-white">⏮</button>
                                <button id="prev-page" class="btn btn-secondary text-white">◀</button>
                                <span>Halaman</span>
                                <input id="page-number" type="number" value="1" min="1" class="form-control ">
                                <span id="total-pages">dari 0</span>
                                <button id="next-page" class="btn btn-secondary text-white">▶</button>
                                <button id="last-page" class="btn btn-secondary text-white">⏭</button>
                                <button id="zoom-in" class="btn btn-secondary text-white fw-light"><i class="fa fa-search-plus fw-light"></i></button>
                                <button id="zoom-out" class="btn btn-secondary text-white"><i class="fa fa-search-minus fw-light"></i></button>
                                <button id="download-pdf" class="btn btn-secondary ">💾 Unduh</button>
                            </div>
                            <div id="pdf-container" class="scrollable-container">
                                <canvas id="pdf-render"></canvas>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-md-6">
                    <a href="sanksi-pelanggaran.php" style="text-decoration: none;">
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
                    </a>
                </div>
                <!-- Pelanggaran Card -->
                <div class="col-md-6">
                    <a href="sanksi-pelanggaran.php" style="text-decoration: none;">
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
                    </a>
                </div>
                <div class="col-12">
                    <a href="sanksi-pelanggaran.php" style="text-decoration: none;">
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
        setBukuPedoman();
        
    })

    let listBobot = [5, 4, 3, 2, 1];

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

    setBukuPedoman = () => {
        // URL to the PDF file
        const url = "assets/D4_Sistem_Informasi_Bisnis_-_Pedoman_Akademik_2022-2023.pdf"; // Replace with the path to your PDF file

        let pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 1.0,
            canvas = document.getElementById('pdf-render'),
            ctx = canvas.getContext('2d');

        // Load PDF
        pdfjsLib.getDocument(url).promise.then(pdf => {
            pdfDoc = pdf;
            document.getElementById('total-pages').textContent = `dari ${pdf.numPages}`;
            renderPage(pageNum);
        });

        // Render halaman
        function renderPage(num) {
            pageRendering = true;

            pdfDoc.getPage(num).then(page => {
                const viewport = page.getViewport({
                    scale
                });

                // Adjust canvas size based on viewport
                canvas.width = viewport.width;
                canvas.height = viewport.height;

                const renderContext = {
                    canvasContext: ctx,
                    viewport: viewport,
                };
                const renderTask = page.render(renderContext);

                renderTask.promise.then(() => {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });
            document.getElementById('page-number').value = num;
        }

        document.getElementById('zoom-in').addEventListener('click', () => {
            if (scale < 2.0) { // Set a max zoom level
                scale += 0.1;
                renderPage(pageNum); // Re-render with the updated scale
            }
        });

        // Zoom Out button handler
        document.getElementById('zoom-out').addEventListener('click', () => {
            if (scale > 0.5) { // Set a min zoom level
                scale -= 0.1;
                renderPage(pageNum); // Re-render with the updated scale
            }
        });


        // Tombol navigasi
        document.getElementById('first-page').addEventListener('click', () => {
            if (pageNum !== 1) {
                pageNum = 1;
                renderPage(pageNum);
            }
        });
        document.getElementById('prev-page').addEventListener('click', () => {
            if (pageNum > 1) {
                pageNum--;
                renderPage(pageNum);
            }
        });
        document.getElementById('next-page').addEventListener('click', () => {
            if (pageNum < pdfDoc.numPages) {
                pageNum++;
                renderPage(pageNum);
            }
        });
        document.getElementById('last-page').addEventListener('click', () => {
            if (pageNum !== pdfDoc.numPages) {
                pageNum = pdfDoc.numPages;
                renderPage(pageNum);
            }
        });
        document.getElementById('page-number').addEventListener('change', (e) => {
            const newPage = parseInt(e.target.value);
            if (newPage > 0 && newPage <= pdfDoc.numPages) {
                pageNum = newPage;
                renderPage(pageNum);
            }
        });

        document.getElementById('download-pdf').addEventListener('click', () => {
            const link = document.createElement('a');
            link.href = url;
            link.download = 'document.pdf';
            link.click();
        });

    }
</script>