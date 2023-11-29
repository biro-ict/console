<?php 
    $user = isset($_GET['user']) ? $_GET['user'] : '';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Departemen</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-auto">
                            <select class="form-select form-select-sm" id="show-dirs"></select>
                        </div>
                        <div class="col-auto">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari" id="cari">
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive" style="height: 400px">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <th class="col">#</th>
                                        <th class="col">Nama</th>
                                        <th class="col">Kode</th>
                                        <th class="col">Direktorat</th>
                                        <th class="col" colspan="2">Aksi</th>
                                    </thead>
                                    <tbody id="tbl-depts"></tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addDepts">Tambah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="backto">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
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

    function edit_data(id) {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/hrd/formDepts.php',
            type: 'get',
            data: {user:user, id: id},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
    }

    function del_data(id) {
        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Kamu akan menghapus data ini secara permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0275d8',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) =>  {
            if(result.value) {
                $.ajax({
                    url: url_api + '/depts/delete',
                    type: 'post',
                    data: {
                        id: id
                    },
                    success: function(res) {
                        Swal.fire(res.title, res.message, res.status)
                        if(res.status == 'success') location.reload()
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                       if(xhr.status == 500) Swal.fire('Ooops', 'Sepertinya data yang kamu ingin hapus merupakan data primary. Silahkan cek kembali sebelum menghapus data ini. ', 'error')
                    }
                })
            }else{
                Swal.fire('Batal', 'Data batal dihapus', 'error')
            }
        })
    }

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
        var tbody = ''
        $.ajax({
            url: url_api + '/depts/search',
            type: 'post',
            data: {
                dirs: dirs,
                query: query
            },
            success: function(res) {
                if(res.status == 'success') {
                    
                    var data = res.data
                    data.forEach(function(row, index) {
                        tbody = tbody + `
                            <tr>
                                <td>${index+1}</td>
                                <td>${row.name}</td>
                                <td>${row.code}</td>
                                <td>${row.dirName}</td>
                                <td><button type="button" class="btn btn-sm btn-info" onclick="edit_data(${row.id})">Ubah</button></td>
                                <td><button type="button" class="btn btn-sm btn-danger" " onclick="del_data(${row.id})">Hapus</button></td>

                            </tr>
                        `
                   })
                }else {
                    tbody = '<tr><td colspan="8" class="text-center">Data tidak ditemukan</td></tr>'
                }

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