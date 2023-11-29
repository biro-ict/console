<?php
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $title = $id == '0' ? 'Buat Rekening baru' : 'Ubah Rekening'
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
                    <div class="col-md-3 mb-3"><label>Kode Bank </label></div>
                        <div class="col-md-9 mb-3">
                            <select  class="form-select form-select-sm" id="KodeBank"></select>
                        </div>
                        <div class="col-md-3 mb-3"><label>No. Rekening </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="noRek">
                        </div>
                        <div class="col-md-3 mb-3"><label>Mata Uang </label></div>
                        <div class="col-md-9 mb-3">
                            <select type="text" class="form-select form-select-sm" id="currency"></select>
                        </div>
                        <div class="col-md-3 mb-3"><label>Branch </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="branch">
                        </div>
                        <div class="col-md-3 mb-3"><label>Pemilik </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="pemilik">
                        </div>
                        <div class="col-md-3 mb-3"><label>Mata Anggaran  </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="mataanggaran">
                        </div>
                        <div class="col-md-3 mb-3"><label>BM Prefix </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" value="BM" id="bm_prefix">
                        </div>
                        <div class="col-md-3 mb-3"><label>BK Trefix </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" value="BK" id="bk_prefix">
                        </div>
                        <div class="col-md-3 mb-3"><label>TR Trefix </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" value="TR" id="tr_prefix">
                        </div>
                        <div class="col-md-3 mb-3"><label>DataSource </label></div>
                        <div class="col-md-9 mb-3">
                            <select type="text" class="form-select form-select-sm" id="datasource"></select>
                        </div>
                      
                       

                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-outline-success" id="saveRekening">
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

    $('#saveRekening').on('click', function() {
        var id = `<?php echo $id;?>`;
        if($('#noRek').val() == '') {
            return Swal.fire('Peringatan', 'Nomor rekening masih kosong', 'warning')
        }

        var url = id == 0 ? url_api+'/rekening/add' : url_api+'/rekening/update'

        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Kamu akan mengubah data ini',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Ubah'
        }).then((result) => {
            if(result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                      KodeBank: $('#KodeBank').val(),
                      NoRekening: $('#noRek').val(),
                      MataUang: $('#currency').val(),
                      Branch: $('#branch').val(),
                      Pemilik: $('#pemilik').val(),
                      MataAnggaran: $('#mataanggaran').val(),
                      BM_Prefix: $('#bm_prefix').val(),
                      BK_Prefix: $('#bk_prefix').val(),
                      TR_Prefix: $('#tr_prefix').val(),
                      DataSource: $('#datasource').val(),  
                    },
                    success: function(res) {
                        Swal.fire(res.title, res.message, res.status)
                        if(res.status == 'success') location.reload()
                    }
                })
            }else{
                Swal.fire('Batal', 'Batal mengubah data', 'error')
            }
        })
    })

    $(document).ready(function() {
        var id = `<?php echo $id;?>`;

        $.ajax({
            url: url_api + '/bank',
            type: 'get',
            success: function(res) {
                if(res.status == 'success') {
                    var opt = ''
                    var data = res.data
                    data.forEach(function(items, index) {
                        opt = opt + `<option value="${items.KodeBank}">${items.NamaBank} (${items.KodeBank})</option>`

                    })

                    $('#KodeBank').html(opt)
                }
            }
        })

        $.ajax({
            url: url_api + '/datasource',
            type: 'post',
            success: function(res) {
                if(res.status == 'success') {
                    var opt = ''
                    var data = res.data
                    data.forEach(function(items, index) {
                        opt = opt + `<option value="${items.DataSource}">${items.DataSource} (${items.DataSourceName})</option>`
                    })

                    $('#datasource').html(opt)
                }
            }
        })

        $.ajax({
            url: url_api + '/currency',
            type: 'post',
            success: function(res) {
                if(res.status == 'success') {
                    var opt = ''
                    var data = res.data
                    data.forEach(function(items, index) {
                        opt = opt + `<option value="${items.MataUang}">${items.NamaMataUang}</option>`
                    })

                    $('#currency').html(opt)
                }
            }
        })

        if(id != 0) {
            $.ajax({
                url: url_api + '/rekening/'+id,
                type: 'get',
                success: function(res) {
                    var data = res.data
                    data.forEach(function(items, index){
                        $('#KodeBank').val(items.KodeBank)
                        $('#noRek').val(items.NoRekening)
                        $('#currency').val(items.MataUang)
                        $('#branch').val(items.Branch)
                        $('#pemilik').val(items.Pemilik)
                        $('#mataanggaran').val(items.MataAnggaran)
                        $('#bm_prefix').val(items.BM_Prefix)
                        $('#bk_prefix').val(items.BK_Prefix)
                        $('#tr_prefix').val(items.TR_Prefix)
                        $('#datasource').val(items.DataSource)
                        $('#noRek').attr('readonly', true)
                       
                    })
                }
            })
        }
    })
</script>