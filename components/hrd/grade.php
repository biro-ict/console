<?php $user = isset($_GET['user']) ? $_GET['user'] : '';?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Grade</h4>
                </div>
                <main class="card-body mt-3">
                        <div class="col-auto mb-3">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari" id="cari">
                        </div>
                        <content class="col-md-12 mb-3">
                            <div class="table-responsive" style="height: 400px">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <th class="col">#</th>
                                        <th class="col">Kode</th>
                                        <th class="col">Nama</th>
                                    </thead>
                                    <tbody id="tbl-grade"></tbody>
                                </table>
                            </div>
                        </content>
                    </div>
                </main>
                
                <footer class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addGrade">Tambah</button>
                    <button type="button" class="btn btn-info btn-sm" id="updateGrade">Ubah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="deleteGrade">Hapus</button>
                    <button type="button" class="btn btn-secondary btn-sm" id="backto">Kembali</button>
                </footer>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#addGrade').on('click', function() {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/hrd/formGrade.php',
            type: 'get',
            data: {user: user},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
    })

    $('#updateGrade').on('click', function(){

    })

    $('#deleteGrade').on('click', function() {

    })

    $('#backto').on('click', function() {
        window.location.go(-1)
    })

    function show_tables() {
        $.ajax({
            url: url_api + '/grade/all',
            type: 'get',
            success: function(res) {
                var tb = ''
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(items, index) {
                        var tb = tb + `<tr>
                            <td class="col-1"><input type="checkbox" class="form-check-input  checked" value="${items.id}"> </td>
                            <td>${items.gradeCode}</td>
                            <td>${items.gradeName}</td>
                        </tr>`
                    })
                }else {
                    tb = `<tr><td colspan="3" class="text-center">${res.message}</td></tr>`
                }

                $('#tbl-grade').html(tb)
            }
        })
    }

    $(document).ready(function() {
        show_tables()
    })
</script>