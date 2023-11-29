<?php
    $id = isset($_GET['id']) ? $_GET['id'] : '-';
    $user = isset($_GET['user']) ? $_GET['user'] : '';
    $title = $id == '0' ? 'Buat data kategori item baru' : 'Ubah kategori item';
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
                        <div class="col-md-3 mb-3"><label>Id kategori Item </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="itemcategoryid" readonly>
                        </div>
                        <div class="col-md-3 mb-3"><label>Nama </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="itemcategoryname">
                        </div>
                        <div class="col-md-3 mb-3"><label>Keterangan </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="itemcategorydescr">
                        </div>
                        
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-outline-success" id="saveItemcategory">
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
            url : url_api + '/lastid_category',
            type: 'get',
            success: function (res) {
                $('#itemcategoryid').val(res.data)
            }
        })
    }

    $('#saveItemcategory').on('click', function() {
        var id = `<?php echo $id;?>`;
        var updatedby = `<?php echo $user;?>`;
        var url = id == '-' ? url_api + '/itemcategory/add' : url_api + '/itemcategory/update'

        var name = $('#itemcategoryname').val()
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
                        id: $('#itemcategoryid').val(),
                        name: $('#itemcategoryname').val(),
                        descr: $('#itemcategorydescr').val(),
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

        if(id == '-') {
            setNomor()
        }else{
            $.ajax({
                url: url_api + '/itemcategory/'+id,
                type: 'get',
                success: function(res) {
                    var data = res.data
                    data.forEach(function(items, index) {
                        $('#itemcategoryid').val(items.itemcategoryid)
                        $('#itemcategoryname').val(items.itemcategoryname)
                        $('#itemcategorydescr').val(items.itemcategorydescr)
                    })
                }
            })
        }
    })
</script>