<?php $user = isset($_GET['user']) ? $_GET['user'] : '';?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Nomor Rekening</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-auto">
                            <select class="form-select form-select-sm" id="datasource"></select>
                        </div>
                        <div class="col-auto">
                            <select class="form-select form-select-sm" id="kodebank"></select>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="table-responsive" style="height: 400px">
                                <table class="table table-sm table-striped table-hover">
                                    <thead>
                                        <th class="col">#</th>
                                        <th class="col">Kode Bank</th>
                                        <th class="col">Nama Bank</th>
                                        <th class="col">Branch</th>
                                        <th class="col">Nomor rekening</th>
                                        <th class="col">Mata Uang</th>
                                        <th class="col">Data Source</th>
                                        <th class="col">Mata Anggaran</th>
                                        <th class="col">Saldo</th>
                                        <th class="col" colspan="2">Aksi</th>
                                    </thead>
                                    <tbody id="tbl-rekening"></tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addRekening">Tambah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="deleteRekening">Hapus</button>
                    <button type="button" class="btn btn-secondary btn-sm" id="backto">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>