<?php 
    $user = isset($_GET['user']) ? $_GET['user'] : '';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Penerima</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-auto">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari" id="cari">
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="table-responsive" style="height: 400px">
                                <table class="table table-sm table-striped table-hover caption-top">
                                    <caption>Total Penerima: <span id="jumlah"></span></caption>
                                    <thead >
                                        <th class="col">#</th>
                                        <th class="col">Penerima</th>
                                        <th class="col">Perusahaan</th>
                                        <th class="col">Bagian</th>
                                        <th class="col">npwp</th>
                                        <th class="col">Alamat 1</th>
                                        <th class="col">Alamat 2</th>
                                        <th class="col">Alamat 3</th>
                                        <th class="col">Kode Bank IDR</th>
                                        <th class="col">Bank IDR</th>
                                        <th class="col">No. Rekening IDR</th>
                                        <th class="col">Kode Bank USD</th>
                                        <th class="col">No. Rekening USD</th>
                                        <th class="col">eMail</th>

                                        <th class="col" colspan="2">Aksi</th>
                                    </thead>
                                    <tbody id="tbl-penerima"></tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addPenerima">Tambah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="delPenerima">Hapus</button>
                    <button type="button" class="btn btn-secondary btn-sm" id="backto">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#backto').on('click', function() {
        window.history.go(-1)
    })

    $('#delPenerima').on('click', function() {
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih Penerima terlebih dahulu',
                'warning'
            )
        }else{
           $('#tbl-penerima input[type=checkbox]:checked').each(function() {
                var row = $(this).val()
                array.push(row)
           })

           Swal.fire({
                title: 'Kamu yakin?',
                text: 'Sebanyak '+totals+' data ini akan dihapus secara permanen',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus',
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: url_api + '/penerima/delete',
                        type: 'post',
                        data: {
                            npwp_id: array
                        },
                        success: function(res) {
                           Swal.fire(res.title, res.message, res.status);
                           if(res.status == 'success') location.reload()
                        }
                    })
                }else{
                    Swal.fire('Batal', 'Data batal dihapus', 'error')
                }
            })
        }
    })

    $('#addPenerima').on('click', function() {
        // to add Datasource
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/kea/formPenerima.php',
            type: 'get',
            data: {user:user},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
        
    })

    function show_tables() {
        $.ajax({
            url: url_api + '/penerima',
            type: 'get',
            success: function(res) {
                if(res.status == 'success') {
                   var data = res.data
                    $('#jumlah').html(data.length)
                    var tb = ''
                    data.forEach(function(items, index) {
                        var npwp = items.npwp == null ? '-' : items.npwp
                        var alamat_1 = items.alamat_1 == null ? '-' : items.alamat_1
                        var alamat_2 = items.alamat_2 == null ? '-' : items.alamat_2
                        var alamat_3 = items.alamat_3 == null ? '-' : items.alamat_3
                        tb = tb + `<tr>
                             <td class="col-1"><input type="checkbox" class="form-check-input  checked" value="${items.npwp_id}"> </td>
                            <td><b>${items.penerima}</b></td>
                            <td>${items.Perusahaan}</td>
                            <td>${items.isPerson}</td>
                            <td>${npwp}</td>
                            <td><b>${alamat_1}</b></td>
                            <td>${alamat_2}</td>
                            <td>${alamat_3}</td>
                            <td>${items.KodeBankIDR}</td>
                            <td>${items.NoRek}</td>
                            <td><b>${items.Bank}</b></td>
                            <td>${items.KodeBankUSD}</td>
                            <td>${items.BankUSD}</td>
                            <td>${items.mail}</td>
                            <td><button type="button" class="btn btn-sm btn-info" onclick="edit_data(${items.npwp_id})">Edit</button></td>
                            </tr>`
                    })
                }

                $('#tbl-penerima').html(tb)
            }
        })
    }

    $(document).ready(function() {
        show_tables()
    })

    function del_data(id) {
        Swal.fire('deleted', 'Hapus', 'success')
    }

    function edit_data(id) {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/kea/formPenerima.php',
            type: 'get',
            data: {user:user, id: id},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
    }



</script>