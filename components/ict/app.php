<?php $user = isset($_GET['user']) ? $_GET['user']  : '';?>

<div class="container-xxl flex-grow-1 container-p-y" style="padding-bottom: 50px">

    <div class="row" id="show_apps">

      
        
    </div>


</div>

<script type="text/javascript">

    function add_apps() {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/ict/formApp.php',
            type: 'get',
            data: {user:user},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
    }

    function edit_data(id) {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/ict/formApp.php',
            type: 'get',
            data: {user:user, id: id},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
    }

    function delete_data(id) {
        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Kamu akan menghapus data ini secara permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0275d8',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) =>  {
            if(result.value) {
                $.ajax({
                    url: url_api + '/apps/delete',
                    type: 'post',
                    data: {
                        id: id
                    },
                    success: function(res) {
                        Swal.fire(res.title, res.message, res.status)
                        if(res.status == 'success') location.reload()
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                       if(xhr.status == 500) Swal.fire('Ooops', 'Sepertinya data yang kamu ingin hapus merupakan data primary. Silahkan cek kembali sebelum menghapus data ini. ', 'error')
                    }
                })
            }else{
                Swal.fire('Batal', 'Data batal dihapus', 'error')
            }
        })
    }

    $(document).ready(function() {
       var card = `
       <div class="col-lg-3 col-md-3 order-1 mb-3" style="cursor: pointer">
            <div class="card" style="background-color: #FF6D60; color: #f3f3f3; height:200px;" onclick="add_apps()" >
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2"><h1 class="text-white">+</h1></div>
                        <div class="col-md-10">
                            <h2 class="text-white">Tambah Aplikasi</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>`

        var user = `<?php echo $user;?>`;
        $.ajax({
            url: url_api + '/apps/details/all',
            type: 'get',
            success: function(res) {
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(row, index) {
                        card = card + `
                        <div class="col-lg-3 col-md-3 order-1 mb-3">
                            <div class="card" style="background-color: #${row.bgcolor}; color: #f3f3f3; height: 200px;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <h5 class="text-white"><a class="text-white" href="${row.appsURL}" target="_blank">${row.appsName}</a></h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">${row.status}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">${row.needlogin}</div>
                                    </div>
                                </div>
                                <div clas="card-footer">
                                    <div class="row">
                                        <div class="col-md-12" >
                                            <button class="text-white btn btn-sm btn-link" onclick="edit_data(${row.id})">Ubah</button>
                                            <button class="text-white btn btn-sm btn-link" onclick="delete_data(${row.id})">Hapus</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `
                    })
                }else {
                    card = `
                    <div class="col-lg-3 col-md-3 order-1 mb-3">
                        <div class="card" style="background-color: #FF6D60; color: #f3f3f3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <h2 class="text-white">Tambah Aplikasi</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`

                }

                $('#show_apps').html(card)

            }
        })
    })
</script>