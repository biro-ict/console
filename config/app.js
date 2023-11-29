const url_api = 'http://127.0.0.1:8000/api'
//const url_api = 'https://api-monitoring.bbg.co.id/api'
const url_request = 'https://api-request.bbg.co.id'

get = 'GET'
post = 'POST'

$('#formLogin').on('submit', function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    
    var username = $('#username').val()
    var password = $('#password').val()
    $.ajax({
        url: url_api+'/login',
        type: post,
        data: {
            username: username,
            password: password
        },
        success: function (res) {
          
            if (res.status == 'success') {


                $('#loading-login').removeAttr('span')
                $('#loading-login').html(
                    `<div class="text-center">
                        <div class= "spinner-border" role = "status" > 
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div > `
                )


                setInterval(function () {
                    $.ajax({
                        url: 'config/auth.php?f=LOGIN',
                        type: 'post',
                        data: {
                            username: username
                        },
                        success: function(res) {
                            if(res.status == 'success') {
                                location.href = 'apps/index.php'
                            }
                        }
                    })
                }, 1500)
            } else {
                $('.alert').removeClass('d-none').addClass('show')
                $('.alert').html(res.message)
                $('#password').val('')
            }
        },
        error: function () {
            console.log('error')
        }
    })   
})