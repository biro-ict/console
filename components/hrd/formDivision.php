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
                    <h4 class="text-title text-white">Data Divisi</h4>
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
                        <div class="col-md-6 mb-3">
                            <label>Direktorat:</label>
                            <select class="form-select form-select-sm" id="direktorat" > </select>
                        </div>
                        
                    </div>
                </main>

                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-sm btn-success" id="formDivisions"><?php echo $title;?></button>
                    <button class="btn btn-danger btn-sm" id="backto">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            url: url_api + '/dir/search',
            type: 'post',
            success: function(res) {
                var option = ''
                if(res.status=='success') {
                    var data = res.data
                    data.forEach(function(items, rows) {
                        option = option + `<option value="${items.id}">${items.name}  [${items.orgName}]</option>`
                    })
                }

                $('#direktorat').html(option)
            }
        })
    })

    $('#formDivisions').on('click', function() {
        let code = $('#code').val()
        let name = $('#name').val()
        let dirs = $('#direktorat').val()
        let id = `<?php echo $id;?>`;
        let action = id == 0 ? '/division/add' : '/division/update'

        let isValidate = false
        isValidate = (code != '' && name != '') ? true : false;
        if(isValidate) {
            Swal.fire({
                title: 'Kamu yakin?',
                text: 'Data ini akan kamu <?php echo $title;?>',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: '<?php echo $title;?>',
                cancelButtonText: 'Batal',
            }).then((result) => {
                
                if(result.isConfirmed) {
                    $.ajax({
                        url: url_api + action,
                        type: 'post',
                        data: {
                            divisionName: name,
                            divisiCode: code,
                            dirId: dirs,
                            id: id
                        },
                        success: function(res) {
                            Swal.fire(res.title, res.message, res.status)
                            if(res.status == 'success') location.reload()
                        }
                    })
                } else {
                    Swal.fire('Batal', 'Batal mengubah data', 'warning')
                }
            })
        }else {
            return Swal.fire('Peringatan', 'Masih ada data yang kosong' , 'warning')
        }
    

    })
</script>