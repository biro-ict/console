<?php
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $title = $id == '0' ? 'Buat Mata Uang baru' : 'Ubah Mata Uang'
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
                        <div class="col-md-3 mb-3"><label>Kode </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="mataUang">
                        </div>
                        <div class="col-md-3 mb-3"><label>Nama </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="NamaMataUang">
                        </div>
                        <div class="col-md-3 mb-3"><label>Negara </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="Negara">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-outline-success" id="saveCurrency">
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

    $('#saveCurrency').on('click', function() {
        var id=`<?php echo $id;?>`;
        var url = id == 0 ? '/currency/add' : '/currency/update'
        if($('#mataUang').val() == '') {
            return Swal.fire('Peringatan', 'Kode Mata uang masih kosong', 'warning')
        }

        Swal.fire({
            title: 'Kamu yakin',
            text: 'Kamu akan mengubah Mata uang ini',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            cancelButtonColor: '#d33',
            confirmButtonTet: 'Ubah',
        }).then((result) => {
            if(result.isConfirmed) {
                $.ajax({
                    url: url_api + url,
                    type: 'post',
                    data: {
                        MataUang: $('#mataUang').val(),
                        NamaMataUang: $('#NamaMataUang').val(),
                        Negara: $('#Negara').val()
                    },
                    success: function(res) {
                        Swal.fire(res.title, res.message, res.status)
                        if(res.status=='success') location.reload()
                    }
                })
            }else{
                Swal.fire('Batal', 'Data batal diubah', 'warning')
            }
        })
    })

    $(document).ready(function() {
        var id=`<?php echo $id;?>`;
        if(id!=0){
            $.ajax({
                url: url_api+'/currency/'+id,
                type:'get',
                success: function(res) {
                    var data=res.data
                    data.forEach(function(items, row){
                        $('#mataUang').val(items.MataUang)
                        $('#NamaMataUang').val(items.NamaMataUang)
                        $('#Negara').val(items.Negara)
                        $('#mataUang').attr('readonly', 'readonly')
                    }) 
                }
            })
        }
    })
</script>