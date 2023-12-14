<?php  $user = isset($_GET['user']) ? $_GET['user'] : '';?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Departemen</h4>
                </div>
                <main class="card-body mt-3">
                    <div class="row">
                        <div class="col-auto">
                            <select class="form-select form-select-sm" id="show-dirs"></select>
                        </div>
                        <div class="col-auto">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari Berdasarkan Nama atau Kode" id="cari">
                        </div>
                        <div class="col-md-12">
                       
                            <article class="table-responsive" style="height: 400px">
                                <table class="table table-striped table-hover">
                                    <thead style="background: white; position: sticky; top: 0;box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);">
                                        <th class="col">#</th>
                                        <th class="col">Nama</th>
                                        <th class="col">Kode</th>
                                        <th class="col">Direktorat</th>
                                        <th class="col">Divisi</th>
                                    </thead>
                                    <tbody id="tbl-depts"></tbody>
                                </table>
                            </article>
                            <caption class="text-muted">Total: <span id="total">0</span></caption>
                        </div>
                        
                    </div>
                </main>
                
                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addDepts">Tambah</button>
                    <button type="button" class="btn btn-warning btn-sm" id="updateDepts">Ubah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="deleteDepts">Hapus</button>
                    <button type="button" class="btn btn-secondary btn-sm" id="backto">Kembali</button>
                    <button type="button" class="btn btn-success btn-sm" id="exportDepts">Export To Excel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#exportDepts').on('click', function() {
        Swal.fire('Oooops', 'Feature ini masih dalam tahap maintenance', 'warning')
    })

    $('#backto').on('click', function() {
        location.href = 'index.php'
    })

    $('#addDepts').on('click', function() {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/hrd/formDepts.php',
            type: 'get',
            data: {user:user},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
    })

    $('#updateDepts').on('click', function() {
        var user = `<?php echo $user;?>`;
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih departemen terlebih dahulu',
                'warning'
            )
        }else if(totals > 1){
            Swal.fire(
                'Peringatan',
                'Harap pilih hanya satu departemen',
                'warning'
            )
        }else{
            var value = document.querySelector('.checked:checked').value
            var user = `<?php echo $user;?>`;
            $.ajax({
                url: '../components/hrd/formDepts.php',
                type: 'get',
                data: {user:user, id: value},
                success: function(res) {
                    $('#content-user').html(res)
                }
            })
        }
    })


    $('#deleteDepts').on('click', function() {
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
            $('#tbl-depts input[type=checkbox]:checked').each(function() {
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
                        url: url_api + '/depts/delete',
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
        var dirs = $('#show-dirs').val()
        show_table(dirs, query)
    })

    $('#show-dirs').on('change', function() {
        var query = $('#cari').val()
        var dirs = $(this).val()
        show_table(dirs, query)
    })

    function show_table(dirs, query) {
        var total = 0
        var tbody = ''
        $.ajax({
            url: url_api + '/depts/search',
            type: 'post',
            data: {
                dirs: dirs,
                query: query
            },
            success: function(res) {
                total = res.data ==  undefined ? 0 : res.data.length
                if(res.status == 'success') {
                    
                    var data = res.data
                    data.forEach(function(row, index) {
                        tbody = tbody + `
                            <tr>
                                <td class="col-1"><input type="checkbox" class="form-check-input  checked" value="${row.id}"> </td>
                                <td>${row.name}</td>
                                <td>${row.code}</td>
                                <td>${row.dirName}</td>
                                <td>${row.divName}</td>
                            </tr>
                        `
                   })
                }else {
                    tbody = '<tr><td colspan="8" class="text-center">Data tidak ditemukan</td></tr>'
                }
                $('#total').text(total)
                $('#tbl-depts').html(tbody)
                
            }
        })
    }

    $(document).ready(function() {
        var query = $('#cari').val()
        document.title = 'Data Departemen'
        show_table(0, '')
        $.ajax({
            url: url_api + '/dirs/all',
            type: 'get',
            success: function(res) {
                var opt = ''
                if(res.status == 'success') {
                    opt = '<option value="0">Semua direktorat</option>'
                    var data = res.data
                    data.forEach(function(rows, index){
                        opt = opt + `<option value="${rows.id}">${rows.name}</option>`
                    })
                }else {
                    opt = '<option>Data Kosong</option>'
                }

                $('#show-dirs').html(opt)
            } 
        })
        
    })



</script>