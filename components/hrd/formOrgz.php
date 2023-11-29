<?php 
$user = isset($_GET['user']) ? $_GET['user'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : 0;
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Organisasi</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nama :</label>
                            <input type="text" class="form-control form-control-sm" id="name" required> 
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Kode:</label>
                            <input type="text" class="form-control form-control-sm" id="code" required> 
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Alamat 1:</label>
                            <input type="text" class="form-control form-control-sm" id="address_one" > 
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Alamat 2:</label>
                            <input type="text" class="form-control form-control-sm" id="address_two"> 
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Telp:</label>
                            <input type="text" class="form-control form-control-sm"  id="telp"> 
                        </div>
                    </div>
                </div>

                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-sm btn-success" id="formOrgz">Ubah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="backto">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#backto').on('click', function () {
        location.reload()
    })
   
    $(document).ready(function() {
        var user = `<?php echo $user;?>`;
        var id = `<?php echo $id;?>`;
        $.ajax({
            url: url_api + '/orgz/'+id,
            type: 'get', 
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(row, index) {
                        $('#name').val(row.name)
                        $('#code').val(row.code)
                        $('#address_one').val(row.address_one)
                        $('#address_two').val(row.address_two)
                        $('#telp').val(row.telp)
                    })
                }
            }
        })
    })

    $('#formOrgz').on('click', function() {
        var formdata = new FormData()
        var id = `<?php echo $id;?>`;

        var url = id == 0 ? '/org/add' : '/org/update'


        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Data organisasi akan diubah',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0275d8',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ubah!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if(result.value) {
                $.ajax({
                    url: url_api + url,
                    type: 'post',
                    data: {
                        name: $('#name').val(),
                        code: $('#code').val(),
                        address_one: $('#address_one').val(),
                        address_two: $('#address_two').val(),
                        telp: $('#telp').val(),
                        id: id

                    },
                    success: function(res) {
                        Swal.fire(res.title, res.message, res.status)
                        if(res.status == 'success') location.reload()
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        Swal.fire('Ooops', thrownError, 'error')
                    }
                })
            }else {
                Swal.fire('Batal', 'Data batal diubah', 'error')
            }
        })
    })
</script>