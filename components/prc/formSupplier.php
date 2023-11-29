<?php
    $id = isset($_GET['id']) ? $_GET['id'] : '-';
    $user = isset($_GET['user']) ? $_GET['user'] : '';
    $title = $id == '-' ? 'Buat data Supplier baru' : 'Ubah Supplier item';
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
                        <div class="col-md-3 mb-3"><label>Id Supplier </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="supplierid" readonly>
                        </div>
                        <div class="col-md-3 mb-3"><label>Nama </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="suppliername">
                        </div>
                        <div class="col-md-3 mb-3"><label>Group </label></div>
                        <div class="col-md-9 mb-3">
                            <select  size="3" class="js-states form-control" id="groupsupplier"></select>
                        </div>
                        <div class="col-md-3 mb-3"><label>Alamat </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="alamat">
                        </div>
                        <div class="col-md-3 mb-3"><label>Kode Pos </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="">
                        </div>
                        <div class="col-md-3 mb-3"><label>Telp </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="telp">
                        </div>
                        <div class="col-md-3 mb-3"><label>HP </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="nohp">
                        </div>
                        <div class="col-md-3 mb-3"><label>Fax </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="fax">
                        </div>
                        <div class="col-md-3 mb-3"><label>email </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="email">
                        </div>
                        <div class="col-md-3 mb-3"><label>Catatan </label></div>
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control form-control-sm" id="notes">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-outline-success" id="saveSupplier">
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
            url: url_api + '/lastid_supplier',
            type: 'get',
            success: function(res) {
                if(res.status == 'success') $('#supplierid').val(res.data)
            }
        })
    }

    function load_group(){
        $.ajax({
            url: url_api + '/groupsupplier',
            type: 'get',
            success: function(res) {
                var data = res.data
                var opt
                data.forEach(function(items, index) {
                    opt = opt + `<option value="${items.bpgroupid}">${items.bpgroupname}</option>`
                })

                $('#groupsupplier').html(opt)
            }
        })
    }

    $('#saveSupplier').on('click', function() {
        var id = `<?php echo $id;?>`;
        var users = `<?php echo $user;?>`;

        var url = id == '-' ? url_api + '/supplier/add' : url_api + '/supplier/update'

        $.ajax({
            url: url,
            type: 'post',
            data: {
                id: $('#supplierid').val(),
                name: $('#suppliername').val(),
                group: $('#groupsupplier').val(),
                alamat: $('#alamat').val(),
                kodepos: $('#kodepos').val(),
                telp: $('#telp').val(),
                nohp: $('#nohp').val(),
                fax: $('#fax').val(),
                mail: $('#email').val(),
                notes: $('#notes').val(),
                updatedby: users,

            },
            success: function(res) {
                swal.fire(res.title, res.message, res.status)
                if(res.status == 'success') location.reload()
            }

        })
    })



    $(document).ready(function() {
        var id = `<?php echo $id;?>`;
        load_group()

        $('#groupsupplier').select2({  
            placeholder: 'Pilih Group',
            multiple: true,
            width: '100%',
            dropdownAutoWidth: true
           
        })

        if(id == '-') {
            setNomor()
        }else{
            $.ajax({
                url: url_api + '/supplier/' +id,
                type: 'get',
                success: function(res) {
                    if(res.status == 'success') {
                        var data = res.data
                        data.forEach(function(item, index) {
                            var group = item.bpgroupid.split(';')
                            console.log(group)
                            $('#supplierid').val(item.cardcode)
                            $('#suppliername').val(item.cardname)
                            $('#groupsupplier').val(group).trigger('change')
                            $('#alamat').val(item.address)
                            $('#kodepos').val(item.zipcode)
                            $('#telp').val(item.phone1)
                            $('#nohp').val(item.cellular)
                            $('#fax').val(item.fax)
                            $('#email').val(item.mailaddres)
                            $('#notes').val(item.notes)
                        })
                    }
                }
            })
        }
    })

</script>