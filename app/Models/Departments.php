<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;


    class Departments extends Model {
        function see_depts() {
            $get = DB::table('department')->get();
            return response()->json([
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'message' => count($get) > 0 ? 'Data Depts berhasil diambil' : 'Data Depts gagal diambil',
                'status' => count($get) > 0 ? 'success' : 'error',
                'data' => count($get) > 0 ? $get : ''
            ]);
        }

        function see_depts_by_id($id) {
            $get = DB::table('department')->where('id', $id)->get();
            return response()->json([
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'message' => count($get) > 0 ? 'Data Depts berhasil diambil' : 'Data Depts gagal diambil',
                'status' => count($get) > 0 ? 'success' : 'error',
                'data' => count($get) > 0 ? $get : ''
            ]);
        }

        function search_depts($dirs= 0, $q='') {
            $where = $dirs != 0 ? " AND (a.dirId = $dirs) " : '';
            $query = "SELECT a.id, a.name, a.code, b.name as dirName FROM department a JOIN directory b ON a.dirId = b.id WHERE ((a.name LIKE '%$q%') or (a.code LIKE '%$q%') or (b.name LIKE '%$q%')) $where order by a.name";
            $get = DB::select($query);
            return response()->json([
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'message' => count($get) > 0 ? 'Data Depts berhasil diambil' : 'Data Depts gagal diambil',
                'status' => count($get) > 0 ? 'success' : 'error',
                'data' => count($get) > 0 ? $get : ''
            ]);

        }

        function add_depts($dir, $name, $code) {
            $arr = array(
                'dirId' => $dir,
                'name' => $name,
                'code' => $code
            );

            $add = DB::table('department')->insert($arr);
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil menambah data Departemen'
            ]);
        }

        function update_depts($id, $dir, $name, $code) {
            $arr = array(
                'dirId' => $dir,
                'name' => $name,
                'code' => $code
            );

            $update = DB::table('department')->where('id', $id)->update($arr);
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil Mengubah data departemen',
            ]);
        }

        function delete_depts($id) {
            $delete = DB::table('department')->delete($id);
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil menghapus data departemen',
            ]);

        }
    }
?>