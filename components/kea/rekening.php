<?php 
    $user = isset($_GET['user']) ? $_GET['user'] : '';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Nomor Rekening</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-auto">
                            <select class="form-select form-select-sm" id="datasource"></select>
                        </div>
                        <div class="col-auto">
                            <select class="form-select form-select-sm" id="kodebank"></select>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="table-responsive" style="height: 400px">
                                <table class="table table-sm table-striped table-hover">
                                    <thead>
                                        <th class="col">#</th>
                                        <th class="col">Kode Bank</th>
                                        <th class="col">Nama Bank</th>
                                        <th class="col">Branch</th>
                                        <th class="col">Nomor rekening</th>
                                        <th class="col">Mata Uang</th>
                                        <th class="col">Data Source</th>
                                        <th class="col">Mata Anggaran</th>
                                        <th class="col">Saldo</th>
                                        <th class="col" colspan="2">Aksi</th>
                                    </thead>
                                    <tbody id="tbl-rekening"></tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addRekening">Tambah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="deleteRekening">Hapus</button>
                    <button type="button" class="btn btn-secondary btn-sm" id="backto">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#backto').on('click', function() {
        window.history.go(-1)
    })

    $('#deleteRekening').on('click', function() {
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih Datasource terlebih dahulu',
                'warning'
            )
        }else{
            $('#tbl-rekening input[type=checkbox]:checked').each(function() {
                var row = $(this).val();
                array.push(row)
              
            })
            Swal.fire({
                title: 'Kamu yakin?',
                text: 'Data ini akan dihapus secara permanen',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus',
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: url_api + '/rekening/delete',
                        type: 'post',
                        data: {
                            NoRekening: array
                        },
                        success: function(res) {
                           Swal.fire(res.title, res.message, res.status);
                           if(res.status == 'success') location.reload()
                        }
                    })
                }else{
                    Swal.fire('Batal', 'Data batal dihapus', 'error')
                }
            })

          
           
        }
    })

    $('#addRekening').on('click', function() {
        // to add Datasource
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/kea/formRekening.php',
            type: 'get',
            data: {user:user},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
        
    })

    function show_tables() {
        $.ajax({
            url: url_api + '/rekening',
            type: 'post',
            data: {
                DataSource: $('#datasource').val(),
                KodeBank: $('#kodebank').val()  
            },
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data
                    var tb = ''
                    data.forEach(function(items, index) {
                     
                        tb = tb + `<tr>
                             <td class="col-1"><input type="checkbox" class="form-check-input  checked" value="${items.NoRekening}"> </td>
                            <td><b>${items.KodeBank}</b></td>
                            <td>${items.NamaBank}</td>
                            <td>${items.Branch}</td>
                            <td>${items.NoRekening}</td>
                            <td>${items.MataUang}</td>
                            <td>${items.DataSource}</td>
                            <td>${items.MataAnggaran}</td>
                            <td>${parseInt(items.saldo).toLocaleString('en-US', {
                                style: 'currency',
                                currency: items.MataUang,
                            })}</td>
                            <td><button type="button" class="btn btn-sm btn-info" onclick="edit_data(${items.NoRekening})">Edit</button></td>
                            </tr>`
                    })
                }else{
                    tb = tb + `<tr><td colspan="9" class="text-center">Data tidak ditemukan</td></tr>`
                }

                $('#tbl-rekening').html(tb)
            }
        })
    }

    $(document).ready(function() {
        show_tables()
        $.ajax({
            url: url_api + '/datasource',
            type: 'post',
            success: function(res) {
                var opt = "<option value=''>Semua Datasource</option>";
                if(res.status=='success') {
                    var data=res.data
                    data.forEach(function(items, index) {
                        opt = opt + `<option value="${items.DataSource}">${items.DataSourceName} | ${items.DataSourceDescr}</option>`
                    })

                    $('#datasource').html(opt)
                }
            }
        })

        $.ajax({
            url: url_api + '/bank',
            type: 'post',
            success: function(res) {
                var opt = "<option value=''>Semua Kode Bank</option>";
                if(res.status=='success') {
                    var data=res.data
                    data.forEach(function(items, index) {
                        opt = opt + `<option value="${items.KodeBank}">${items.NamaBank} (${items.KodeBank})</option>`
                    })

                    $('#kodebank').html(opt)
                }
            }
        })
    })

    $('#datasource').on('change', function() {
        show_tables()
    })

    $('#kodebank').on('change', function() {
        show_tables()
    })

    function edit_data(id) {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/kea/formRekening.php',
            type: 'get',
            data: {user:user, id: id},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
    }



</script>