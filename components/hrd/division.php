<?php $user = isset($_GET['user']) ? $_GET['user'] : '';?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Divisi</h4>
                </div>
                <main class="card-body mt-3">
                    <div class="row">
                        <div class="col-auto mb-3">
                            <select class="form-select form-select-sm" id="show-dirs"></select>
                        </div>
                    
                        <div class="col-auto mb-3">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari" id="cari">
                        </div>
                        <content class="col-md-12 mb-3">
                            <div class="table-responsive" style="height: 400px">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <th class="col">#</th>
                                        <th class="col">Kode</th>
                                        <th class="col">Nama</th>
                                        <th class="col">Directory</th>
                                    </thead>
                                    <tbody id="tbl-division"></tbody>
                                </table>
                            </div>
                        </content>
                        
                    </div>
                </main>
                
                <footer class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addDivision">Tambah</button>
                    <button type="button" class="btn btn-info btn-sm" id="updateDivision">Ubah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="deleteDivision">Hapus</button>
                    <button type="button" class="btn btn-secondary btn-sm" id="backto">Kembali</button>
                </footer>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#backto').on('click', function() {
        window.location.go(-1)
    })


    function show_tables() {
        var cari = document.getElementById('cari').value
        var dirs = document.getElementById('show-dirs').value
        var tb = ''
        var tbody = document.getElementById('tbl-division')

        $.ajax({
            url: url_api + '/division/search',
            type: 'post',
            data: {
                cari: cari,
                dir: dirs 
            },
            success: function(res) {
                if(res.status=='success') {
                    var data = res.data
                    data.forEach(function(items, index) {
                        tb = tb + `<tr>
                            <td class="col-1"><input type="checkbox" class="form-check-input  checked" value="${items.id}"> </td> 
                            <td>${items.divisiCode}</td>
                            <td>${items.divisionName}</td>
                            <td>${items.dirName}</td>
                        </tr>`
                    })
                }else {
                    tb = `<tr><td colspan="5" class="text-center">${res.message}, ${res.title}.</td></tr>'`
                }

                tbody.innerHTML = tb
            }
        })
        
       
        
    }

    $('#addDivision').on('click', function() {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/hrd/formDivision.php',
            type: 'get',
            data: {user: user},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
    })

    $('#updateDivision').on('click', function() {
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih Divisi terlebih dahulu',
                'warning'
            )
        }else if(totals > 1){
            Swal.fire(
                'Peringatan',
                'Harap pilih hanya satu Divisi',
                'warning'
            )
        }else{
            var value = document.querySelector('.checked:checked').value
            var user = `<?php echo $user;?>`;
            $.ajax({
                url: '../components/hrd/formDivision.php',
                type: 'get',
                data: {user:user, id: value},
                success: function(res) {
                    $('#content-user').html(res)
                }
            })
        }
    })

    $('#deleteDivision').on('click', function() {
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih Divisi terlebih dahulu',
                'warning'
            )
        }else {
            $('#tbl-division input[type=checkbox]:checked').each(function() {
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
                        url: url_api + '/division/delete',
                        type: 'post',
                        data: {
                            id: array
                        },
                        success: function(res){
                            Swal.fire(res.title, res.message, res.status)
                            if(res.status == 'success') show_tables()
                        }
                    })
                }else{
                    Swal.fire('Batal', 'Data batal hapus', 'warning')
                }
            })
        }
    })

    $(document).ready(function() {
        show_tables()

        $.ajax({
            url: url_api + '/dir/search',
            type: 'post',
            success: function(res) {
                var option = '<option value="">Semua Direktorat</option>'
                if(res.status=='success') {
                    var data = res.data
                    data.forEach(function(items, rows) {
                        option = option + `<option value="${items.id}">${items.name}  [${items.orgName}]</option>`
                    })
                }

                $('#show-dirs').html(option)
            }
        })
    })
    
    $('#cari').on('keyup', function() {
        show_tables()
      
    })

    $('#show-dirs').on('click', function() {
        show_tables()
    })

    
</script>

