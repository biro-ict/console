<?php
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $title = $id == '0' ? 'Buat Datasource baru' : 'Ubah Datasource'
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
                        <div class="col-md-3 mb-3"><label>Datasource</label></div>
                        <div class="col-md-9 mb-3">
                            <input type="number" class="form-control form-control-sm" min="1" id="datasource">
                        </div>
                        <div class="col-md-3 mb-3"><label>Nama </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="datasourcename">
                        </div>
                        <div class="col-md-3 mb-3"><label>Deskripsi </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="datasourcedescr">
                        </div>
                        <div class="col-md-3 mb-3"><label>Approval oleh </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="approved">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-outline-success" id="saveDatasource">
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

    $('#saveDatasource').on('click', function() {
        var datasource  = $('#datasource').val()
        var name        = $('#datasourcename').val()
        var deskripsi   = $('#datasourcedescr').val()
        var approved    = $("#approved").val()

        var id = `<?php echo $id;?>`;
        var url = id == 0 ? url_api + '/datasource/add' : url_api+'/datasource/update'
        var form = $('.form-control').val()
        if(form == '') {

            Swal.fire('Peringatan', 'harap isi bagian yang kosong', 'warning')
            console.log(form)
        }else{
            Swal.fire({
                title: 'Kamu yakin?',
                text: 'Kamu akan mengubah datasource ini',
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
                            datasource: datasource,
                            datasourcename: name,
                            datasourcedescr: deskripsi,
                            approved: approved

                        },
                        success: function(res) {
                            Swal.fire(res.title, res.message, res.status)
                            if(res.status == 'success') location.reload() 
                        }
                    })
                }else {
                    Swal.fire('Batal', 'Data batal diubah', 'warning')
                }
            })
        }

    })

    $(document).ready(function() {
        var id = `<?php echo $id;?>`;

        if(id != 0) {
            $.ajax({
                url: url_api + '/datasource/'+id,
                type: 'get',
                success: function(res) {
                    if(res.status == 'success') {
                        var data = res.data
                        data.forEach(function(items, row) {
                            $('#datasource').val(items.DataSource)
                            $('#datasourcename').val(items.DataSourceName)
                            $('#datasourcedescr').val(items.DataSourceDescr)
                            $("#approved").val(items.Approved)
                            $('#datasource').attr('readonly', true)
                        })
                    }
                }
            })
        }
    })
</script>