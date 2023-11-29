<?php
    $id = isset($_GET['id']) ? $_GET['id'] : '-';
    $user = isset($_GET['user']) ? $_GET['user'] : '';
    $title = $id == '-' ? 'Buat data Termin pembayaran baru' : 'Ubah Termin pembayaran item';
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
                        <div class="col-md-3 mb-3"><label>Id kategori Item </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="paymenttermid" readonly>
                        </div>
                        <div class="col-md-3 mb-3"><label>Nama </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="paymenttermname">
                        </div>
                        <div class="col-md-3 mb-3"><label>Keterangan </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="paymenttermdescr">
                        </div>
                        
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-outline-success" id="savePayment">
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

    function setNomor() {
        $.ajax({
            url : url_api + '/lastid_paymentterm',
            type: 'get',
            success: function (res) {
                $('#paymenttermid').val(res.data)
            }
        })
    }

    $('#savePayment').on('click', function() {
        var id = `<?php echo $id;?>`;
        var updatedby = `<?php echo $user;?>`;
        var url = id == '-' ? url_api + '/paymentterm/add' : url_api + '/paymentterm/update'

        var name = $('#paymenttermname').val()
        if(name == '') {
            return Swal.fire('Oopss', 'Kamu belum mengisi nama.', 'warning')
        }

        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Kamu akan mengubah data ini',
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
                        id: $('#paymenttermid').val(),
                        name: $('#paymenttermname').val(),
                        descr: $('#paymenttermdescr').val(),
                        updatedby: updatedby
                    },
                    success: function(res) {
                        Swal.fire(res.title, res.message, res.status)
                        if(res.status == 'success') {location.reload();} else{setNomor();}
                    }
                })
            }else {
                Swal.fire('Batal', 'Kamu membatalkan form ini', 'error')
            }
        })
    })

    $(document).ready(function() {
        var id = `<?php echo $id;?>`;
        var updatedby = `<?php echo $user;?>`;

        if(id == '-') {
            setNomor()
        }else{
            $.ajax({
                url: url_api + '/paymentterm/'+id,
                type: 'get',
                success: function(res) {
                    var data = res.data
                    data.forEach(function(items, index) {
                        $('#paymenttermid').val(items.paymenttermid)
                        $('#paymenttermname').val(items.paymenttermname)
                        $('#paymenttermdescr').val(items.paymenttermdescr)
                    })
                }
            })
        }
    })
</script>