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
                            <select class="form-select form-select-sm" id="customer"></select>
                        </div>
                        <div class="col-md-12">
                            <label>Serial Number Lama</label>
                            <input type="text" class="form-control form-control-sm" id="old_sn" readonly>
                        </div>
                        <div class="col-md-12">
                            <label>Serial Number Baru</label>
                            <input type="text" class="form-control form-control-sm" id="new_sn">
                        </div>
                    </div>
                </div>
                
                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="update_data">Update</button>
                    <button type="button" class="btn btn-danger btn-sm" id="backto">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function show_customer() {
        $.ajax({
            url: url_api + '/corus/costumer',
            type: 'get',
            success: function(res) {
                var opt = ''
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(items, index) {
                        opt = opt + `<option value="${items.Customer_data_1}">${items.ConnectionName}</option>`
                    })
                }

                $('#customer').html(opt)
            }
        })
    }

    $('#customer').on('change', function() {
        var value = $(this).val()
        $.ajax({
            url: url_api + '/corus/'+value,
            type: 'get',
            success: function(res) {
                if(res.status == 'success')  {
                    console.log(res)
                    var data = res.data
                    $('#old_sn').val(data[0].Converter_Serial_Number)
                }
            }
        })
    })

    $('#update_data').on('click', function() {
        var user = `<?php echo $user;?>`;
        var customer    = $('#customer').val()
        var old_sn      = $('#old_sn').val()
        var new_sn      = $('#new_sn').val()

        $.ajax({
            url: url_api + '/corus/update',
            type: 'post',
            data: {
                username: user,
                customer: customer,
                old_sn: old_sn,
                new_sn: new_sn
            },
            success: function(res) {
                Swal.fire(res.title, res.message, res.status)
                if(res.status == 'success') location.reload()
            }
        })

    })

    $('#new_sn').on('keyup', function() {
        console.log($(this).val())
        if($(this).val() =='') {
            $('#update_data').css('display', 'none')
        }else{
            $('#update_data').css('display', 'inline')
        }
    })

    $(document).ready(function() {
        $('#update_data').css('display', 'none')
        show_customer()
        var new_sn = $('#new_sn').val()
        var customer = $('#customer').val()
        $.ajax({
            url: url_api + '/corus/'+old_sn,
            type: 'get',
            success: function(res) {
                if(res.status == 'success')  {
                    console.log(res)
                    var data = res.data
                    $('#old_sn').val(data[0].Converter_Serial_Number)
                }
            }
        })

    });

    $('#backto').on('click', function(){location.reload()})
</script>