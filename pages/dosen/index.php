<div class="d-flex align-items-center w-100" style="background-color: #e9eff7; width: 105.5% !important; margin-left:-2.7%; margin-top: -47px; height: 68px; border: 1px #f2f2f2">
    <div class="mx-4 w-100 row">
        <div class="col-md-3 d-flex justify-content-start">
            <i class="fa fa-tasks text-primary me-4 fs-3" style="position: absolute; top:90px"></i>
            <span style="font-size: 14px; font-weight:600; margin-top: 2px" class="ms-5">Data Dosen</span>
        </div>
        <div class="col-md-9 d-flex justify-content-end">
            <button class="btn btn-primary btn-sm text-white" onclick="onAdd()"><i class="fa fa-calculator"></i> &nbsp;Tambah Data</button>

        </div>
    </div>
</div>
<div class="card mt-5">
    <div class="card-body">

        <table id="table" class="table table-bordered table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th width="40px">No</th>
                    <th>NIDN / Nama</th>
                    <th>Jurusan</th>
                    <th>No. HP</th>
                    <th>Jenis Kelamin</th>
                    <th width="120px">Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>




<?php include 'form.php'; ?>
<?php include 'script.php'; ?>