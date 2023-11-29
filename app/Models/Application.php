<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class Application extends Model {

        function see_apps() {
            $get = DB::table('apps')->get();
            return response()->json([
                'status' => count($get) > 0 ? 'success' : 'error',
                'message' => count($get) > 0 ? 'Berhasil mengambil data Aplikasi' : 'Gagal mengambil data aplikasi',
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'data' => count($get) > 0 ? $get : 0
            ]);
        }

        function see_details_apps() {
            $get = DB::Select('SELECT a.id, a.appsName, a.appsURL, b.name as status, b.bgcolor, c.name as needlogin  FROM apps a JOIN apps_status b ON a.status = b.id JOIN login_level c ON a.needLogin = c.kode order by a.appsName;');
            return response()->json([
                'status' => count($get) > 0 ? 'success' : 'error',
                'message' => count($get) > 0 ? 'Berhasil mengambil data Aplikasi' : 'Gagal mengambil data aplikasi',
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'data' => count($get) > 0 ? $get : 0
            ]);
        }

        function see_apps_access() {
            $query = "SELECT a.id, a.appsName, a.appsURL, b.name as status, c.name as needlogin  FROM apps a JOIN apps_status b ON a.status = b.id JOIN login_level c ON a.needLogin = c.kode where a.status = 9 and a.needLogin = 2 order by a.appsName;";
            $get = DB::select($query);
            return response()->json([
                'status' => count($get) > 0 ? 'success' : 'error',
                'message' => count($get) > 0 ? 'Berhasil mengambil data ' : 'Gagal mengambil data ',
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'data' => count($get) > 0 ? $get : 0
            ]);
        }

        function see_user_by_apps($id, $func) { 
            $where = $func == 'user' ? ' where a.userId = '.$id : ' where a.appsId = '.$id; 
            $query = "SELECT a.userid, a.appsId, b.fullname, b.username, c.appsName, c.appsURL  from apps_access a join users b on a.userId = b.id join apps c on a.appsId = c.id $where";
            $get = DB::select($query);
            return response()->json([
                'status' => count($get) > 0 ? 'success' : 'error',
                'message' => count($get) > 0 ? 'Berhasil mengambil data Aplikasi' : 'Gagal mengambil data aplikasi',
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'data' => count($get) > 0 ? $get : 0
            ]);
            
        }

        function see_apps_by_id($id) {
            $get = DB::table('apps')->where('id', $id)->get();
            return response()->json([
                'status' => count($get) > 0 ? 'success' : 'error',
                'message' => count($get) > 0 ? 'Berhasil mengambil data Aplikasi' : 'Gagal mengambil data aplikasi',
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'data' => count($get) > 0 ? $get : 0
            ]);
        }

        function add_apps($name, $uri, $urife, $uribe, $dbhost, $dbname, $login, $status) {
            $arr = array(
                'appsName' => $name,
                'appsURL' => $uri,
                'appsUriFE' => $urife,
                'appsUriBE' => $uribe,
                'appsDBHost' => $dbhost,
                'appsDBName' => $dbname,
                'needLogin' => $login,
                'status' => $status
            );


            $add = DB::table('apps')->insert($arr);
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil menambah data aplikasi'
            ]);
        }

        function update_apps($id, $name, $uri, $urife, $uribe, $dbhost, $dbname, $login, $status) {
            $arr = array(
                'appsName' => $name,
                'appsURL' => $uri,
                'appsUriFE' => $urife,
                'appsUriBE' => $uribe,
                'appsDBHost' => $dbhost,
                'appsDBName' => $dbname,
                'needLogin' => $login,
                'status' => $status
            );


            $add = DB::table('apps')->where('id', $id)->update($arr);
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil mengubah data aplikasi'
            ]);
        }

        function delete_apps($id) {
            $delete = DB::table('apps')->delete($id);
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil menghapus data aplikasi'
            ]);
        }

        function see_status_apps() {
            $get = DB::table('apps_status')->get();
            return response()->json([
                'status' => count($get) > 0 ? 'success' : 'error',
                'message' => count($get) > 0 ? 'Berhasil mengambil data Status Aplikasi' : 'Gagal mengambil data Status Aplikasi',
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'data' => count($get) > 0 ? $get : 0
            ]);
        }

        function see_status_apps_by_id($id) {
            $get = DB::table('apps_status')->where('id', $id)->get();
            return response()->json([
                'status' => count($get) > 0 ? 'success' : 'error',
                'message' => count($get) > 0 ? 'Berhasil mengambil data Status Aplikasi' : 'Gagal mengambil data Status Aplikasi',
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'data' => count($get) > 0 ? $get : 0
            ]);
        }

        function add_status_apps($name, $code) {
            $arr = array(
                'name' => $name,
                'code' => $code
            );

            $insert = DB::table('apps_status')->insert($arr);
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil menambah data status aplikasi'
            ]);
        }

        function update_status_apps($id, $name, $code){
            $arr = array(
                'name' => $name,
                'code' => $code 
            );

            $update = DB::table('apps_status')->where('id', $id);
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil mengubah data status aplikasi'
            ]);
        }

        function delete_status_apps($id) {
            
            $delete = DB::table('apps_status')->delete($id);
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil menghapus data status aplikasi'
            ]);
        }


        function see_login_level() {
            $get = DB::table('login_level')->get();
            return response()->json([
                'status' => count($get) > 0 ? 'success' : 'error',
                'message' => count($get) > 0 ? 'Berhasil mengambil data Status Aplikasi' : 'Gagal mengambil data Status Aplikasi',
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'data' => count($get) > 0 ? $get : 0
            ]);
        }

        function add_access_apps($userid, $appsid) {
            //check if exists
            $get = DB::select("Select * FROM apps_access WHERE userid = $userid AND appsId = $appsid");
            if(count($get) > 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User sudah memiliki akses ke aplikasi',
                    'title' => 'Duplikasi'
                ]);
            }else {
                $arr = array(
                    'userId' => $userid,
                    'appsId' => $appsid
                );
                $add = DB::table('apps_access')->insert($arr);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Data akses user berhasil ditambah',
                    'title' => 'Berhasil'
                ]);
            }
        }

        function delete_access_apps($userid, $appsid) {
            $delete = DB::select("DELETE FROM apps_access WHERE userId = $userid AND appsId = $appsid");
            return response()->json([
                'status' => 'success',
                'message' => 'Akses user berhasil dihapus',
                'title' => 'Berhasil'
            ]);
        }
 
    }

?>