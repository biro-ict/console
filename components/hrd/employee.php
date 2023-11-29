<?php 
    $user = isset($_GET['user']) ? $_GET['user'] : '';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Karyawan</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-auto mb-3">
                            <select class="form-select form-select-sm" id="show-branch"></select>
                        </div>
                        <div class="col-auto mb-3">
                            <select class="form-select form-select-sm" id="show-depts"></select>
                        </div>
                        <div class="col-auto mb-3">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari" id="cari">
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="table-responsive" style="height: 400px">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <th class="col">#</th>
                                        <th class="col">Nama</th>
                                        <th class="col">Username</th>
                                        <th class="col">Gender</th>
                                        <th class="col">Level</th>
                                        <th class="col">Departemen</th>
                                        <th class="col">Branch</th>
                                        <th class="col">Status</th>
                                        <th class="col" colspan="3">Aksi</th>
                                    </thead>
                                    <tbody id="tbl-dirs"></tbody>
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
            url: '../components/hrd/formEmpl.php',
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
            url: '../components/hrd/formEmpl.php',
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
                    url: url_api + '/empl/delete',
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
        var branch = $('#show-branch').val()
        var depts = $('#show-depts').val()
        show_table(branch, depts, query)
    })

    $('#show-branch').on('change', function() {
        var query = $('#cari').val()
        var branch = $(this).val()
        var depts = $('#show-depts').val()
        show_table(branch, depts, query)
    })

    $('#show-depts').on('change', function() {
        var query = $('#cari').val()
        var branch = $('#show-branch').val()
        var depts = $(this).val()
        show_table(branch, depts, query)
    })

    function show_table(branch, depts,query) {
        var tbody = ''
        $.ajax({
            url: url_api + '/users/search',
            type: 'post',
            data: {
                branch: branch,
                depts: depts,
                query: query
            },
            success: function(res) {
                if(res.status == 'success') {
                    
                    var data = res.data
                    data.forEach(function(row, index) {
                        tbody = tbody + `
                            <tr>
                                <td>${index+1}</td>
                                <td>${row.fullname}</td>
                                <td>${row.username}</td>
                                <td>${row.gender}</td>
                                <td>${row.level}</td>
                                <td>${row.deptName}</td>
                                <td>${row.branchName}</td>
                                <td>${row.status}</td>
                                <td><button type="button" class="btn btn-sm btn-info" onclick="edit_data(${row.id})">Ubah</button></td>
                                <td><button type="button" class="btn btn-sm btn-success" onclick="data_bpjs()"> BPJS</button></td>
                                <td><button type="button" class="btn btn-sm btn-danger" " onclick="del_data(${row.id})">Hapus</button></td>

                            </tr>
                        `
                   })
                }else {
                    tbody = '<tr><td colspan="8" class="text-center">Data tidak ditemukan</td></tr>'
                }

                $('#tbl-dirs').html(tbody)
                
            }
        })
    }

    function data_bpjs() {
        Swal.fire('Maintenance', 'Module ini sedang dalam tahap pengembangan', 'warning')
    }

    $(document).ready(function() {
        var query = $('#cari').val()
        document.title = 'Data Karyawan'
        show_table(0, 0, '')

        $.ajax({
            url: url_api + '/branches/all',
            type: 'get',
            success: function(res) {
                var opt = ''
                if(res.status == 'success') {
                    opt = '<option value="0">All Branches</option>'
                    var data = res.data
                    data.forEach(function(row, index) {
                        opt = opt + `<option value="${row.id}">${row.name}</option>`
                    })
                }else {
                    opt = "<option>Tidak ada branch</option>"
                }

                $('#show-branch').html(opt)
            }
        })

        $.ajax({
            url: url_api + '/depts/all',
            type: 'get',
            success: function(res) {
                var opt = ''
                if(res.status == 'success') {
                    opt = '<option value="0">All Depts</option>'
                    var data = res.data
                    data.forEach(function(row, index) {
                        opt = opt + `<option value="${row.id}">${row.name}</option>`
                    })
                }else {
                    opt = "<option>Tidak ada depts</option>"
                }

                $('#show-depts').html(opt)
            }
        })
        
    })



</script>