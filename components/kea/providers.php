<?php $user = isset($_GET['user']) ? $_GET['user'] : '';?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Providers/Produsen</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row mb-3">
                        <div class="col-md-6"><input type="text" class="form-control form-control-sm" placeholder="Cari Berdasarkan Kode atau nama" id="cari"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mt-3">
                            <div class="table-responsive" style="height:400px;">
                                <table class="table table-sm table-hover table-striped caption-top">
                                    <thead style="background: white; position: sticky; top: 0;box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);">
                                        <th class="col">#</th>
                                        <th class="col">Kode Provider</th>
                                        <th class="col">Nama Perusahaan</th>
                                        <th class="col">NPWP</th>
                                        <th class="col">Rekening USD</th>
                                        <th class="col">Rekening IDR</th>
                                        <th class="col">COA Gas</th>
                                        <th class="col">COA Non Gas</th>
                                    </thead>
                                    <tbody id="tbl-providers"></tbody>

                                </table>
                            </div>
                            <caption>Total Produsen:<span id="total-produsen"></span></caption>
                        </div>
                    </div>
                </div>
                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="toFormadd">Tambah</button>
                    <button type="button" class="btn btn-info btn-sm" id="toFormsedit">Edit</button>
                    <button type="button" class="btn btn-danger btn-sm" id="toDelete">Hapus</button>
                    <button type="button" class="btn btn-secondary btn-sm" id="back">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#toFormadd").on('click', function() {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/kea/formProvider.php',
            type: 'get',
            data: {user:user},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
    })

    $('#toFormsedit').on('click', function() {
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih Provider terlebih dahulu',
                'warning'
            )
        }else if(totals > 1){
            Swal.fire(
                'Peringatan',
                'Harap pilih hanya satu Provider',
                'warning'
            )
        }else{
            var value = document.querySelector('.checked:checked').value
            var user = `<?php echo $user;?>`;
            $.ajax({
                url: '../components/kea/formProvider.php',
                type: 'get',
                data: {user:user, id: value},
                success: function(res) {
                    $('#content-user').html(res)
                }
            })
        }
    })

    $('#toDelete').on('click', function() {
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih Provider terlebih dahulu',
                'warning'
            )
        }else {
            $('#tbl-providers input[type=checkbox]:checked').each(function() {
                var row = $(this).val()
                array.push(row)
           })

            Swal.fire({
                title: 'Kamu yakin?',
                text: 'Data akan terhapus secara permanen',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: url_api + '/provider/delete',
                        type: 'post',
                        data: {
                            ProviderID: array
                        },
                        success: function(res){
                            Swal.fire(res.title, res.message, res.status)
                            if(res.status == 'success') show_tables()
                        }
                    })
                }else{
                    Swal.fire('Batal', 'Data batal hapus', 'warning')
                }
            })
        }
    })

    $('#back').on('click', function() {
        window.history.go(-1)
    })
    function show_tables() {
        var tb = ''
        $.ajax({
            url: url_api + '/providers',
            type: 'post',
            data: {cari: $('#cari').val()},
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data 
                    $('#total-produsen').html(data.length)
                    data.forEach(function(items, index) {
                        tb = tb + 
                        `<tr>
                            <td class="col-1"><input type="checkbox" class="form-check-input  checked" value="${items.ProviderID}"> </td>
                            <td>${items.ProviderID}</td>
                            <td>${items.Perusahaan}</td>
                            <td>${items.NPWP}</td>
                            <td>${items.Rekening_USD}</td>
                            <td>${items.Rekening_IDR}</td>
                            <td>${items.MataAnggaran}</td>
                            <td>${items.COANonGas}</td>
                        </tr>`
                    })
                }else {
                    $('#total-produsen').html(0)
                    tb = tb + `<tr><td colspan="8" style="text-align: center;"></td></tr>`
                }

                $('#tbl-providers').html(tb)
            }
        })
    }

    $(document).ready(function() {
        show_tables()
    })

    $('#cari').on('keyup', function(){
        show_tables()
    })
</script>