<?php 
$user   = isset($_GET['user']) ? $_GET['user'] : ''; 
$id     = isset($_GET['id']) ? $_GET['id'] : 0;
$title  = $id == 0 ? "Buat" : "Ubah";
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Grade</h4>
                </div>
                <main class="card-body mt-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nama :</label>
                            <input type="text" class="form-control form-control-sm" id="name" required> 
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Kode:</label>
                            <input type="text" class="form-control form-control-sm" id="code" required> 
                        </div>
                
                    </div>
                </main>

                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-sm btn-success" id="formsGrade"><?php echo $title;?></button>
                    <button class="btn btn-danger btn-sm" id="backto">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#backto').on('click', function () {
        location.reload()
    })

    $('#formsGrade').on('click', function() {
        var id = `<?php echo $id;?>`;
        let api = id == 0 ? '/grade/add' : '/grade/update'
        

        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Kamu akan mengubah data ini',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: '<?php echo  $title;?>',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if(result.isConfirmed) {
                $.ajax({
                    url: url_api + api,
                    type: 'post',
                    data: {
                        id: id,
                        name: $('#name').val(),
                        code: $('#code').val()
                    },
                    success: function(res) {
                        Swal.fire(res.title, res.message, res.status) 
                        if(res.status == 'success') setInterval(function(){location.reload()},3000)
                    }
                })
            }else {
                Swal.fire('Batal', 'Batal mengubah data', 'warning')
            }
        })
    })

    $(document).ready(function() {
        var id = `<?php echo $id;?>`;
        if(id != 0) {
            $.ajax({
                url: url_api + '/grade/'+ id,
                type: 'get',
                success: function(res) {
                    var data = res.data
                    data.forEach(function(items, index) {
                        $('#name').val(items.gradeName)
                        $('#code').val(items.gradeCode)
                    })
                }
            })
        }
    })

    
</script>