<?php $user = isset($_GET['user']) ? $_GET['user'] : '';?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Status Karyawan</h4>
                </div>
                <main class="card-body mt-3">
                        <div class="col-auto mb-3">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari" id="cari">
                        </div>
                        <div class="col-md-12 mb-3">

                         
                            <article class="table-responsive" style="height: 400px">
                            
                                <table class="table table-striped table-hover">
                                    <thead style="background: white; position: sticky; top: 0;box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);">
                                        <th class="col">#</th>
                                        <th class="col">Kode</th>
                                        <th class="col">Nama</th>
                                    </thead>
                                    <tbody id="tbl-status"></tbody>
                                </table>
                            </article>
                            <caption class="text-muted">Total: <span id="total">0</span></caption>
                        </div>
                    </div>
                </main>
                
                <footer class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addStatus">Tambah</button>
                    <button type="button" class="btn btn-warning btn-sm" id="updateStatus">Ubah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="deleteStatus">Hapus</button>
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

    $('#addStatus').on('click', function() {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/hrd/formStatus.php',
            type: 'get',
            data: {user: user},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
    })

    $('#updateStatus').on('click', function() {
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih Status terlebih dahulu',
                'warning'
            )
        }else if(totals > 1){
            Swal.fire(
                'Peringatan',
                'Harap pilih hanya satu status',
                'warning'
            )
        }else{
            var value = document.querySelector('.checked:checked').value
            var user = `<?php echo $user;?>`;
            $.ajax({
                url: '../components/hrd/formStatus.php',
                type: 'get',
                data: {user:user, id: value},
                success: function(res) {
                    $('#content-user').html(res)
                }
            })
        }
    })

    $('#deleteStatus').on('click', function() {
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih Status terlebih dahulu',
                'warning'
            )
        }else {
            $('#tbl-status input[type=checkbox]:checked').each(function() {
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
                        url: url_api + '/status/delete',
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

    function show_tables() {

        var total = 0
        $.ajax({
            url: url_api + '/status/search',
            type: 'post',
            data: {
                search: $('#cari').val()
            },
            success: function(res) {
                total = res.data == undefined ? 0 : res.data.length
                var tb = ''
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(items, index) {
                        tb = tb + `<tr>
                            <td class="col-1"><input type="checkbox" class="form-check-input  checked" value="${items.id}"> </td>
                            <td>${items.statusCode}</td>
                            <td>${items.statusName}</td>
                        </tr>`
                    })
                }else {
                    tb = `<tr><td colspan="3" class="text-center">${res.message}</td></tr>`
                }

                $('#total').text(total)
                $('#tbl-status').html(tb)
            }
        })
    } 

    $('#cari').on('keyup', function() {
        show_tables()
    })

    $(document).ready(function() {
        show_tables()
    })

</script>