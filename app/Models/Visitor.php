<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class Visitor extends Model {

        function see_visitor($q) {
            $get = DB::connection('mysql_second')->select("SELECT * FROM receptionist where (username LIKE '%$q%') or (area LIKE '%$q%')");

            $arr = array();
            

            foreach($get as $row) {
                // print_r($row->username);
                $user =  $row->username;
                $get_fullname = DB::select("SELECT fullname FROM users where (username = '$user')");
                $fullname = count($get_fullname) > 0 ? $get_fullname[0]->fullname : '';
                $queue = array(
                    'id' => $row->id,
                    'username' => $user,
                    'fullname' => $fullname,
                    'area' => $row->area
                );

                array_push($arr, $queue);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengambil data',
                'title' => 'Berhasil',
                'data' => $arr
            ]);
        }

        function see_visitor_by_id($id) {
            $db = DB::Connection('mysql_second')->table('receptionist')->where('id', $id)->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengambil data',
                'title' => 'Berhasil',
                'data' => $db
            ]);
        }

        function add_visitor($username, $area) {
            $add = DB::connection('mysql_second')->select("INSERT INTO receptionist(username, area) VALUES('$username', '$area')");
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menambah data',
                'title' => 'Berhasil'
            ]);
        }

        function update_visitor($id, $username, $area) {
            $update = DB::connection('mysql_second')->select("UPDATE receptionist SET username = '$username', area='$area' WHERE id=$id");
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menambah data',
                'title' => 'Berhasil'
            ]);
        }

        function delete_visitor($id) {
            $delete = DB::connection('mysql_second')->select("DELETE from receptionist where id = $id");
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus data',
                'title' => 'Berhasil'
            ]);
        }
    }
?>