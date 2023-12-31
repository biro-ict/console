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
                            <article class="table-responsive" style="height: 400px">
                                <table class="table table-striped table-hover">
                                    <thead style="background: white; position: sticky; top: 0;box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);">
                                        <th class="col">#</th>
                                        <th class="col">Nama</th>
                                        <th class="col">Username</th>
                                        <th class="col">Gender</th>
                                        <th class="col">Level</th>
                                        <th class="col">Departemen</th>
                                        <th class="col">Cabang</th>
                                        <th class="col">Status</th>
                                        <th class="col">Grade</th>
                                    </thead>
                                    <tbody id="tbl-empl"></tbody>
                                </table>
                            </article>
                            <caption class="text-muted">Total: <span id="total">0</span></caption>
                        </div>
                        
                    </div>
                </div>
                
                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addEmpl">Tambah</button>
                    <button type="button" class="btn btn-warning btn-sm" id="updateEmpl">Ubah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="deleteEmpl">Hapus</button>
                    <button type="button" class="btn btn-secondary btn-sm" id="backto">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#backto').on('click', function() {
        location.href = 'index.php'
    })

    $('#addEmpl').on('click', function() {
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

    $('#updateEmpl').on('click', function() {
        var user = `<?php echo $user;?>`;
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih Karyawan terlebih dahulu',
                'warning'
            )
        }else if(totals > 1){
            Swal.fire(
                'Peringatan',
                'Harap pilih hanya satu karyawan',
                'warning'
            )
        }else{
            var value = document.querySelector('.checked:checked').value
            var user = `<?php echo $user;?>`;
            $.ajax({
                url: '../components/hrd/formEmpl.php',
                type: 'get',
                data: {user:user, id: value},
                success: function(res) {
                    $('#content-user').html(res)
                }
            })
        }
    })

    $('#deleteEmpl').on('click', function() {
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih Karyawan terlebih dahulu',
                'warning'
            )
        }else {
            $('#tbl-empl input[type=checkbox]:checked').each(function() {
                var row = $(this).val()
                array.push(row)
           })

           console.log(array)
            Swal.fire({
                title: 'Kamu yakin?',
                text: 'Data akan terhapus secara permanen',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: url_api + '/empl/delete',
                        type: 'post',
                        data: {
                            id: array
                        },
                        success: function(res){
                            Swal.fire(res.title, res.message, res.status)
                            if(res.status == 'success')   show_table(0, 0, '')
                        }
                    })
                }else{
                    Swal.fire('Batal', 'Data batal hapus', 'warning')
                }
            })
        }
    })


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
        var total = 0
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
                    total = res.data.length
                    var data = res.data
                    data.forEach(function(row, index) {
                        tbody = tbody + `
                            <tr>
                                <td class="col-1"><input type="checkbox" class="form-check-input  checked" value="${row.id}"> </td> 
                                <td>${row.fullname}</td>
                                <td>${row.username}</td>
                                <td>${row.gender}</td>
                                <td>${row.level}</td>
                                <td>${row.deptName}</td>
                                <td>${row.branchName}</td>
                                <td>${row.statusName}</td>
                                <td>${row.grade}</td>

                            </tr>
                        `
                   })
                }else {
                    tbody = `<tr><td colspan="9" class="text-center">${res.message}</td></tr>`
                }

                $('#tbl-empl').html(tbody)
                $('#total').html(total)
                
            }
        })
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
                    opt = '<option value="0">Semua Cabang</option>'
                    var data = res.data
                    data.forEach(function(row, index) {
                        opt = opt + `<option value="${row.id}">${row.name}</option>`
                    })
                }else {
                    opt = `<option>${res.message}</option>`
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
                    opt = '<option value="0">Semua Departemen</option>'
                    var data = res.data
                    data.forEach(function(row, index) {
                        opt = opt + `<option value="${row.id}">${row.name}</option>`
                    })
                }else {
                    opt = `<option>${res.message}</option>`
                }

                $('#show-depts').html(opt)
            }
        })
        
    })



</script>