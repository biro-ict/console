<?php 
$user = isset($_GET['user']) ? $_GET['user'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : 0;
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Aplikasi</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nama :</label>
                            <input type="text" class="form-control form-control-sm" id="nameapps" required> 
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Url:</label>
                            <input type="text" class="form-control form-control-sm" id="uriapps" required> 
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Url frontend:</label>
                            <input type="text" class="form-control form-control-sm" id="urife" > 
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>url backend:</label>
                            <input type="text" class="form-control form-control-sm" id="uribe"> 
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Database host:</label>
                            <input type="text" class="form-control form-control-sm"  id="dbhost"> 
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Database Name:</label>
                            <input type="text" class="form-control form-control-sm"  id="dbname"> 
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>login:</label>
                            <select class="form-select form-select-sm"  id="needlogin"></select> 
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>status:</label>
                            <select class="form-select form-select-sm"  id="status"></select> 
                        </div>
                    </div>
                </div>

                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-sm btn-success" id="formApps">Ubah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="backto">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#backto').on('click', function () {
        location.reload()
    })
   
    $(document).ready(function() {
        var opt_status = ''
        $.ajax({
            url: url_api + '/status_app/all',
            type: 'get',
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(row, index) {
                        opt_status = opt_status + `<option value="${row.Id}">${row.name}</option>`

                    })
                } else {
                    opt_status = `<option>No status can be showed</option>`
                }

                $('#status').html(opt_status)
            }
        })

        var opt_login = ''
        $.ajax({
            url: url_api + '/login_level/all',
            type: 'get',
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(row, index) {
                        opt_login = opt_login + `<option value="${row.kode}">${row.name}</option>`
                    })
                }else {
                    opt_login = '<option>No Login Level can be showed</option>'
                }

                $('#needlogin').html(opt_login)
            }
        })

        var user = `<?php echo $user;?>`;
        var id = `<?php echo $id;?>`;
        $.ajax({
            url: url_api + '/apps/'+id,
            type: 'get', 
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(row, index) {
                        $('#nameapps').val(row.appsName)
                        $('#uriapps').val(row.appsURL)
                        $('#urife').val(row.appsUriFE)
                        $('#uribe').val(row.appsUriBE)
                        $('#dbhost').val(row.appsDBHost)
                        $('#dbname').val(row.appsDBName)
                        $('#needlogin').val(row.needLogin)
                        $('#status').val(row.status)
                    })
                }
            }
        })
    })

    $('#formApps').on('click', function() {
       
        var id = `<?php echo $id;?>`;

        var url = id == 0 ? '/apps/add' : '/apps/update'


        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Data Aplikasi akan diubah',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0275d8',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ubah!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if(result.value) {
                $.ajax({
                    url: url_api + url,
                    type: 'post',
                    data: {
                        appsName: $('#nameapps').val(),
                        appsURL: $('#uriapps').val(),
                        appsUriFE: $('#urife').val(),
                        appsUriBE: $('#uribe').val(),
                        appsDBHost: $('#dbhost').val(),
                        appsDBName: $('#dbname').val(),
                        needLogin: $('#needlogin').val(),
                        status: $('#status').val(),
                        id: id

                    },
                    success: function(res) {
                        Swal.fire(res.title, res.message, res.status)
                        if(res.status == 'success') location.reload()
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        Swal.fire('Ooops', thrownError, 'error')
                    }
                })
            }else {
                Swal.fire('Batal', 'Data batal diubah', 'error')
            }
        })
    })
</script>