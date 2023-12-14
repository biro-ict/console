<?php 
    $user = isset($_GET['user']) ? $_GET['user'] : '';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Cabang</h4>
                </div>
                <main class="card-body mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <select class="form-select form-select-sm" id="show-orgz"></select>
                        </div>
                        <div class="col-auto">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari" id="cari">
                        </div>
                        <div class="col-md-12 mb-3">
                            <article class="table-responsive" style="height: 400px">
                                <table class="table table-striped table-hover">
                                    <thead style="background: white; position: sticky; top: 0;box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);">
                                        <th class="col">#</th>
                                        <th class="col">Nama</th>
                                        <th class="col">Kode</th>
                                        <th class="col">Organisasi</th>
                                    </thead>
                                    <tbody id="tbl-branch"></tbody>
                                </table>
                            </article>
                            <caption class="text-muted small-text">Total Cabang: <span id="total">0</span></caption>
                        </div>
                        
                    </div>
                </main>
                
                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addBranch">Tambah</button>
                    <button type="button" class="btn btn-warning btn-sm" id="updateBranch">Ubah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="deleteBranch">Hapus</button>
                    <button type="button" class="btn btn-secondary btn-sm" id="backto">Kembali</button>
                    <button type="button" class="btn btn-success btn-sm" id="exportBranch">Export to Excel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#backto').on('click', function() {
        location.href = 'index.php'
    })

    $('#exportBranch').on('click', function() {
        Swal.fire('Ooops', 'Feature ini masih dalam tahap pengembangan', 'warning')
    })


    $('#addBranch').on('click', function() {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/hrd/formBranch.php',
            type: 'get',
            data: {user:user},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
    })

    $('#updateBranch').on('click', function() {
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih cabang terlebih dahulu',
                'warning'
            )
        }else if(totals > 1){
            Swal.fire(
                'Peringatan',
                'Harap pilih hanya satu cabang',
                'warning'
            )
        }else{
            var value = document.querySelector('.checked:checked').value
            var user = `<?php echo $user;?>`;
            $.ajax({
                url: '../components/hrd/formBranch.php',
                type: 'get',
                data: {user:user, id: value},
                success: function(res) {
                    $('#content-user').html(res)
                }
            })
        }
    })

    $('#deleteBranch').on('click', function() {
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih cabang terlebih dahulu',
                'warning'
            )
        }else {
            $('#tbl-branch input[type=checkbox]:checked').each(function() {
                var row = $(this).val()
                array.push(row)
           })

           console.log(array)
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
                        url: url_api + '/branch/delete',
                        type: 'post',
                        data: {
                            id: array
                        },
                        success: function(res){
                            Swal.fire(res.title, res.message, res.status)
                            if(res.status == 'success') show_table(0, '')
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
        var tbody = ''
        var orgz = $('#show-orgz').val()
        var total = 0
        $.ajax({
            url: url_api + '/branch/search',
            type: 'post',
            data: {
                orgz: orgz,
                query: query
            },
            success: function(res) {
                total = res.data == undefined ? total : res.data.length
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
                    tbody = '<tr><td colspan="4" class="text-center">Data tidak ditemukan</td></tr>'
                }

                $('#total').text(total)
                $('#tbl-branch').html(tbody)
                
            }
        })
    }

    $(document).ready(function() {
        var query = $('#cari').val()
        document.title = 'Data Cabang'
        show_table(0, '')
        $.ajax({
            url: url_api + '/orgz/all',
            type: 'get',
            success: function(res) {
                var opt = ''
                if(res.status == 'success') {
                    var data = res.data
                    opt = `<option value="0">Semua Organisasi</option>`;
                    data.forEach(function(rows, index) {
                        opt = opt + `<option value="${rows.id}">${rows.name}</option>`
                    })
                }else{
                    opt = '<option>Data kosong</option>'
                }
                $('#show-orgz').html(opt)
            }
        })
    })
</script>