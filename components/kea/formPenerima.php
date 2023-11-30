<?php
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $title = $id == '0' ? 'Buat Penerima baru' : 'Ubah Penerima'
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
                        <div class="col-md-3 mb-3"><label>Penerima</label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm"  id="penerima">
                        </div>
                        <div class="col-md-3 mb-3"><label>Perusahaan </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="perusahaan">
                        </div>
                        <div class="col-md-3 mb-3"><label>Bagian </label></div>
                        <div class="col-md-9 mb-3">
                            <select type="text" class="form-select form-select-sm" id="bagian">
                                <option value="1">Perorangan</option>
                                <option value="2">Perusahaan</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3"><label>NPWP </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="npwp">
                        </div>
                        <div class="col-md-3 mb-3"><label>Alamat 1 </label></div>
                        <div class="col-md-9 mb-3">
                            <textarea type="text" class="form-control form-control-sm" id="alamat_1"></textarea>
                        </div>
                        <div class="col-md-3 mb-3"><label>Alamat 2 </label></div>
                        <div class="col-md-9 mb-3">
                            <textarea type="text" class="form-control form-control-sm" id="alamat_2"></textarea>
                        </div>
                        <div class="col-md-3 mb-3"><label>Alamat 3 </label></div>
                        <div class="col-md-9 mb-3">
                            <textarea type="text" class="form-control form-control-sm" id="alamat_3"></textarea>
                        </div>
                        <div class="col-md-3 mb-3"><label>Kode Bank IDR </label></div>
                        <div class="col-md-9 mb-3">
                            <select  class="form-select form-select-sm" id="KodeBankIDR"></select>
                        </div>
                        <div class="col-md-3 mb-3"><label>Nama Bank </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="bank">
                        </div>
                        <div class="col-md-3 mb-3"><label>No. Rekening </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="noRek">
                        </div>
                        
                        
                        <div class="col-md-3 mb-3"><label>Kode Bank USD </label></div>
                        <div class="col-md-9 mb-3">
                            <select  class="form-select form-select-sm" id="KodeBankUSD"></select>
                        </div> 
                        <div class="col-md-3 mb-3"><label>Nama Bank USD </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="bankUSD">
                        </div>

                        <div class="col-md-3 mb-3"><label>No. Rekening USD </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="noRekUSD">
                        </div>
                        <div class="col-md-3 mb-3"><label>Email </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="mail">
                            <p style="font-size: small;font-style: italic; color: red;">Pemisah menggunakan ;</p>
                        </div>
                       

                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-outline-success" id="savePenerima">
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

    $('#savePenerima').on('click', function() {
        var id = `<?php echo $id;?>`;
        if($('#penerima').val() == '' ) {
            return Swal.fire('Peringatan', 'Harap isi penerima terlebih dulu', 'warning')
        }

        if($('#perusahaan').val() == '' ) {
            return Swal.fire('Peringatan', 'Harap isi perusahaan terlebih dulu', 'warning')
        }

        var url = id == 0 ? '/penerima/add' : '/penerima/update'

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
                    url: url_api + url,
                    type: 'post',
                    data: {
                        npwp_id: id,
                        penerima: $('#penerima').val(),
                        Perusahaan: $('#perusahaan').val(),
                        isPerson: $('#bagian').val(),
                        npwp: $('#npwp').val(),
                        alamat_1: $('#alamat_1').val(),
                        alamat_2: $('#alamat_2').val(),
                        alamat_3: $('#alamat_3').val(),
                        KodeBankIDR: $('#KodeBankIDR').val(),
                        NoRek: $('#noRek').val(),
                        Bank: $('#bank').val(),
                        KodeBankUSD: $('#KodeBankUSD').val(),
                        BankUSD: $('#bankUSD').val(),
                        NoRekUSD: $('#noRekUSD').val(),
                        mail: $('#mail').val()
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

    $('#KodeBankIDR').on('change', function() {
        $('#bank').val($('#KodeBankIDR option:selected').attr('name'))
    })

    $('#KodeBankUSD').on('change', function() {
        $('#bankUSD').val($('#KodeBankUSD option:selected').attr('name'))
    })

    $(document).ready(function() {
        var id = `<?php echo $id;?>`;

        $.ajax({
            url: url_api + '/bank',
            type: 'get',
            success: function(res) {
                if(res.status == 'success') {
                    var opt = "<option value=''>Kosong</option>"
                    var data = res.data
                    data.forEach(function(items, index) {
                        opt = opt + `<option value="${items.KodeBank}" name="${items.NamaBank}">${items.NamaBank} (${items.KodeBank})</option>`

                    })

                    $('#KodeBankUSD').html(opt)
                    $('#KodeBankIDR').html(opt)
                }
            }
        })

        if(id != 0) {
            $.ajax({
                url: url_api + '/penerima/'+id,
                type: 'get',
                success: function(res) {
                    if(res.status == 'success') {
                        var data = res.data
                        data.forEach(function(items, index) {
                            $('#penerima').val(items.penerima)
                            $('#perusahaan').val(items.Perusahaan)
                            $('#bagian').val(items.isPerson)
                            $('#npwp').val(items.npwp)
                            $('#alamat_1').val(items.alamat_1)
                            $('#alamat_2').val(items.alamat_2)
                            $('#alamat_3').val(items.alamat_3)
                            $('#KodeBankIDR').val(items.KodeBankIDR)
                            $('#bank').val(items.Bank)
                            $('#noRek').val(items.NoRek)
                            $('#KodeBankUSD').val(items.KodeBankUSD)
                            $('#bankUSD').val(items.BankUSD)
                            $('#noRekUSD').val(items.NoRekUSD)
                            $('#mail').val(items.Mail)
                        })
                        
                    }
                }
            })
        }
    })
</script>