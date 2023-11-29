<?php 
    $user = isset($_GET['user']) ? $_GET['user'] : '';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Device Yang Bypass Wifi</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-auto">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari " id="cari">
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive" style="height: 400px">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <th class="col">#</th>
                                        <th class="col">mac</th>
                                        <th class="col">deskripsi</th>
                                        <th class="col">ip address</th>
                                        <th class="col" colspan="2">Aksi</th>
                                    </thead>
                                    <tbody id="tbl-mac"></tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addMac">Tambah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="backto">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#backto').on('click', function() {
        location.reload()
    })

    $('#addMac').on('click', function() {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/ict/formMac.php',
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
            url: '../components/ict/formMac.php',
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
                    url: url_api + '/mac/delete',
                    type: 'post',
                    data: {
                        mac: id
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
        show_table(query)
    })

    function show_table(query) {
        var tbody = ''
        $.ajax({
            url: url_api + '/mac/search',
            type: 'post',
            data: {
                query: query
            },
            success: function(res) {
                if(res.status == 'success') {
                    
                    var data = res.data
                    data.forEach(function(row, index) {
                        var ipaddr = row.ipaddr == null ? '' : row.ipaddr;
                        tbody = tbody + `
                            <tr>
                                <td>${index+1}</td>
                                <td>${row.mac}</td>
                                <td>${row.description}</td>
                                <td>${ipaddr}</td>
                                <td><button type="button" class="btn btn-sm btn-info" onclick="edit_data('${row.mac}')">Ubah</button></td>
                                <td><button type="button" class="btn btn-sm btn-danger" " onclick="del_data('${row.mac}')">Hapus</button></td>

                            </tr>
                        `
                   })
                }else {
                    tbody = '<tr><td colspan="8" class="text-center">Data tidak ditemukan</td></tr>'
                }

                $('#tbl-mac').html(tbody)
                
            }
        })
    }

    $(document).ready(function() {
        var query = $('#cari').val()
        document.title = 'Data Bypass wifi'
        show_table('')
        
    })



</script>