<?php 
$user = isset($_GET['user']) ? $_GET['user'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$title  = $id == 0 ? "Buat" : "Ubah";
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Departemen</h4>
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
                            <label>Direktorat:</label>
                            <select class="form-select form-select-sm" id="direktorat" > </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Divisi:</label>
                            <select class="form-select form-select-sm" id="division" > </select>
                        </div>
                    </div>
                </div>

                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-sm btn-success" id="formDirs"><?php echo $title;?></button>
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
            url: url_api + '/dir/search',
            type: 'post',
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data 
                    data.forEach(function(row, index) {
                        opt = opt + `<option value="${row.id}">${row.name} - ${row.orgName}</option>`
                    });
                }else {
                    opt = '<option>No Directorate Found</option>'
                }

                $('#direktorat').html(opt)
            }
            
        })

        var divisi = ''

        $.ajax({
            url: url_api + '/division/search',
            type: 'post',
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data 
                    data.forEach(function(row, index) {
                        divisi = divisi + `<option value="${row.id}">${row.divisionName}</option>`
                    });
                }else {
                    divisi = '<option>No Division Found</option>'
                }

                $('#division').html(divisi)
            }
            
        })


        var user = `<?php echo $user;?>`;
        var id = `<?php echo $id;?>`;
        $.ajax({
            url: url_api + '/depts/'+id,
            type: 'get', 
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(row, index) {
                        $('#name').val(row.name)
                        $('#code').val(row.code)
                        $('#direktorat').val(row.dirId)
                        $('#division').val(row.divId)
                    })
                }
            }
        })

    
    })

    $('#formDirs').on('click', function() {
        var formdata = new FormData()
        var id = `<?php echo $id;?>`;

        var url = id == 0 ? '/depts/add' : '/depts/update'


        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Data Departemen akan diubah',
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
                        dirid: $('#direktorat').val(),
                        divid: $('#division').val(),
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