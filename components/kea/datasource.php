<?php 
    $user = isset($_GET['user']) ? $_GET['user'] : '';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Source</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-auto">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari" id="cari">
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive" style="height: 400px">
                                <table class="table table-sm table-striped table-hover">
                                    <thead>
                                        <th class="col">#</th>
                                        <th class="col">Datasource</th>
                                        <th class="col">Nama</th>
                                        <th class="col">Desksrpsi</th>
                                        <th class="col">Approved</th>
                                    </thead>
                                    <tbody id="tbl-datasource"></tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addDatasource">Tambah</button>
                    <button type="button" class="btn btn-warning btn-sm" id="updateDatasource">Ubah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="deleteDataSource">Hapus</button>
                    <button type="button" class="btn btn-secondary btn-sm" id="backto">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#backto').on('click', function() {
        window.history.go(-1)
    })

    $('#updateDatasource').on('click', function() {
        var user = `<?php echo $user;?>`;
        var checkbox = document.querySelectorAll('.checked:checked')
        var totals  = checkbox == undefined ? 0 : checkbox.length

        if(totals==0) {Swal.fire('Peringatan', 'Harap pilih satu datasource', 'warning')} else if(totals>1) {Swal.fire('Peringatan', 'Harap pilih satu datasource', 'warning')} else {
            var value = document.querySelector('.checked:checked').value
            $.ajax({
                url: '../components/kea/formDatasource.php',
                type: 'get',
                data: {user: user, id: value},
                success: function(res) { $('#content-user').html(res)}
            })
        }
    })

    $('#deleteDataSource').on('click', function() {
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih Datasource terlebih dahulu',
                'warning'
            )
        }else{
            $('#tbl-datasource input[type=checkbox]:checked').each(function() {
                var row = $(this).parent().siblings(':first').text();
                array.push(row)
              
            })
            Swal.fire({
                title: 'Kamu yakin?',
                text: 'Data ini akan dihapus secara permanen',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus',
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: url_api + '/datasource/delete',
                        type: 'post',
                        data: {
                            datasource: array
                        },
                        success: function(res) {
                           Swal.fire(res.title, res.message, res.status);
                           if(res.status == 'success') show_tables()
                        }
                    })
                }else{
                    Swal.fire('Batal', 'Data batal dihapus', 'error')
                }
            })

          
           
        }
    })

    $('#addDatasource').on('click', function() {
        // to add Datasource
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/kea/formDatasource.php',
            type: 'get',
            data: {user:user},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
        
    })

    $('#cari').on('keyup', function() {
        show_tables()
    })

    function show_tables() {

        var cari = $('#cari').val()
        $.ajax({
            url: url_api + '/datasource',
            type: 'post',
            data: {
                cari: cari
            },
            success: function(res) {
                var tb = ''
                if(res.status == 'success') {
                   var data = res.data
                   
                    data.forEach(function(items, index) {
                        tb = tb + `<tr>
                             <td class="col-1"><input type="checkbox" class="form-check-input  checked" value="${items.DataSource}"> </td>
                            <td><b>${items.DataSource}</b></td>
                            <td>${items.DataSourceName}</td>
                            <td>${items.DataSourceDescr}</td>
                            <td>${items.Approved}</td>
                            </tr>`
                    })
                }else {
                    tb = tb + `<tr><td colspan="6" class="text-center">Data tidak ditemukan</td></tr>`
                }

                $('#tbl-datasource').html(tb)
            }
        })
    }

    $(document).ready(function() {
        show_tables()
    })
</script>