<?php 
$user = isset($_GET['user']) ? $_GET['user'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : 0;
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Lisensi</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Nama Lengkap</label>
                            <select class="form-select form-select-sm" id="username"></select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Tipe Windows</label>
                            <input type="text" class="form-control form-control-sm" id="winType">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Serial Key Windows</label>
                            <input type="text" class="form-control form-control-sm" id="winSerKey">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Tipe Office</label>
                            <input type="text" class="form-control form-control-sm" id="officeType">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Serial Key Office</label>
                            <input type="text" class="form-control form-control-sm" id="officeSerKey">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Lokasi</label>
                            <select class="form-select form-select-sm" id="location"></select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Perangkat: </label>
                            <input type="text" class="form-control form-control-sm" id="device">
                        </div>
                    </div>
                </div>
                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-sm btn-success" id="formLicenses">Ubah</button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="location.reload()">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $('#formLicenses').on('click', function() {
        var user = `<?php echo $user;?>`;
        var id = `<?php echo $id;?>`;

        var url = id == 0 ? url_api + '/licenses/add' : url_api + '/licenses/update'

        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Kamu akan mengubah data ini',
            icon: 'warning',
            showCancelButton:true,
            confirmButtonText: 'Ya, ubah!',
            cancelButtonText: 'Batal',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if(result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        id: id,
                        username: $('#username').val(),
                        winType: $('#winType').val(),
                        winSerKey: $('#winSerKey').val(),
                        officeType: $('#officeType').val(),
                        officeSerKey: $('#officeSerKey').val(),
                        location: $('#location').val(),
                        device: $('#device').val()
                    },
                    success: function(res) {
                        Swal.fire(res.title, res.message, res.status)
                        if(res.status == 'success') location.reload()
                    }
                })

            }else {
                Swal.fire('Batal', 'Data Lisensi Batal dibuat', 'error')
            }
        })
    })
    
    $(document).ready(function() {
        var user = `<?php echo $user;?>`;
        var id = `<?php echo $id;?>`;

        $.ajax({
            url: url_api + '/empl/all',
            type: 'get',
            success: function(res) {
                var opt = ''
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(rows, index) {
                        opt = opt + `<option value="${rows.id}">${rows.fullname}</option>`
                    })
                }else{
                    opt = '<option>No Data Found</option>'
                }
                $('#username').html(opt)
            }
        })

        
        $.ajax({
            url: url_api + '/branches/all',
            type: 'get',
            success: function(res) {
                var opt = ''
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(rows, index) {
                        opt = opt + `<option value="${rows.id}">${rows.name}</option>`
                    })
                }else {
                    opt = '<option>No Data Found</option>'
                }
                $('#location').html(opt)
            }
        })

        if(id > 0) {
            $.ajax({
                url: url_api + '/license/'+id,
                type: 'get',
                success: function(res) {
                    if(res.status == 'success') {
                        var data = res.data
                        data.forEach(function(row, index) {
                            console.log(row)
                            $('#username').val(row.username)
                            $('#winType').val(row.winType)
                            $('#winSerKey').val(row.winSerKey)
                            $('#officeType').val(row.officeType)
                            $('#officeSerKey').val(row.officeSerKey)
                            $('#location').val(row.location)
                            $('#device').val(row.device)
                        })
                    }
                }
            })
        }
    })
</script>