<?php $user = isset($_GET['user']) ? $_GET['user'] : '';?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Personal</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nama Lengkap:</label>
                            <input type="text" class="form-control form-control-sm" id="fullname" readonly> 
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Username:</label>
                            <input type="text" class="form-control form-control-sm" id="username" readonly> 
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Level:</label>
                            <input type="text" class="form-control form-control-sm" id="level" readonly> 
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Dept:</label>
                            <input type="text" class="form-control form-control-sm" readonly id="dept"> 
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Branch:</label>
                            <input type="text" class="form-control form-control-sm" readonly id="branch"> 
                        </div>
                    </div>
                </div>

                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-danger btn-sm" id="backto">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#backto').on('click', function () {
        location.href = 'index.php'
    })
   
    $(document).ready(function() {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: url_api + '/detils',
            type: 'post',
            data: {
                username: user
            },
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(row, index) {
                        $('#fullname').val(row.fullname)
                        $('#username').val(row.username)
                        $('#level').val(row.level)
                        $('#dept').val(row.deptName)
                        $('#branch').val(row.branchName)
                    })
                }
            }
        })
    })
</script>