<?php $user = isset($_GET['user']) ? $_GET['user'] : '';?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Organisasi</h4>
                </div>
                <main class="card-body mt-3">
                    <div class="row  mb-3">
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari" id="cari">
                        </div>
                       
                        <div class="col-md-12">
                            <article class="table-responsive" style="height: 400px">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <th class="col">#</th>
                                        <th class="col">Nama</th>
                                        <th class="col">Kode</th>
                                        <th class="col">Alamat 1</th>
                                        <th class="col">Alamat 2</th>
                                        <th class="col">Telp</th>
                                    </thead>
                                    <tbody id="tbl-orgz"></tbody>
                                </table>
                            </article>
                            <caption class="text-muted text-small">Total Organisasi: <span id="total">0</span></caption>
                        </div>
                    </div>
                </main>
                
                <footer class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addOrgz">Tambah</button>
                    <button type="button" class="btn btn-warning btn-sm" id="updateOrgz">Ubah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="deleteOrgz">Hapus</button>
                    <button type="button" class="btn btn-secondary btn-sm" id="backto">Kembali</button>
                    <button type="button" class="btn btn-success btn-sm" id="downloadOrgz">Export to excel</button>
                </footer>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#backto').on('click', function() {
        location.href = 'index.php'
    })

    $('#downloadOrgz').on('click', function() {
        Swal.fire('Ooops', 'Feature ini masih dalam tahap pengembangan', 'warning')
    })

    $('#addOrgz').on('click', function() {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/hrd/formOrgz.php',
            type: 'get',
            data: {user:user},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
    })


    $('#updateOrgz').on('click', function() {
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih Organisasi terlebih dahulu',
                'warning'
            )
        }else if(totals > 1){
            Swal.fire(
                'Peringatan',
                'Harap pilih hanya organisasi grade',
                'warning'
            )
        }else{
            var value = document.querySelector('.checked:checked').value
            var user = `<?php echo $user;?>`;
            $.ajax({
                url: '../components/hrd/formOrgz.php',
                type: 'get',
                data: {user:user, id: value},
                success: function(res) {
                    $('#content-user').html(res)
                }
            })
        }
    })

    $('#deleteOrgz').on('click', function() {
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih organisasi terlebih dahulu',
                'warning'
            )
        }else {
            $('#tbl-orgz input[type=checkbox]:checked').each(function() {
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
                        url: url_api + '/org/delete',
                        type: 'post',
                        data: {
                            id: array
                        },
                        success: function(res){
                            Swal.fire(res.title, res.message, res.status)
                            if(res.status == 'success') show_tables()
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            if(xhr.status == 500) Swal.fire('Ooops', 'Sepertinya data yang kamu ingin hapus merupakan data primary. Silahkan cek kembali sebelum menghapus data ini. ', 'error')
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
        show_table(query)
    })

    function show_table(query) {
        var tbody = ''
        $.ajax({
            url: url_api + '/org/search',
            type: 'post',
            data: {
                query: query
            },
            success: function(res) {
                var total = res.data === undefined ? 0 : res.data.length
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(row, index) {
                        tbody = tbody + `
                            <tr>
                                <td class="col-1"><input type="checkbox" class="form-check-input  checked" value="${row.id}"> </td>
                                <td>${row.name}</td>
                                <td>${row.code}</td>
                                <td>${row.address_one}</td>
                                <td>${row.address_two}</td>
                                <td>${row.telp}</td>

                            </tr>
                        `
                   })
                }else {
                    tbody = `<tr><td colspan="6" class="text-center">${res.message}</td></tr>`
                }
                $('#total').text(total)
                $('#tbl-orgz').html(tbody)
                
            }
        })
    }

    $(document).ready(function() {
        var query = $('#cari').val()
        document.title = 'Data Organisasi'
        show_table('')
        
    })



</script>