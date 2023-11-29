<?php
    $id = isset($_GET['id']) ? $_GET['id'] : '-';
    $user = isset($_GET['user']) ? $_GET['user'] : '';
    $title = $id == '0' ? 'Buat data item baru' : 'Ubah item';
?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 col-md-12 order-1 mb-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                   <?php echo $title;?>
                </div>
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-3 mb-3"><label>Id Item </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="itemid" readonly>
                        </div>
                        <div class="col-md-3 mb-3"><label>Nama </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="itemname">
                        </div>
                        <div class="col-md-3 mb-3"><label>Tipe </label></div>
                        <div class="col-md-9 mb-3">
                            <select type="text" class="form-select form-select-sm" id="itemtype"></select>
                        </div>
                        <div class="col-md-3 mb-3"><label>Kategori </label></div>
                        <div class="col-md-9 mb-3">
                            <select type="text" class="form-select form-select-sm" id="itemcategory"></select>
                        </div>
                        <div class="col-md-3 mb-3"><label>Satuan PO </label></div>
                        <div class="col-md-9 mb-3">
                            <select type="text" class="form-select form-select-sm" id="satuan_po"></select>
                        </div>
                        <div class="col-md-3 mb-3"><label>Satuan Stok </label></div>
                        <div class="col-md-9 mb-3">
                            <select type="text" class="form-select form-select-sm" id="satuan_stok"></select>
                        </div>
                        <div class="col-md-3 mb-3"><label>Spesifikasi </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="usertext">
                        </div>
                        
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-outline-success" id="saveItem">
                        Simpan
                    </button>
                    <button type="button" class="btn btn-outline-danger" id="back">
                        Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#back').on('click', function() {
        window.location.reload()
    })

    function setNomor() {
        $.ajax({
            url : url_api + '/lastid_item',
            type: 'get',
            success: function (res) {
                $('#itemid').val(res.data)
            }
        })
    }

    $('#saveItem').on('click', function() {
        var id = `<?php echo $id;?>`;
        var updatedby = `<?php echo $user;?>`;
        var url = id == '-' ? url_api + '/item/add' : url_api + '/item/update'

        var name = $('#itemname').val()
        if(name == '') {
            return Swal.fire('Oopss', 'Kamu belum mengisi nama.', 'warning')
        }

        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Kamu akan mengubah data ini',
            icon: 'warning',
            showCancelButton: true, 
            cancelButtonText: 'Batal',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ubah'
        }).then((result) => {
            if(result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        itemid: $('#itemid').val(),
                        itemcategory: $('#itemcategory').val(),
                        itemtype: $('#itemtype').val(),
                        itemmeasureid_buy: $('#satuan_po').val(),
                        itemmeasureid_base: $('#satuan_stok').val(),
                        itemname: $('#itemname').val(),
                        usertext: $('#usertext').val(),
                        updatedby: updatedby
                    },
                    success: function(res) {
                        Swal.fire(res.title, res.message, res.status)
                        if(res.status == 'success') {location.reload();} else{setNomor();}
                    }
                })
            }else {
                Swal.fire('Batal', 'Kamu membatalkan form ini', 'error')
            }
        })
    })

    $(document).ready(function() {
        var id = `<?php echo $id;?>`;
        var updatedby = `<?php echo $user;?>`;

        //item type
        $.ajax({
            url: url_api + '/itemtype',
            type: 'post',
            success: function(res) {
                var data = res.data
                var opt = ''
                data.forEach(function(items, index) {
                    opt = opt + `<option value="${items.itemtypeid}">${items.itemtypename} | ${items.itemtypedescr}</option>`
                })

                $('#itemtype').html(opt)
            }
        })

         //item kategori
         $.ajax({
            url: url_api + '/itemcategory',
            type: 'post',
            success: function(res) {
                var data = res.data
                var opt = ''
                data.forEach(function(items, index) {
                    opt = opt + `<option value="${items.itemcategoryid}">${items.itemcategoryname}</option>`
                })

                $('#itemcategory').html(opt)
            }
        })

         //item satuan PO
         $.ajax({
            url: url_api + '/itemmeasure',
            type: 'post',
            success: function(res) {
                var data = res.data
                var opt = ''
                data.forEach(function(items, index) {
                    opt = opt + `<option value="${items.itemmeasureid}">${items.itemmeasurename} | ${items.itemmeasuredescr}</option>`
                })

                $('#satuan_po').html(opt)
            }
        })

         //item satuan stok
         $.ajax({
            url: url_api + '/itemmeasure',
            type: 'post',
            success: function(res) {
                var data = res.data
                var opt = ''
                data.forEach(function(items, index) {
                    opt = opt + `<option value="${items.itemmeasureid}">${items.itemmeasurename} | ${items.itemmeasuredescr}</option>`
                })

                $('#satuan_stok').html(opt)
            }
        })

        if(id == '-') {
            setNomor()
        }else{
            $.ajax({
                url: url_api + '/item/'+id,
                type: 'get',
                success: function(res) {
                    var data = res.data
                    data.forEach(function(items, index) {
                        $('#itemid').val(items.itemid)
                        $('#itemname').val(items.itemname)
                        $('#itemtype').val(items.itemtypeid)
                        $('#itemcategory').val(items.itemcategoryid)
                        $('#satuan_po').val(items.itemmeasureid_buy)
                        $('#satuan_stok').val(items.itemmeasureid_base)
                        $('#usertext').val(items.usertext)
                    })
                }
            })
        }
    })
</script>