<?php 
    $user = isset($_GET['user']) ? $_GET['user'] : '';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Kategori Item</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-auto">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari" id="cari">
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive" style="height: 400px">
                                <table class="table table-sm table-striped table-hover">
                                    <thead style="background: white; position: sticky; top: 0;box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);">
                                        <th class="col">#</th>
                                        <th class="col">ID</th>
                                        <th class="col">Nama</th>
                                        <th class="col">Keterangan</th>
                                    </thead>
                                    <tbody id="tbl-itemcategory"></tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addItemcategory">Tambah</button>
                    <button type="button" class="btn btn-warning btn-sm" id="updateItemcategory">Ubah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="deleteItemcategory">Hapus</button>
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

    $('#addItemcategory').on('click', function() {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/prc/formItemcategory.php',
            type: 'get',
            data: {user:user},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
    })

    $('#updateItemcategory').on('click', function() {
        var user = `<?php echo $user;?>`;
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire('Peringatan', 'Silahkan pilih kategori item terlebih dulu', 'warning')
        }else if(totals>1) {
            Swal.fire('Peringatan', 'Harap hanya pilih satu kategori item', 'warning')
        }else {
            var value = document.querySelector('.checked:checked').value
            $.ajax({
                url: '../components/prc/formItemcategory.php',
                type: 'get',
                data: {user:user, id:value},
                success: function(res) {
                    $('#content-user').html(res)
                }
            })
        }
    })

    $('#deleteItemcategory').on('click', function() {
        var users = `<?php echo $user;?>`;
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih data kategori item terlebih dahulu',
                'warning'
            )
        }else {
            $('#tbl-itemcategory input[type=checkbox]:checked').each(function() {
                var row = $(this).val()
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
                        url: url_api + '/itemcategory/delete',
                        type: 'post',
                        data: {
                            id: array, 
                            updatedby: users,
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

    $('#cari').on('keyup', function() {
        show_tables()
    })

    function show_tables() {
        var cari = $('#cari').val()
        $.ajax({
            url: url_api + '/itemcategory',
            type: 'post',
            data: {
                cari: cari
            },
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data
                    var tb = ''
                    data.forEach(function(items, index) {
                        tb = tb + 
                        `<tr>
                             <td class="col-1"><input type="checkbox" class="form-check-input  checked" value="${items.itemcategoryid}"> </td>
                            <td><b>${items.itemcategoryid}</b></td>
                            <td>${items.itemcategoryname}</td>
                            <td>${items.itemcategorydescr}</td>
                        </tr>`
                    })

                    
                }else {
                    tb = tb + `<tr><td colspan="5" class="text-center"><p>Data tidak ditemukan</p></td></tr>`
                }

                $('#tbl-itemcategory').html(tb)
            }
        })
    }

    $(document).ready(function() {
        show_tables()
    })
</script>
