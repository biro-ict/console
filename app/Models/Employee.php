<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;


    class Employee extends Model {

        function see_empl() {
            $get = DB::select('SELECT * FROM users where deleted=0 and isEmpl=1 ORDER BY fullname');
            return response()->json([
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'message' => count($get) > 0 ? 'Data user berhasil diambil' : 'Data user gagal diambil',
                'status' => count($get) > 0 ? 'success' : 'error',
                'data' => count($get) > 0 ? $get : ''
            ]);
        }

        function see_empl_by_id($id) {
            $get = DB::table('users')->where('id', $id)->get();
            return response()->json([
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'message' => count($get) > 0 ? 'Data user berhasil diambil' : 'Data user gagal diambil',
                'status' => count($get) > 0 ? 'success' : 'error',
                'data' => count($get) > 0 ? $get : ''
            ]);
        }

        function see_empl_by_user($username) {
            $get = DB::table('users')->where('username', $username)->get();
            return response()->json([
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'message' => count($get) > 0 ? 'Data '.$username.' berhasil diambil' : 'Data '.$username.' gagal diambil',
                'status' => count($get) > 0 ? 'success' : 'error',
                'data' => count($get) > 0 ? $get : ''
            ]);
        }

        function see_empl_access() {
            $get = DB::select('SELECT a.id, a.fullname, a.username, a.status, b.name as deptName FROM users a JOIN department b ON a.deptId = b.id ORDER BY a.fullname');
            return response()->json([
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'message' => count($get) > 0 ? 'Data  berhasil diambil' : 'Data  gagal diambil',
                'status' => count($get) > 0 ? 'success' : 'error',
                'data' => count($get) > 0 ? $get : ''
            ]);
        }

        function search_employee($b=0, $d= 0, $q) {

            $where = " WHERE a.deleted=0 and a.isEmpl=1 AND ((a.fullname LIKE '%$q%') or (a.username LIKE '%$q%') or (a.level LIKE '%$q%') or (b.name LIKE '%$q%') or (d.name LIKE '%$q%') or (c.name LIKE '%$q%') or (a.status LIKE '%$q%'))";

            $where = $b == 0 ? $where : $where . " AND (a.branchid = $b)";
            $where = $d == 0 ? $where : $where . " AND (a.deptId = $d)";


            $query = "SELECT a.id, a.fullname, a.username, d.name AS gender, a.level, e.statusName, CONCAT(f.gradeCode, ' - ', f.gradeName) AS grade, b.name AS deptName, c.name AS branchName
            FROM users a
            JOIN department b ON a.deptId = b.id
            JOIN branch c ON a.branchid = c.id
            JOIN gender d ON a.gender = d.code
            JOIN mSTATUS e ON a.status = e.id
            JOIN grade f ON a.gradeId = f.id $where ORDER BY a.fullname";

            $get = DB::select($query);
            return response()->json([
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'message' => count($get) > 0 ? 'Data  berhasil diambil' : 'Data  gagal diambil',
                'status' => count($get) > 0 ? 'success' : 'error',
                'data' => count($get) > 0 ? $get : ''
            ]);
        }


        function add_empl($fullname, $username, $gender, $level, $deptId, $branchid, $grade, $status) {
            $arr = array(
                'fullname' => $fullname,
                'username' => $username,
                'gender' => $gender,
                'level' => $level,
                'deptId' => $deptId,
                'branchid' => $branchid,
                'status' => $status,
                'gradeId' => $grade    
            );

            $add = DB::table('users')->insert($arr);
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil menambah data user'
            ]);
        }

        function update_empl($id, $fullname, $username, $gender, $level, $deptId, $branchid, $status, $grade) {
            $arr = array(
                'fullname' => $fullname,
                'username' => $username,
                'gender' => $gender,
                'level' => $level,
                'deptId' => $deptId,
                'branchid' => $branchid,
                'status' => $status,
                'gradeId' => $grade        
            );

            $update = DB::table('users')->where('id', $id)->update($arr);
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil mengubah data user'
            ]);
        }

        function delete_empl($id) {
            $count = count($id);
            for($i=0; $i<$count; $i++) {
                $delete=DB::select("UPDATE users SET deleted=1, deletedTime=now() WHERE id='$id[$i]'");
            }
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil menghapus data user'
            ]);
        }


    }
?>