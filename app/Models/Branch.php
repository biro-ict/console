<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class Branch extends Model {

        function see_branch() {
            $get = DB::table('branch')->get();

            return response()->json([
                'status' => count($get) > 0 ? 'success' : 'error',
                'message' => count($get) > 0 ? 'Data Branch Berhasil diambil' : 'Data Branch gagal diambil',
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'data' => count($get) > 0 ? $get : ''
            ]);
        }

        function see_branch_by_id($id) {
            $get = DB::table('branch')->where('id', $id)->get();
            return response()->json([
                'status' => count($get) > 0 ? 'success' : 'error',
                'message' => count($get) > 0 ? 'Data Branch berhasil diambil' : 'Data Branch gagal  diambil',
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'data' => count($get) > 0 ? $get : '' 
            ]);
        }

        function search_branch($orgz, $q) {
            $where = '';
            if($orgz != 0) {
                $where = "AND (a.orgId = $orgz)";
            }
            $query = "SELECT a.id, a.name, a.code, b.name as orgName FROM branch a JOIN organizations b ON a.orgId = b.id WHERE ((a.name LIKE '%$q%') or (a.code LIKE '%$q%') or (b.name LIKE '%$q%')) $where order by a.name";
            $get = DB::select($query);
            return response()->json([
                'status' => count($get) > 0 ? 'success' : 'error',
                'message' => count($get) > 0 ? 'Data Branch berhasil diambil' : 'Data Branch gagal  diambil',
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'data' => count($get) > 0 ? $get : '' 
            ]);


        }

        function add_branch($name, $org, $code) {
            $arr = array(
                'name' => $name,
                'orgId' => $org,
                'code' => $code
            );



            $add = DB::table('branch')->insert($arr);
            return response()->json([
                'title' => 'Berhasil',
                'message' => 'Berhasil menambah daata branch',
                'status' => 'success',
            ]);
        }


        function update_branch($id, $name, $org, $code) {
            $arr = array(
                'name' => $name,
                'orgId' => $org,
                'code' => $code
            );

            $update = DB::table('branch')->where('id', $id)->update($arr);
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengubah data branch',
                'title' => 'Berhasil'
            ]);
        }
        
        function delete_branch($id) {
            $delete = DB::table('branch')->delete($id);
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil menghapus data branch'
            ]);
        }
    }


?>