<?php 
    $user = isset($_GET['user']) ? $_GET['user'] : '';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="showByChoose">
                <label class="form-check-label" id="nameswitch" for="showByChoose">Berdasarkan Aplikasi</label>
            </div>
        </div>
        
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-white" id="text-title">
                    List berdasarkan aplikasi
                    </h4>
                    <div role="alert" class="alert alert-danger text-small">Production and LDAP only!</div>
                </div>
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="table-responsive" style="height: 400px;">
                                <table class="table table-striped table-hover">
                                    <thead id="thead-table"></thead>
                                    <tbody id="tbody-table"></tbody>
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
<div>
   
</div>

<script type="text/javascript">

    //notes: 1 is for apps and 0 is for user
    $('#backto').on('click', function() {
        location.href = 'index.php'
    })

    $('#showByChoose').on('change', function() {
       
        if($(this).is(':checked')) {
            $('#nameswitch').html('Berdasarkan user')
            $('#text-title').html('List berdasarkan user')
            show_thead(0)
            show_table(0)
        }else {
            $('#nameswitch').html('Berdasarkan aplikasi')
            $('#text-title').html('List berdasarkan aplikasi')
            show_thead(1)
            show_table(1)
        }
    })
    $(document).ready(function() {
        show_thead(1)
        show_table(1)
    })

    function show_thead(checked) {
        var  thead = `
                <tr>
                    <th class="col">#</th>
                    <th class="col">Nama</th>
                    <th class="col">Username</th>
                    <th class="col">Departemen</th>
                    <th class="col">Status</th>
                    <th class="col">Aksi</th>
                </tr>
            `
        if(checked == 1) {
            thead = `  
                <tr>
                    <th class="col">#</th>
                    <th class="col">Aplikasi</th>
                    <th class="col">URL </th>
                    <th class="col">Status Aplikasi</th>
                    <th class="col">Status Login</th>
                    <th class="col">Aksi</th>
                </tr>
            `
        }

        $('#thead-table').html(thead)
    }

    function show_table(checked) {
        var tbody = ''
        if(checked == 1) {

            $.ajax({
                url: url_api + '/app/access',
                type: 'get',
                success: function(res) {
                    if(res.status == 'success') {
                        var data = res.data
                        tbody = ''
                        data.forEach(function(row, index) {
                            tbody = tbody + `
                                <tr>
                                    <td>${index+1}</td>
                                    <td>${row.appsName}</td>
                                    <td><a href="${row.appsURL}" target="_blank">${row.appsURL}</a></td>
                                    <td>${row.status}</td>
                                    <td>${row.needlogin}</td>
                                    <td><button class="btn btn-sm btn-warning" onclick="view_access(${row.id}, 'apps')">Lihat Akses</button></td>
                                </tr>
                            `
                        })
                    }else {
                        tbody = '<tr><td colspan="6" class="text-center>No data found</td></tr>'
                    }

                    $('#tbody-table').html(tbody)
                }
            })
        }else {
            $.ajax({
                url: url_api + '/app/empl/access',
                type: 'get',
                success: function(res) {
                    if(res.status == 'success') {
                        var data = res.data
                        tbody = ''
                        data.forEach(function(row, index) {
                           
                            tbody = tbody + `
                                <tr>
                                    <td>${index+1}</td>
                                    <td>${row.fullname}</td>
                                    <td>${row.username}</td>
                                    <td>${row.deptName}</td>
                                    <td>${row.status}</td>
                                    <td><button class="btn btn-sm btn-warning" onclick="view_access(${row.id}, 'user')">Lihat Akses</button></td>
                                </tr>
                            `
                        })
                    }else {
                        tbody = '<tr><td colspan="6" class="text-center>No data found</td></tr>'
                    }
                    $('#tbody-table').html(tbody)
                }
            })
            
        } 

    } 

    function view_access(id, func) {
        
        $.ajax({
            url: '../components/ict/formAccess.php',
            type: 'get',
            data: {
                id: id,
                f: func
            }, success: function(res) {
                $('#content-user').html(res)
            }
        })
    }
</script>