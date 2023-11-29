<?php 
    $user = isset($_GET['user']) ? $_GET['user'] : '';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data EVC Corus</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive" style="height: 400px">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <th class="col">#</th>
                                        <th class="col">Serial Number</th>
                                        <th class="col">Corus Version</th>
                                        <th class="col">Connection name</th>
                                        <th class="col">Converter Serial Number</th>
                                        <th class="col">Remote Address</th>
                                        <th class="col">Last Info</th>
                                    </thead>
                                    <tbody id="tbl-corus"></tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="updateSNCorus">Update Serial Number</button>
                    <button type="button" class="btn btn-secondary btn-sm" id="checkCorus">Check Duplicated Data</button>
                    <button type="button" class="btn btn-danger btn-sm" id="backto">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
      $('#backto').on('click', function() {
        location.reload()
    })

    $('#updateSNCorus').on('click', function() {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/ict/formCorus.php',
            type: 'get',
            data: {user:user},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
    })

    function show_tables(){
        var tbody = '';
        $.ajax({
            url: url_api + '/configurasi',
            type: 'get',
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(items, index) {
                        tbody = tbody + `
                            <tr>
                                <td>${index+1}</td>
                                <td>${items.serialnumber}</td>
                                <td>${items.corusVersion}</td>
                                <td>${items.ConnectionName}</td>
                                <td>${items.Converter_Serial_Number}</td>
                                <td>${items.RemoteAddress}</td>
                                <td>${items.LastInfo}</td>
                            </tr>
                        `
                    })
                }

                $('#tbl-corus').html(tbody)
            }
        })
    }

    $('#checkCorus').on('click', function() {
        $.ajax({
            url: url_api + '/checkcorus',
            type: 'get',
            success: function(res) {
                Swal.fire(res.title, res.message, res.status)
                if(res.status == 'success') show_tables();
            }
        })
    }); 

    $(document).ready(function() {
        show_tables();
        setInterval(function() {show_tables()}, 10000 ) ;
    })
</script>