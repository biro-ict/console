<?php
    namespace App\Models\Auth;
    use Illuminate\Database\Eloquent\Model;
    use DB;

    class Users extends Model {

        function auth_ldap($username, $password = '') {

            $ldap_host   = 'ldap://ldap.bbg.co.id';
            $ldap_port   = 389;
            $basedn = 'ou=Users,dc=bbgemilang,dc=co,dc=id';
            $ldap_conn   = ldap_connect($ldap_host, $ldap_port) or die ('Connection to LDAP Server failed');
            $result     = 'false';

            
            if($ldap_conn) {
                $r = ldap_search($ldap_conn, $basedn, 'uid='.$username);
                if($r) {
                    if($password <> '') {
                        ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
                        $result = ldap_get_entries($ldap_conn, $r);

                        if(is_array($result)) {
                            if(@ldap_bind($ldap_conn, $result[0]['dn'], $password)) {
                                ldap_close($ldap_conn);
                                $result = 'true';
                            }else{
                                ldap_close($ldap_conn);
                                $result = 'Your Password is incorrect';
                            }
                        }else{
                            $result = 'Username not found. Are your username is correct?';
                        }
                    }else{
                        $result = 'Password is empty';
                    }
                }else{
                    $result = 'There is some error in LDAP host. Please try again later';
                }
            }

            return $result;
            
        }


        function auth_console($username) {
            $get = DB::table('users')->where(array('username'=>$username, 'status' => '4'))->get();
            $c   = count($get); 
    
            return response()->json([
                'status' => $c > 0 ? 'success' : 'error',
                'title' => 'Login Authentification to Console Apps',
                'message' => $c > 0 ? 'Login successful. Welcome '.$username : 'Sorry, user not found',
                'data' => $c > 0 ? $get : ''
            ]);
        }

        function auth_dept($username) {
            $get = DB::select("select u.id, u.fullname, u.username, u.`level` , d.name , d.code  from users u join department d on u.deptId = d.id where u.username =  '$username'");
            $c   = count($get); 
    
            return response()->json([
                'status' => $c > 0 ? 'success' : 'error',
                'title' => 'Access Module By Dept',
                'message' => $c > 0 ? 'Access found for username: '.$username : 'Sorry, user not found',
                'data' => $c > 0 ? $get : ''
            ]);
        }

        function detail_user($username) {
            $get = DB::select("select u.id, u.fullname, u.username, u.`level` , d.name as deptName, d.code, b.name as branchName from users u join department d on u.deptId = d.id join branch b on u.branchid = b.id  where u.username =  '$username'");
            $c   = count($get); 
    
            return response()->json([
                'status' => $c > 0 ? 'success' : 'error',
                'title' => 'Detil User',
                'message' => $c > 0 ? 'Detail found for username: '.$username : 'Sorry, user not found',
                'data' => $c > 0 ? $get : ''
            ]);
        }

        function dashboard_user($username) {
            $get = DB::select("select u.username , u.fullname, a2.appsName  from apps_access a join users u on a.userId = u.id join apps a2 ON a.appsId = a2.id where u.username = '$username'");
            $c = count($get);

            return response()->json([
                'status' => $c > 0 ? 'success' : 'error',
                'title' => 'Dashboard Users',
                'message' => $c > 0 ? 'Dashboard found for username: '.$username : 'Sorry, user not found',
                'data' => $c > 0 ? $get : '',
                'count' => $c
            ]);

        }

        function show_user_apps($username) {
            $get = DB::select("select c.appsName, c.appsURL  from apps_access a join users b on a.userId = b.id join apps c on a.appsId = c.id where b.username = '$username'");

            $c = count($get);

            return response()->json([
                'status' => $c > 0 ? 'success' : 'error',
                'title' => 'Dashboard Users',
                'message' => $c > 0 ? 'Dashboard found for username: '.$username : 'Sorry, user not found',
                'data' => $c > 0 ? $get : '',
                'count' => $c
            ]);
        }

        function show_apps() {
            $get = DB::select("select appsName, appsURL FROM apps where needLogin = 1");
            $c = count($get);

            return response()->json([
                'status' => $c > 0 ? 'success' : 'error',
                'title' => 'Dashboard Users',
                'message' => $c > 0 ? 'Dashboard found ': 'Sorry, user not found',
                'data' => $c > 0 ? $get : '',
                'count' => $c
            ]);

        }
    
    }

  
?>