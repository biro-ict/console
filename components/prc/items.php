<?php 
    $user = isset($_GET['user']) ? $_GET['user'] : '';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Item</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                      
                        <div class="col-auto">
                            <select class="form-select form-select-sm" id="tipe"></select>
                        </div>
                        <div class="col-auto">
                            <select class="form-select form-select-sm" id="kategori"></select>
                        </div>
                        <div class="col-auto">
                            <select class="form-select form-select-sm" id="satuan_po"></select>
                        </div>
                        <div class="col-auto">
                            <select class="form-select form-select-sm" id="satuan_stock"></select>
                        </div>
                        <div class="col-auto">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari berdasarkan nama atau spesifikasi" id="cari">
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive" style="height: 400px">
                                <caption>Total Item: <span id="total"></span></caption>
                                <table class="table table-sm table-striped table-hover">
                                    
                                    <thead style="background: white; position: sticky; top: 0;box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);">
                                        <th class="col">#</th>
                                        <th class="col">ID</th>
                                        <th class="col">Nama</th>
                                        <th class="col">Tipe</th>
                                        <th class="col">Kategory</th>
                                        <th class="col">Satuan PO</th>
                                        <th class="col">Satuan Stok</th>
                                        <th class="col">Spesifikasi</th>
                                        <th class="col">Aksi</th>
                                    </thead>
                                    <tbody id="tbl-items"></tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addItems">Tambah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="deleteItems">Hapus</button>
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

    $('#addItems').on('click', function() {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/prc/formItem.php',
            type: 'get',
            data: {user:user},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
    })

    $('#deleteItems').on('click', function() {
        var users = `<?php echo $user;?>`;
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih data item terlebih dahulu',
                'warning'
            )
        }else {
            $('#tbl-items input[type=checkbox]:checked').each(function() {
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
                        url: url_api + '/item/delete',
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

    function edit_data(id) {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/prc/formItem.php',
            type: 'get',
            data: {user:user, id: id},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
    }

    function show_tables() {
        $.ajax({
            url: url_api + '/item',
            type: 'post',
            data: {
                tipe: $('#tipe').val(),
                kategori: $('#kategori').val(),
                satuan_po: $('#satuan_po').val(),
                satuan_stock: $('#satuan_stock').val(),
                cari: $('#cari').val()
            },
            success: function(res) {
                $('#total').html(res.data.length + ' items (max 1000 items)');
                if(res.status == 'success') {
                    var data = res.data
                    var tb = ''
                    data.forEach(function(items, index) {
                        var spesifikasi = items.spesifikasi == null ? '' : items.spesifikasi
                        tb = tb + `<tr>
                             <td class="col-1"><input type="checkbox" class="form-check-input  checked" value="${items.itemid}"> </td>
                            <td><b>${items.itemid}</b></td>
                            <td>${items.itemname}</td>
                            <td>${items.tipe}</td>
                            <td>${items.kategori}</td>
                            <td>${items.satuan_po}</td>
                            <td>${items.satuan_stok}</td>
                            <td>${spesifikasi}</td>
                            <td><button type="button" class="btn btn-sm btn-info" onclick="edit_data('${items.itemid}')">Edit</button></td>
                            </tr>`
                    })

                   
                }else {
                    tb = tb + `<tr><td colspan="9" class="text-center"><p>Data tidak ditemukan</p></td></tr>`
                }

                $('#tbl-items').html(tb)
            }
        })
    }

    function show_tipe() {
        $.ajax({
            url: url_api + '/itemtype',
            type: 'post',
            success: function(res) {
                var opt = '<option value="">Tipe Item</option>'
                var data = res.data
                data.forEach(function(row, index) {
                    opt = opt + `<option value="${row.itemtypeid}">${row.itemtypename}</option>`
                })

                $('#tipe').html(opt)
            }
        })
    }

    
    function show_category() {
        $.ajax({
            url: url_api + '/itemcategory',
            type: 'post',
            success: function(res) {
                var opt = '<option value="">Kategori Item</option>'
                var data = res.data
                data.forEach(function(row, index) {
                    opt = opt + `<option value="${row.itemcategoryid}">${row.itemcategoryname}</option>`
                })

                $('#kategori').html(opt)
            }
        })
    }

    function show_measure_po() {
        $.ajax({
            url: url_api + '/itemmeasure',
            type: 'post',
            success: function(res) {
                var data = res.data
                var opt = '<option value="">Satuan PO</option>'
                data.forEach(function(items, index) {
                    opt = opt + `<option value="${items.itemmeasureid}">${items.itemmeasurename} | ${items.itemmeasuredescr}</option>`
                })

                $('#satuan_po').html(opt)
            }
        })
    }

    
    function show_measure_stock() {
        $.ajax({
            url: url_api + '/itemmeasure',
            type: 'post',
            success: function(res) {
                var data = res.data
                var opt = '<option value="">Satuan Stok</option>'
                data.forEach(function(items, index) {
                    opt = opt + `<option value="${items.itemmeasureid}">${items.itemmeasurename} | ${items.itemmeasuredescr}</option>`
                })

                $('#satuan_stock').html(opt)
            }
        })
    }


    $('#tipe').on('change', function() {
        show_tables()
    })

    $('#kategori').on('change', function() {
        show_tables()
    })

    $('#satuan_po').on('change', function() {
        show_tables()
    })

    $('#satuan_stock').on('change', function() {
        show_tables()
    })

    $('#cari').on('keyup', function() {
        show_tables()
    })


    $(document).ready(function() {
        show_tables()
        show_tipe()
        show_category()
        show_measure_po()
        show_measure_stock()
    })
</script>
