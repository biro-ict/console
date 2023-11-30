<?php $user = isset($_GET['user']) ? $_GET['user'] : '';?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Kode Bank</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-auto">
                            <input class="form-control form-control-sm" placeholder="Cari berdasarkan Nama" id="cari">
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="table-responsive" style="height: 400px">
                                <table class="table table-sm table-striped table-hover">
                                    <thead>
                                        <th class="col">#</th>
                                        <th class="col">Kode Bank</th>
                                        <th class="col">Nama Bank</th>
                                        <th class="col">Kode Online</th>
                                        <th class="col">Kode Kliring</th>
                                        <th class="col">KodeRTGS</th>
                                    </thead>
                                    <tbody id="tbl-bank"></tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addBank">Tambah</button>
                    <button type="button" class="btn btn-info btn-sm" id="updateBank">Ubah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="deleteBank">Hapus</button>
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

    $("#addBank").on('click', function() {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/kea/formBank.php',
            type: 'get',
            data: {user:user},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
    })


    
    $('#updateBank').on('click', function() {
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih Kode Bank terlebih dahulu',
                'warning'
            )
        }else if(totals > 1){
            Swal.fire(
                'Peringatan',
                'Harap pilih hanya satu Kode Bank',
                'warning'
            )
        }else{
            var value = document.querySelector('.checked:checked').value
            var user = `<?php echo $user;?>`;
            $.ajax({
                url: '../components/kea/formBank.php',
                type: 'get',
                data: {user:user, id: value},
                success: function(res) {
                    $('#content-user').html(res)
                }
            })
        }
    })

    $('#deleteBank').on('click', function() {
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih Kode Bank terlebih dahulu',
                'warning'
            )
        }else {
            $('#tbl-bank input[type=checkbox]:checked').each(function() {
                var row = $(this).val()
                array.push(row)
           })

            Swal.fire({
                title: 'Kamu yakin?',
                text: 'Data akan terhapus secara permanen',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: url_api + '/bank/delete',
                        type: 'post',
                        data: {
                            KodeBank: array
                        },
                        success: function(res){
                            Swal.fire(res.title, res.message, res.status)
                            if(res.status == 'success') show_tables()
                        }
                    })
                }else{
                    Swal.fire('Batal', 'Data batal hapus', 'warning')
                }
            })
        }
    })

    function show_tables() {
        var tb = ''
        $.ajax({
            url: url_api + '/bank',
            type: 'post',
            data: {
                cari: $('#cari').val()
            },
            success: function(res) {
                
                if(res.status=='success') {
                    var data = res.data
                    data.forEach(function(items, index) {
                        tb = tb + `
                            <tr>
                            <td class="col-1"><input type="checkbox" class="form-check-input checked" value="${items.KodeBank}"></td>
                            <td>${items.KodeBank}</td>
                            <td>${items.NamaBank}</td>
                            <td>${items.KodeOnline}</td>
                            <td>${items.KodeKliring}</td>
                            <td>${items.KodeRTGS}</td>
                            </tr>
                        `;
                    })
                }else{
                    tb = tb + `<tr><td colspan="6" style="text-align: center">Data tidak ditemukan</td></tr>`
                }
                $('#tbl-bank').html(tb)
            }
        })
    }

    $(document).ready(function() {
        show_tables()
    })

    $('#cari').on('keyup', function() {
        show_tables()
    })
</script>