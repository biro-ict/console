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
                        <div class="col-md-3 mb-3"><label>Kode Bank </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" maxlength="7" id="KodeBank">
                        </div>
                        <div class="col-md-3 mb-3"><label>Nama Bank</label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="NamaBank">
                        </div>
                        <div class="col-md-3 mb-3"><label>Kode Online </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" maxlength="3" id="KodeOnline">
                        </div>
                        <div class="col-md-3 mb-3"><label>Kode Kliring </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" maxlength="8" id="KodeKliring">
                        </div>
                        <div class="col-md-3 mb-3"><label>Kode RTGS </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" maxlength="10" id="KodeRTGS">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-outline-success" id="saveBank">
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
    $(document).ready(function(){
        var id = `<?php echo $id;?>`;
        if(id!=0) {
            $.ajax({
                url: url_api + '/bank/'+id,
                type: 'get',
                success: function(res) {
                    if(res.status == 'success') {
                        var data = res.data
                        data.forEach(function(items, index) {
                            $('#KodeBank').val(items.KodeBank)
                            $('#NamaBank').val(items.NamaBank)
                            $('#KodeOnline').val(items.KodeOnline)
                            $('#KodeKliring').val(items.KodeKliring)
                            $('#KodeRTGS').val(items.KodeRTGS)
                            $('#KodeBank').attr('readonly', 'readonly')
                        })
                    }
                }
            })
        }
    })

    $('#back').on('click', function() {
        window.location.reload()
    })

    $('#saveBank').on('click', function() {
        var kodebank = $('#KodeBank').val()
        var NamaBank = $('#NamaBank').val()
        var KdOnline = $('#KodeOnline').val()
        var KdKliring= $('#KodeKliring').val()
        var KodeRTGS = $('#KodeRTGS').val()

        if(kodebank == '' || kodebank == null) {
            return Swal.fire('Perhatian', 'Kode Bank masih kosong', 'warning')
        }

        if(NamaBank == '' || NamaBank==null) {
            return Swal.fire('Perhatian', 'Nama Bank masih kosong','warning')
        } 

        var id = `<?php echo $id;?>`;
        var path = id == 0 ? '/bank/add' : '/bank/update';

        Swal.fire({
            title:'Kamu yakin?',
            text: 'Kamu akan mengubah data ini',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ubah'
        }).then((result) => {
            if(result.isConfirmed) {
                $.ajax({
                    url: url_api + path,
                    type:'post',
                    data: {
                        KodeBank: kodebank,
                        NamaBank: NamaBank,
                        KodeOnline: KdOnline,
                        KodeKliring: KdKliring,
                        KodeRTGS: KodeRTGS
                    },
                    success: function(res) {
                        Swal.fire(res.title, res.message, res.status)
                        if(res.status=='success') location.reload()
                    }
                })
            }else{Swal.fire('Batal', 'Data batal diubah', 'error')}
        })
    })
</script>