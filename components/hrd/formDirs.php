<?php 
$user = isset($_GET['user']) ? $_GET['user'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : 0;
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Direktorat</h4>
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
                            <label>Organisasi:</label>
                            <select class="form-select form-select-sm" id="organisasi" > </select>
                        </div>
                        
                    </div>
                </div>

                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-sm btn-success" id="formDirs">Ubah</button>
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
        var opt = ''

        $.ajax({
            url: url_api + '/orgz/all',
            type: 'get',
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data 
                    data.forEach(function(row, index) {
                        opt = opt + `<option value="${row.id}">${row.name}</option>`
                    });
                }else {
                    opt = '<option>No Organizations Found</option>'
                }

                $('#organisasi').html(opt)
            }
            
        })


        var user = `<?php echo $user;?>`;
        var id = `<?php echo $id;?>`;
        $.ajax({
            url: url_api + '/dirs/'+id,
            type: 'get', 
            success: function(res) {
                if(res.status == 'success') {
                    console.log(res.data)
                    var data = res.data
                    data.forEach(function(row, index) {
                        $('#name').val(row.name)
                        $('#code').val(row.code)
                        $('#organisasi').val(row.orgId)
                    })
                }
            }
        })

    
    })

    $('#formDirs').on('click', function() {
        var formdata = new FormData()
        var id = `<?php echo $id;?>`;

        var url = id == 0 ? '/dir/add' : '/dir/update'


        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Data direktorat akan diubah',
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
                        orgId: $('#organisasi').val(),
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