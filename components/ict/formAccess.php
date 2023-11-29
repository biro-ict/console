<?php 
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $f = isset($_GET['f']) ? $_GET['f'] : '';

    $title = $f == 'user' ? 'Akses Berdasarkan user' : 'Akses berdasarkan aplikasi';
?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-white"><?php echo $title;?></h4>
                </div>
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-md-12 mb-3">
                            <div id="explaining"></div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <select class="form-select form-select-sm" id="userapps"></select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <select class="form-select form-select-sm" id="appsname"></select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <button class="btn btn-sm btn-primary" id="addAccess">Tambah user</button>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="table-responsive" srt>
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <td>fullname</td>
                                            <td>Username</td>
                                            <td>Aplikasi</td>
                                            <td>Aksi</td>
                                        </tr>
                                        
                                    </thead>
                                    <tbody id="tbody-access"> </tbody>
                                </table>
                            </div>
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

<script type="text/javascript">
    $('#backto').on('click', function() {
        location.reload()
    })

    function del_access(userid, appsid) {
        var func = `<?php echo $f;?>`;
        var id = `<?php echo $id;?>`;
        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Data akan dihapus secara permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal!',
            confirmButtonColor: '#0275d8',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if(result.value) {
                $.ajax({
                    url: url_api + '/app/deleteaccess',
                    type: 'post',
                    data: {
                        userid: userid,
                        appsid: appsid
                    },
                    success: function(res) {
                        Swal.fire(res.title, res.message, res.status)
                        if(res.status == 'success') show_data(id, func)
                    }
                })
            }
        })
    }

    $('#addAccess').on('click', function() {
        var func = `<?php echo $f;?>`;
        var id = `<?php echo $id;?>`;
        var userid = $('#userapps').val()
        var appsid = $('#appsname').val()

        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Kamu akan menambah akses user ini',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Tambah',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#0275d8',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if(result.value) {
                $.ajax({
                    url: url_api + '/app/addaccess',
                    type: 'post',
                    data: {
                        userid: userid,
                        appsid: appsid
                    },
                    success: function(res) {
                        Swal.fire(res.title, res.message, res.status)
                        if(res.status == 'success') show_data(id, func)
                    }
                })
            }else {
                Swal.fire('Batal', 'Batal menambah akses', 'error')
            }
        })

       
    })

    $(document).ready(function() {
        var func = `<?php echo $f;?>`;
        var id = `<?php echo $id;?>`;

        var url = func == 'user' ? '/empl/'+id : '/apps/'+id;
        $.ajax({
            url: url_api + url,
            type: 'get',
            success: function(res) {
                if(res.status == 'success') {
                    var title = res.message.includes('user') ? 'Data Akses untuk user: '+res.data[0].fullname : 'Data Akses untuk aplikasi ' +res.data[0].appsName
                    $('#explaining').html(title)
                }
            }
        })

        $.ajax({
            url: url_api + '/empl/all',
            type: 'get',
            success: function(res) {
                var opt = ''
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(row, index) {
                        var selected = row.id == id ? 'selected' : ''
                        opt = opt + `<option value="${row.id}" ${selected}>${row.username}</option>`
                    })
                }
                $('#userapps').html(opt)           
            }
        })

        $.ajax({
            url: url_api + '/apps/all',
            type: 'get',
            success: function(res) {
                var opt = ''
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(row, index) {
                        var selected = row.id == id ? 'selected' : ''
                        opt = opt + `<option value="${row.id}" ${selected}>${row.appsName}</option>`
                    })
                }
                $('#appsname').html(opt)           
            }
        })

        var classes = func == 'user' ? 'userapps' : 'appsname'; 
        $(`#${classes}`).attr('disabled', 'disabled')
        show_data(id, func)
    })

    function show_data(id, func) {
        $.ajax({
            url: url_api + '/app/accessbyapp',
            type: 'post',
            data: {id, id, func: func},
            success: function(res) {
                var tbody = ''
                if(res.status == 'success') {
                   
                    var data = res.data
                    data.forEach(function(row, index) {
                        tbody = tbody + `<tr><td>${index+1}</td><td>${row.fullname}</td><td>${row.username}</td><td>${row.appsName}</td><td><button class="btn btn-sm btn-warning" onclick="del_access(${row.userid}, ${row.appsId})">Hapus</button></td></tr>`
                    })

                    
                }else{

                }

                $('#tbody-access').html(tbody)

              
            }
        })
    }
</script>