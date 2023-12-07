<?php 
    $user = isset($_GET['user']) ? $_GET['user'] : '';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Direktorat</h4>
                </div>
                <main class="card-body mt-3">
                    <div class="row">
                        <div class="col-auto">
                            <select class="form-select form-select-sm" id="show-orgz"></select>
                        </div>
                        <div class="col-auto">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari" id="cari">
                        </div>
                        
                        <div class="col-md-12">
                            <article class="table-responsive" style="height: 400px">
                            <caption class="text-muted text-center">Total: <span id="total">0</span></caption>
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <th class="col">#</th>
                                        <th class="col">Nama</th>
                                        <th class="col">Kode</th>
                                        <th class="col">Organisasi</th>
                                    </thead>
                                    <tbody id="tbl-dirs"></tbody>
                                </table>
                            </article>
                        </div>
                        
                    </div>
                </main>
                
                <footer class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addDirs">Tambah</button>
                    <button type="button" class="btn btn-info btn-sm" id="updateDirs">Ubah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="deleteDirs">Hapus</button>
                    <button type="button" class="btn btn-secondary btn-sm" id="backto">Kembali</button>
                    <button type="button" class="btn btn-success btn-sm" id="exportDirs">Export to Excel</button>
                </footer>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#backto').on('click', function() {
        location.href = 'index.php'
    })

    $('#addDirs').on('click', function() {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/hrd/formDirs.php',
            type: 'get',
            data: {user:user},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
    })

    $('#exportDirs').on('click', function() {
        Swal.fire('Oooops', 'Feature ini masih dalam maintenane', 'warning')
    })

    $('#updateDirs').on('click', function() {
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih direktorat terlebih dahulu',
                'warning'
            )
        }else if(totals > 1){
            Swal.fire(
                'Peringatan',
                'Harap pilih hanya satu direktorat',
                'warning'
            )
        }else{
            var value = document.querySelector('.checked:checked').value
            var user = `<?php echo $user;?>`;
            $.ajax({
                url: '../components/hrd/formDirs.php',
                type: 'get',
                data: {user:user, id: value},
                success: function(res) {
                    $('#content-user').html(res)
                }
            })
        }
    })

    $('#deleteDirs').on('click', function() {
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih direktorat terlebih dahulu',
                'warning'
            )
        }else {
            $('#tbl-dirs input[type=checkbox]:checked').each(function() {
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
                        url: url_api + '/dir/delete',
                        type: 'post',
                        data: {
                            id: array
                        },
                        success: function(res){
                            Swal.fire(res.title, res.message, res.status)
                            if(res.status == 'success') show_table(0, '')
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            if(xhr.status == 500) Swal.fire('Ooops', 'Sepertinya data yang kamu ingin hapus merupakan data primary. Silahkan cek kembali sebelum menghapus data ini. ', 'error')
                        }
                    })
                }else{
                    Swal.fire('Batal', 'Data batal hapus', 'warning')
                }
            })
        }
    })


    $('#cari').on('keyup', function() {
        var query = $(this).val()
        var orgz = $('#show-orgz').val()
        show_table(orgz, query)
    })

    $('#show-orgz').on('change', function() {
        var query = $('#cari').val()
        var orgz = $(this).val()
        show_table(orgz, query)
    })

    function show_table(orgz, query) {
        var total = 0
        var tbody = ''
        $.ajax({
            url: url_api + '/dir/search',
            type: 'post',
            data: {
                orgz: orgz,
                query: query
            },
            success: function(res) {
                total = res.data == undefined ? 0 : res.data.length
                if(res.status == 'success') {
                    
                    var data = res.data
                    data.forEach(function(row, index) {
                        tbody = tbody + `
                            <tr>
                                <td class="col-1"><input type="checkbox" class="form-check-input  checked" value="${row.id}"> </td>
                                <td>${row.name}</td>
                                <td>${row.code}</td>
                                <td>${row.orgName}</td>

                            </tr>
                        `
                   })
                }else {
                    tbody = '<tr><td colspan="8" class="text-center">Data tidak ditemukan</td></tr>'
                }

                $('#total').text(total)
                $('#tbl-dirs').html(tbody)
                
            }
        })
    }

    $(document).ready(function() {
        var query = $('#cari').val()
        document.title = 'Data Direktorat'
        show_table(0, '')
        $.ajax({
            url: url_api + '/orgz/all',
            type: 'get',
            success: function(res) {
                var opt = ''
                if(res.status == 'success') {
                    opt = '<option value="0">Semua Organisasi</option>'
                    var data = res.data 
                    data.forEach(function(row, index) {
                        opt = opt + `<option value="${row.id}">${row.name}</option>`
                    })
                }else {
                    opt = '<option>Tidak ada data organisasi</option>'
                }

                $('#show-orgz').html(opt)
            }
        })
        
    })



</script>