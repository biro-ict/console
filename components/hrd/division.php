<?php 
    $user = isset($_GET['user']) ? $_GET['user'] : '';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Divisi</h4>
                </div>
                <main class="card-body mt-3">
                    <div class="row">
                        <div class="col-auto mb-3">
                            <select class="form-select form-select-sm" id="show-branch"></select>
                        </div>
                        <div class="col-auto mb-3">
                            <select class="form-select form-select-sm" id="show-depts"></select>
                        </div>
                        <div class="col-auto mb-3">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari" id="cari">
                        </div>
                        <content class="col-md-12 mb-3">
                            <div class="table-responsive" style="height: 400px">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <th class="col">#</th>
                                        <th class="col">Nama</th>
                                        <th class="col">Kode</th>
                                        <th class="col">Direc</th>
                                        <th class="col">Level</th>
                                        <th class="col">Departemen</th>
                                        <th class="col">Branch</th>
                                        <th class="col">Status</th>
                                        <th class="col" colspan="3">Aksi</th>
                                    </thead>
                                    <tbody id="tbl-dirs"></tbody>
                                </table>
                            </div>
                        </content>
                        
                    </div>
                </main>
                
                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addDepts">Tambah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="backto">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

