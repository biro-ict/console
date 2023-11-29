<?php 
$user = isset($_GET['user']) ? $_GET['user'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : 0;
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Visitor</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nama :</label>
                            <select class="form-select form-select-sm" id="name" ></select> 
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>area:</label>
                            <select class="form-select form-select-sm" id="area" >
                                <option value="ho">Head Office</option>
                                <option value="kab">Kantor Area Barat</option>
                                <option value="kat">Kantor Area Timur</option>
                                <option value="btg">Bontang</option>
                            </select> 
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

        $.ajax({
            url: url_api + '/empl/all',
            type: 'get',
            success: function(res) {
                var opt = ''
                if(res.status == 'success') {

                    var data = res.data
                    data.forEach(function(row, index) {
                        opt = opt + `<option value="${row.username}">${row.fullname}</option>`
                    })
                }else{
                    opt = '<option>name not found</option>'
                }

                $('#name').html(opt)
            }
        })


        $.ajax({
            url: url_api + '/visitor/'+id,
            type: 'get',
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(row, index) {
                        $('#name').val(row.username)
                        $('#area').val(row.area)
                    })
                }
            }
        })

        console.log($('#name').val())
      
    })

    $('#formVisitor').on('click', function() {
    
        var id = `<?php echo $id;?>`;
        var url = id == 0 ? '/visitor/add' : '/visitor/update'


        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Data visitor akan diubah',
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
                        username: $('#name').val(),
                        area: $('#area').val(),
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