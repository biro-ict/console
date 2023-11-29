<?php
    header('Content-Type: application/json');
    session_start();
    $function = isset($_GET['f']) ? $_GET['f'] : '-';
    
    if($function == 'logout') {
        session_destroy();
        echo json_encode(array(
            'title' => 'Logout From Apps',
            'message' => 'You successfully Logout from this apps',
            'status' => 'success'
        ));
    }
    else if($function == 'LOGIN') {
        $_SESSION['username'] = isset($_POST['username']) ? $_POST['username'] : '';
        echo $_SESSION['username'] != '' ? json_encode(array(
                'title' => 'Login successfully',
                'message' => 'You successfully Login to this apps',
                'status' => 'success'
            )) : json_encode(array(
                'title' => 'Failed to Login',
                'message' => 'username not found',
                'status' => 'error',
            ));
    
    }else{
        echo json_encode(array(
            'status' => 'forbidden',
            'title' => '401',
            'message' => 'This apps is not for used'
        ));
    }
?>