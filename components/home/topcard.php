<?php $user = isset($_GET['user']) ? $_GET['user']  : '';?>

<div class="container-xxl flex-grow-1 container-p-y" style="padding-bottom: 50px">

    <div class="row">
        <div class="col-lg-12 mb-4 order-0">

            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><span id="greeting"></span>!</h5>
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

        <div class="col-lg-3 col-md-3 order-1 mb-3">
            <div class="card" style="background-color: #FF6D60; color: #f3f3f3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="text-white">Aplikasi Saya</h5>
                            <h3 class="card-title mb-2 text-white" id="c_apps">0</h3>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
      
        
    </div>


</div>

<script type="text/javascript">
    $(document).ready(function() {
        var today = new Date()
        var hours = today.getHours();
        var greeting = hours < 12 ? 'Pagi' : ((hours >= 12 && hours < 18) ? 'Siang' : 'Malam') 
       
        var user = `<?php echo $user;?>`;

        $('#greeting').html('Selamat ' + greeting + ', '+user)
        $.ajax({
            url: url_api + '/users/dashboard',
            type: 'post',
            data: {
                username: user
            }, 
            success: function(res) {
                $('#c_apps').html(res.count)

            }
        })
    })
</script>