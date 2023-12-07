<?php $user = isset($_GET['user']) ? $_GET['user'] : '';?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Status Karyawan</h4>
                </div>
                <main class="card-body mt-3">
                        <div class="col-auto mb-3">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari" id="cari">
                        </div>
                        <content class="col-md-12 mb-3">
                            <div class="table-responsive" style="height: 400px">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <th class="col">#</th>
                                        <th class="col">Kode</th>
                                        <th class="col">Nama</th>
                                    </thead>
                                    <tbody id="tbl-grade"></tbody>
                                </table>
                            </div>
                        </content>
                    </div>
                </main>
                
                <footer class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addStatus">Tambah</button>
                    <button type="button" class="btn btn-info btn-sm" id="updateStatus">Ubah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="deleteStatus">Hapus</button>
                    <button type="button" class="btn btn-secondary btn-sm" id="backto">Kembali</button>
                </footer>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#backto').on('click', function() {
        location.history.go(-1)
    })

    $('#addStatus').on('click', function() {

    })

    $('#updateStatus').on('click', function() {

    })

    $('#deleteStatus').on('click', function() {


    })

    function show_tables() {

    } 

    $(document).ready(function() {
        show_tables()
    })

</script>