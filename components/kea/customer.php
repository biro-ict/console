<?php $user=isset($_GET['user']) ? $_GET['user'] : ''; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Customer</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-auto">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari berdasarkan Perusahaan" id="cari">
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive" style="height:400px">
                                <table class="table table-sm table-striped table-hover">
                                    <thead style="background: white; position: sticky; top: 0;box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);">
                                        <tr>
                                            <th>#</th>
                                            <th>Customer ID</th>
                                            <th>Kode Customer</th>
                                            <th>Alias</th>
                                            <th>Perusahaan</th>
                                            <th>NPWP</th>
                                            <th>Kontak Person</th>
                                            <th>Jabatan</th>
                                            <th>Telephone</th>
                                            <th>Kode C.O.A</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbl-customer"></tbody>
                                </table>
                            </div>
                            <caption>Total Customer: <span id="jumlah"></span></caption>
                        </div>
                    </div>
                </div>
                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addCustomer">Tambah</button>
                    <button type="button" class="btn btn-info btn-sm" id="updateCustomer">Ubah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="deleteCustomer">Hapus</button>
                    <button type="button" class="btn btn-secondary btn-sm" id="backto">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#backto').on('click', function(){
        window.location.go(-1)
    })

    $('#addCustomer').on('click', function() {

    })

    $('#updateCustomer').on('click', function() {

    })

    $('#deleteCustomer').on('click', function(){

    })

    function show_tables() {
        var cari = $('#cari').val()
        var tb = ''
        $.ajax({
            url: url_api + '/customer',
            type: 'post',
            data:{ cari: cari},
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data
                    $('#jumlah').html(data.length)
                    data.forEach(function(items, index) {
                        tb = tb + `
                            <tr>
                                <td class="col-1"><input type="checkbox" class="form-check-input  checked" value="${items.CustID}"></td>
                                <td>${items.CustID}</td>
                                <td>${items.DeviceID}</td>
                                <td>${items.KodePerusahaan}</td>
                                <td>${items.Perusahaan}</td>
                                <td>${items.npwp}</td>
                                <td>${items.KontakPerson}</td>
                                <td>${items.Jabatan}</td>
                                <td>${items.Telephone}</td>
                                <td>${items.MataAnggaran}</td>
                            </tr>
                        `
                    })

                }else {
                    $('#jumlah').html(data.length)
                    tb = tb + `<tr><td colspan="9" class="text-center">Data tidak ditemukan</td></tr>`
                }

                $('#tbl-customer').html(tb)
            }
        })
    }

    $('#cari').on('keyup', function() {
        show_tables()
    })

    $(document).ready(function() {
        show_tables();
    })
</script>