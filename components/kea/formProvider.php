<?php
    $id = isset($_GET['id']) ? $_GET['id'] : '-';
    $user = isset($_GET['user']) ? $_GET['user'] : '';
    $title = $id == '-' ? 'Buat data produsen baru' : 'Ubah produsen';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 col-md-12 order-1 mb-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <?php echo $title;?>
                </div>
                <div class="card-body mt-3">
                    <div class="row mt-3">
                         <div class="col-md-2 mb-3">
                            <label class="form-label">Kode Produsen: </label>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" id="providerID" class="form-control form-control-sm">
                        </div>

                        <div class="col-md-2 mb-3">
                            <label class="form-label">Nama Produsen: </label>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" id="providerName" class="form-control form-control-sm">
                        </div>
                    </div>
                 
                    <div class="row mt-3">
                         <div class="col-md-2 mb-3">
                            <label class="form-label">NPWP: </label>
                        </div>
                        <div class="col-md-10 mb-3">
                            <input type="text" id="providerNPWP" class="form-control form-control-sm">
                        </div>
                    </div>

                     <div class="row mt-3">
                         <div class="col-md-2 mb-3">
                            <label class="form-label">Alamat: </label>
                        </div>
                        <div class="col-md-10 mb-3">
                            <input type="text" id="providerAddress_1" class="form-control form-control-sm">
                        </div>
                   
                    </div>

                    <div class="row">
                        <div class="col-md-2 mb-3"></div>
                        <div class="col-md-10 mb-3">
                            <input type="text" id="providerAddress_2" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2 mb-3"></div>
                        <div class="col-md-10 mb-3">
                            <input type="text" id="providerAddress_3" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="row mt-3">
                         <div class="col-md-2 mb-3">
                            <label class="form-label">Telepon: </label>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" id="providerTelephone" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Fax: </label>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" id="providerFax" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="row mt-3">
                        
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-2 mb-3">
                            <label class="form-label">No Rekening USD: </label>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" id="providerRekeningUSD" class="form-control form-control-sm">
                        </div>

                        <div class="col-md-2 mb-3">
                            <label class="form-label">No Rekening Rupiah: </label>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" id="providerRekeningIDR" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Nama Bank USD: </label>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" id="providerNameBankUSD" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Nama Bank Rupiah: </label>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" id="providerNameBankIDR" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Nama Rekening USD: </label>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" id="providerRekeningNameUSD" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Nama Rekening Rupiah: </label>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" id="providerRekeningNameIDR" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Kode COA Gas: </label>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" id="coaGAS" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Kode COA Non Gas: </label>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" id="coaNonGas" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Dept ID : </label>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" id="DeptcoaGAS" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Dept ID: </label>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" id="DeptcoaNonGas" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Area Kode : </label>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" id="AreacoaGAS" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Area Kode: </label>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" id="AreacoaNonGas" class="form-control form-control-sm">
                        </div>
                    </div>


                </div>

                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-outline-success" id="saveProvider">
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

    $('#saveProvider').on('click', function() {
        var id = `<?php echo $id;?>`;
        var url = id == '-' ? '/provider/add' : '/provider/update'
        if($('#providerID').val() == '') {
            return Swal.fire('Ooopss', 'Kode Produsen masih kosong', 'warning')
        }

        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Kamu akan mengubah data yang ada',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ubah',
        }).then((result) => {
            if(result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        ProviderID: $('#providerID').val(),
                        Perusahaan: $('#providerName').val(),
                        NPWP: $('#providerNPWP').val(),
                        Alamat_1: $('#providerAddress_1').val(),
                        Alamat_2: $('#providerAddress_2').val(),
                        Alamat_3: $('#providerAddress_3').val(),
                        Telephone: $('#providerTelephone').val(),
                        Fax: $('#providerFax').val(),
                        Bank_USD: $('#providerNameBankUSD').val(),
                        Rekening_USD: $('#providerRekeningUSD').val(),
                        Pemilik_USD: $('#providerRekeningNameUSD').val(),
                        Bank_IDR: $('#providerNameBankIDR').val(),
                        Rekening_IDR: $('#providerNameBankIDR').val(),
                        Pemilik_IDR: $('#providerRekeningNameIDR').val(),
                        MataAnggaran: $('#coaGAS').val(),
                        DeptID: $('#DeptcoaGAS').val(),
                        AreaCode: $('#AreacoaGAS').val(),
                        COANonGas: $('#COANonGas').val(),
                        DeptNonGas: $('#DeptcoaNonGas').val(),
                        AreaNonGas: $('#AreacoaNonGas').val()
                    },
                    success: function(res) {
                        Swal.fire(res.title, res.message, res.status)
                        if(res.status == 'success') location.reload()
                    }
                })
            }else{
                Swal.fire('Batal', 'Data Batal diubah', 'warning')
            }
        })


    })

    $(document).ready(function() {
        var id = `<?php echo $id;?>`;
        if(id != '') {
            $.ajax({
                url: url_api + '/provider/'+id,
                type: 'get',
                success: function(res) {
                    if(res.status == 'success') {
                        var data = res.data
                        data.forEach(function(items, index) {
                            $('#providerID').val(items.ProviderID)
                            $('#providerName').val(items.Perusahaan)
                            $('#providerNPWP').val(items.NPWP)
                            $('#providerAddress_1').val(items.Alamat_1)
                            $('#providerAddress_2').val(items.Alamat_2)
                            $('#providerAddress_3').val(items.Alamat_3)
                            $('#providerTelephone').val(items.Telephone)
                            $('#providerFax').val(items.Fax)
                            $('#providerRekeningUSD').val(items.Rekening_USD)
                            $('#providerNameBankUSD').val(items.Bank_USD)
                            $('#providerRekeningNameUSD').val(items.Pemilik_USD)
                            $('#providerRekeningIDR').val(items.Rekening_IDR)
                            $('#providerNameBankIDR').val(items.Bank_IDR)
                            $('#providerRekeningNameIDR').val(items.Pemilik_IDR)
                            $('#coaGAS').val(items.MataAnggaran)
                            $('#DeptcoaGAS').val(items.DeptID)
                            $('#AreacoaGAS').val(items.AreaCode)
                            $('#coaNonGas').val(items.COANonGas)
                            $('#DeptcoaNonGas').val(items.DeptNonGas)
                            $('#AreacoaNonGas').val(items.AreaNonGas)
                            $('#providerID').attr('readonly', true)
                        })
                    }
                }
            })
        }
    })
</script>