<?php 
    $user = isset($_GET['user']) ? $_GET['user'] : '';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Lisensi User</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="table-responsive" style="height:400px">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="col">#</th>
                                            <th class="col">Username</th>
                                            <th class="col">Windows Type</th>
                                            <th class="col">Win. Serial Key</th>
                                            <th class="col">Ms. Office Type</th>
                                            <th class="col">Ms. Office Serial Key</th>
                                            <th class="col">Location (branch)</th>
                                            <th class="col">Device</th>
                                            <th colspan="2" class="col">Aksi</th>

                                        </tr>
                                    </thead>
                                    <tbody id="tbl-license"></tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addLicense">Tambah</button>
                    <button type="button" id="backto" class="btn btn-danger btn-sm">
                        Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#backto').on('click', function() {
        location.href = "index.php"
    })

    $('#addLicense').on('click', function() {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/ict/formLicense.php',
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
            url: '../components/ict/formLicense.php?id='+id,
            type: 'get',
            data: {user:user},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
    }

    function delete_data(id) {
        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Kamu akan menghapus data ini secara permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if(result.value) {
                $.ajax({
                    url: url_api + '/licenses/delete',
                    type: 'post',
                    data: {
                        id: id
                    },
                    success: function(res) {
                        Swal.fire(res.title, res.message, res.status)
                        if(res.status == 'success') location.reload()
                    }
                })

            }else {
                Swal.fire('Batal', 'Data Batal dihapus', 'error')
            }
        })
    }

    $(document).ready(function() {

        $.ajax({
            url: url_api + '/licenses',
            type: 'get',
            success: function(res) {

                var tbody = ''
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(rows, index) {
                        tbody = tbody + `
                            <tr>
                                <td>${index+1}</td>
                                <td>${rows.fullname}</td>
                                <td>${rows.winType}</td>
                                <td>${rows.winSerKey}</td>
                                <td>${rows.officeType}</td>
                                <td>${rows.officeSerKey}</td>
                                <td>${rows.location}</td>
                                <td>${rows.device}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" onclick="edit_data(${rows.Id})">Edit</button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="delete_data(${rows.Id})">Hapus</button>
                                </td>
                            </tr>
                        `
                    });

                }else {
                    tbody = '<tr><td colspan="10" class="text-center"> Data Kosong</td></tr>'
                }

                $('#tbl-license').html(tbody)
            }
        })
    })
</script>