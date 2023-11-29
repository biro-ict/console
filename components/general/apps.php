<?php $user = isset($_GET['user']) ? $_GET['user']  : '';?>

<div class="container-xxl flex-grow-1 container-p-y" style="padding-bottom: 50px">

    <div class="row">
        <div class="col-lg-12 mb-4 order-0">

            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Hai <?=$user?>, ini aplikasimu yang terdaftar</h5>
                            <p class="card-subtitle text-muted">Jika kamu belum memiliki akses, silahkan menghubungi ICT di areamu</p>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img
                                src="../../assets/img/illustrations/man-with-laptop-light.png"
                                height="140"
                                alt="View Badge User"
                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div id="default-apps" class="row mt-3"></div>
    <div id="card-apps" class="row mt-3"></div>


</div>

<script type="text/javascript">
    $(document).ready(function() {
        var user = `<?php echo $user;?>`;

        $.ajax({
            url: url_api + '/defaultapps',
            type: 'get',
           
            success:function(res) {
                var card = ''
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(row, index) {
                        card = card + `
                            <div class="col-lg-3 col-md-3 order-1 mb-3">
                                <div class="card" style="background-color: #FF6D60; color: #f3f3f3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5 class="text-white">${row.appsName}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-footer">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <a href="${row.appsURL}" target="_blank" class="btn btn-sm btn-primary">Menuju Aplikasi</a>
                                            </div>
                                           
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>`
                    })
                }
                $('#default-apps').html(card)
            }
        })
        $.ajax({
            url: url_api + '/access_user',
            type: 'post',
            data: {
                username: user
            },
            success:function(res) {
                var card = ''
                if(res.status == 'success') {
                    var data = res.data
                    data.forEach(function(row, index) {
                        card = card + `
                            <div class="col-lg-3 col-md-3 order-1 mb-3">
                                <div class="card" style="background-color: #FF6D60; color: #f3f3f3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5 class="text-white">${row.appsName}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-footer">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <a href="${row.appsURL}" target="_blank" class="btn btn-sm btn-primary">Menuju Aplikasi</a>
                                            </div>
                                           
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>`
                    })
                }

                $('#card-apps').html(card)
            }
        })
    
    })
</script>