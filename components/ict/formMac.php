<?php 
$user = isset($_GET['user']) ? $_GET['user'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Bypass Wifi</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>mac :</label>
                            <input class="form-control form-control-sm" id="mac" >
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>deskripsi :</label>
                            <input class="form-control form-control-sm" id="desc" >
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>ip :</label>
                            <input class="form-control form-control-sm" id="ipaddr" >
                        </div>
                      
                    </div>
                </div>

                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-sm btn-success" id="formVisitor">Ubah</button>
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
       
        if(id != '') $('#mac').attr('readonly', 'readonly')
        $.ajax({
            url: url_api + '/mac/'+id,
            type: 'get',
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(row, index) {
                        $('#mac').val(row.mac)
                        $('#desc').val(row.description)
                        $('#ipaddr').val(row.ipaddr)
                    })
                }
            }
        })
      
    })

    $('#formVisitor').on('click', function() {
    
        var id = `<?php echo $id;?>`;
        var url = id == '' ? '/mac/add' : '/mac/update'

        


        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Data mac akan diubah',
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
                        mac: $('#mac').val(),
                        desc: $('#desc').val(),
                        ipaddr: $('#ipaddr').val()
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