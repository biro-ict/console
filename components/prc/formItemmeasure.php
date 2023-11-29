<?php
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $user = isset($_GET['user']) ? $_GET['user'] : '';
    $title = $id == '0' ? 'Buat data satuan item baru' : 'Ubah satuan item';
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
                        <div class="col-md-3 mb-3"><label>Id Satuan Item </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="itemmeasureid" readonly>
                        </div>
                        <div class="col-md-3 mb-3"><label>Nama </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="itemmeasurename">
                        </div>
                        <div class="col-md-3 mb-3"><label>Keterangan </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="itemmeasuredescr">
                        </div>
                        
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-outline-success" id="saveItemmeasure">
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
    function setNomor() {
        $.ajax({
            url : url_api + '/lastid_itemmeasure',
            type: 'get',
            success: function (res) {
                $('#warehouseid').val(res.data)
            }
        })
    }

    $('#back').on('click', function() {
        window.location.reload()
    })


    $('#saveItemmeasure').on('click', function() {
        var id = `<?php echo $id;?>`;
        var connuser = `<?php echo $user;?>`;

        var url = id == 0 ? '/itemmeasure/add' : '/itemmeasure/update';

        if($('#itemmeasurename').val() == '') {
            return Swal.fire('Peringatan', 'Harap isi nama terlebih dulu', 'warning')
        }


        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Kamu akan mengubah data ini?',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batal!',
            confirmButtonText: 'Ubah',
        }).then((result) => {
            if(result.isConfirmed) {
                $.ajax({
                    url: url_api + url, 
                    type: 'post',
                    data: {
                        id: $('#itemmeasureid').val(),
                        name: $('#itemmeasurename').val(),
                        descr: $('#itemmeasuredescr').val(),
                        updatedby: connuser,
                    },
                    success: function(res) {
                        Swal.fire(res.title, res.message, res.status)
                        if(res.status == 'success') { location.reload() } else {setNomor() } 
                    }
                })
            }else {
                Swal.fire('Batal', 'Batal mengubah data', 'error')
            }
        })

    })

    $(document).ready(function() {
        var id = `<?php echo $id;?>`;
        if(id != 0) {
            $.ajax({
                url: url_api + '/itemmeasure/' + id,
                type: 'get',
                success: function(res) {
                    var data = res.data
                    data.forEach(function(items, index) {
                        $('#itemmeasureid').val(items.itemmeasureid)
                        $('#itemmeasurename').val(items.itemmeasurename)
                        $('#itemmeasuredescr').val(items.itemmeasuredescr)
                    })
                }
            })
        }else{

            setNomor()
        }
    })
</script>