<?php 
$user = isset($_GET['user']) ? $_GET['user'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : 0;
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
                        <div class="col-md-6 mb-3">
                            <label>Nama Lengkap :</label>
                            <input type="text" class="form-control form-control-sm" id="name" required> 
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Username:</label>
                            <input class="form-control form-control-sm" id="username" required> 
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Jenis Kelamin</label>
                            <select class="form-select form-select-sm" id="gender">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Level</label>
                            <input type="text" class="form-control form-control-sm" id="level" > 
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Departemen</label>
                            <select class="form-select form-select-sm" id="department"> </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Branch:</label>
                            <select class="form-select form-select-sm" id="branch"> </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Grade: </label>
                            <select class="form-select form-select-sm" id="grade"> </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Status:</label>
                            <select class="form-select form-select-sm" id="status"> </select>
                        </div>
                    </div>
                </div>

                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-sm btn-success" id="formEmpl">Ubah</button>
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
        var user = `<?php echo $user;?>`;
        var id = `<?php echo $id;?>`;
        var opt_dept='';
        var opt_branch='';
        var opt_grade='';
        var opt_status='';
        $.ajax({
            url: url_api + '/depts/all',
            type: 'get',
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(row, index) {
                        opt_dept = opt_dept + `<option value="${row.id}">${row.name}</option>`
                    })
                }else{
                    opt_dept = `<option>${res.message}</option>`
                }

                $('#department').html(opt_dept)
            }
        })

        $.ajax({
            url: url_api + '/grade/all',
            type: 'get',
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(row, index) {
                        opt_grade = opt_grade + `<option value="${row.id}">(${row.gradeCode} - ${row.gradeName})</option>`
                    })
                }else{
                    opt_grade = '<option>Tidak ada data</option>'
                }

                $('#grade').html(opt_grade)
            }
        })


        $.ajax({
            url: url_api + '/status/all',
            type: 'get',
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(row, index) {
                        opt_status = opt_status + `<option value="${row.id}">${row.statusName}</option>`
                    })
                }else{
                    opt_status = '<option>Tidak ada data</option>'
                }

                $('#status').html(opt_status)
            }
        })

        $.ajax({
            url: url_api + '/branches/all',
            type: 'get',
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(row, index) {
                        opt_branch = opt_branch + `<option value="${row.id}">${row.name}</option>`
                    })
                }else{
                    opt_branch = '<option>Tidak ada data</option>'
                }

                $('#branch').html(opt_branch)
            }
        })

        $.ajax({
            url: url_api + '/empl/'+id,
            type: 'get', 
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(row, index) {
                        $('#name').val(row.fullname)
                        $('#username').val(row.username)
                        $('#gender').val(row.gender)
                        $('#level').val(row.level)
                        $('#department').val(row.deptId)
                        $('#branch').val(row.branchid)
                        $('#grade').val(row.gradeId)
                        $('#status').val(row.status)
                    })
                }
            }
        })
    })

    $('#formEmpl').on('click', function() {
        var formdata = new FormData()
        var id = `<?php echo $id;?>`;
        var url = id == 0 ? '/empl/add' : '/empl/update'

        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Data Karyawan akan diubah',
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
                        fullname: $('#name').val(),
                        username: $('#username').val(),
                        gender: $('#gender').val(),
                        level: $('#level').val(),
                        deptId: $('#department').val(),
                        branchid: $('#branch').val(),
                        grade: $('#grade').val(),
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