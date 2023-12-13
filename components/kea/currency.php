<?php $user=isset($_GET['user']) ? $_GET['user'] : ''; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Mata Uang</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-auto">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari" id="cari">
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive" style="height:400px">
                                <table class="table table-sm table-striped table-hover">
                                    <thead style="background: white; position: sticky; top: 0;box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);">
                                        <tr>
                                            <th>#</th>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Negara</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbl-currency"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addCurrency">Tambah</button>
                    <button type="button" class="btn btn-warning btn-sm" id="updateCurrency">Ubah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="deleteCurrency">Hapus</button>
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

    $('#addCurrency').on('click', function() {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/kea/formCurrency.php',
            type: 'get',
            data: {user:user},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
    })

    $('#updateCurrency').on('click', function() {
        var user = `<?php echo $user;?>`;
        var checkbox = document.querySelectorAll('.checked:checked')
        var totals = checkbox == undefined ? 0 : checkbox.length

        if(totals==0 || totals > 1) {
            Swal.fire('Peringatan', 'Harap pilih satu mata uang saja', 'warning')
        }else {
            var value = document.querySelector('.checked:checked').value
            $.ajax({
                url: '../components/kea/formCurrency.php',
                type: 'get',
                data: {user: user, id: value},
                success: function(res) {$('#content-user').html(res)}
            })
        }
    })

    $('#deleteCurrency').on('click', function() {
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message=''

        if(totals==0) {
            Swal.fire('Peringatan', 'Silahkan pilih Mata Uang terlebih dulu', 'warning')
        }else {
            $('#tbl-currency input[type=checkbox]:checked').each(function() {
                var row=$(this).parent().siblings(':first').text()
                array.push(row)
            })

            Swal.fire({
                title: 'Kamu yakin?',
                text: 'Data ini akan dihapus secara permanen',
                icon: 'warning',
                showCancelButton: true,
                CancelButtonText: 'Batal',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: url_api + '/currency/delete',
                        type: 'post',
                        data: {
                            currency: array
                        },
                        success: function(res){
                            Swal.fire(res.title, res.message, res.status)
                            if(res.status=='success') show_tables()
                        }
                    })
                }else{
                    Swal.fire('Batal', 'Data batal dihapus', 'warning')
                }
            })
        }
    })



    $('#cari').on('keyup', function() {
        show_tables()
    })


    function show_tables() {
        var cari=$('#cari').val()
        $.ajax({
            url: url_api + '/currency',
            type: 'post',
            data: {
                cari: cari, 
            },
            success: function(res) {
                var tb=''
                if(res.status=='success') {
                    var data=res.data
                    data.forEach(function(items, index) {
                        tb=tb+`
                            <tr>
                                <td class="col-1"><input type="checkbox" class="form-check-input checked" value="${items.MataUang}"></td>
                                <td>${items.MataUang}</td>
                                <td>${items.NamaMataUang}</td>
                                <td>${items.Negara}</td>    
                            </tr>
                        `
                    })
                }else{
                    tb=tb+`<tr><td colspan="4" class="text-center">Data tidak ditemukan</td></tr>`
                }
                $('#tbl-currency').html(tb)
            }
        })
    }

    $(document).ready(function() {
        show_tables()
    })
</script>