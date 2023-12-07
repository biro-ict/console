<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class Directory extends Model {

        function see_dirs() {
            $get = DB::table('directory')->get();

            return response()->json([
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'message' => count($get) > 0 ? 'Data Direktori berhasil diambil' : 'Data direktori gagal diambil',
                'status' => count($get) > 0 ? 'success' : 'error',
                'data' => count($get) > 0 ? $get : ''
            ]);
        }

        function see_dir_by_id($id) {
            $get = DB::table('directory')->where('id', $id)->get();
            return response()->json([
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'message' => count($get) > 0 ? 'Data Direktori berhasil diambil' : 'Data direktori gagal diambil',
                'status' => count($get) > 0 ? 'success' : 'error',
                'data' => count($get) > 0 ? $get : ''
            ]);
        }

        function search_dir($orgz = 0, $q = "") {
            $where = $orgz == 0 ? '' : " AND (a.orgId = $orgz)";
            
            $query = "SELECT a.id, a.name, a.code, b.name as orgName FROM directory a JOIN organizations b ON a.orgId = b.id where a.deleted=0 AND ((a.name LIKE '%q%') or (a.code LIKE '%$q%') or (b.name LIKE '%$q%')) $where ORDER BY a.name";
            $get = DB::select($query);
            return response()->json([
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'message' => count($get) > 0 ? 'Data Direktori berhasil diambil' : 'Data direktori gagal diambil',
                'status' => count($get) > 0 ? 'success' : 'error',
                'data' => count($get) > 0 ? $get : ''
            ]);
        }

        function add_dir($name, $org, $code) {
            $arr = array(
                'name' => $name,
                'orgId' => $org,
                'code' => $code
            );

            $add = DB::table('directory')->insert($arr);
            // $add value 1 if query success
            if($add) {
                return response()->json([
                    'title' => 'Berhasil',
                    'message' => 'Berhasil menambah data direktori',
                    'status' => 'success'
                ]);
            }else{
                return response()->json([
                    'title' => 'Gagal',
                    'message' => 'Gagal menambah data direktori',
                    'status' => 'error'
                ]);
            }
           
        }

        function update_dir($id, $name, $org, $code) {
            $arr = array(
                'name' => $name,
                'orgId' => $org,
                'code' => $code
            );

            $add = DB::table('directory')->where('id', $id)->update($arr);
            return response()->json([
                'title' => 'Berhasil',
                'message' => 'Berhasil mengubah data direktori',
                'status' => 'success'
            ]);
        }

        function delete_dir($id) {

            $count = count($id);
            for($i=0; $i<$count; $i++) {
                $delete = DB::Select("UPDATE directory SET deleted=1, deletedTime=now() WHERE id=$id[$i]");
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus data direktori',
                'title' => 'Berhasil'
            ]);
        }

        


    }
?>