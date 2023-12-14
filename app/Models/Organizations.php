<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class Organizations extends Model {

        function see_orgz() {
            $get = DB::table('organizations')->where('deleted', 0)->get();
            return response()->json([
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'message' => count($get) > 0 ? 'Data organisasi berhasil diambil' : 'Data organisasi gagal diambil',
                'status' => count($get) > 0 ? 'success' : 'error',
                'data' => count($get) > 0 ? $get : ''
            ]);
        }

        function see_orgz_by_id($id) {
            $get = DB::table('organizations')->where('id', $id)->get();
            return response()->json([
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'message' => count($get) > 0 ? 'Data organisasi berhasil diambil' : 'Data organisasi gagal diambil',
                'status' => count($get) > 0 ? 'success' : 'error',
                'data' => count($get) > 0 ? $get : ''
            ]);
        }

        function search_orgz($q) { 
            $query = "SELECT * FROM organizations where deleted=0 AND ((name LIKE '%$q%') or (code LIKE '%$q%') or (address_one LIKE '%$q%') or (address_two LIKE '%$q%') or (telp LIKE '%$q%')) ORDER BY name";
            $get = DB::select($query);
          
            return response()->json([
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'message' => count($get) > 0 ? 'Data organisasi berhasil diambil' : 'Data organisasi gagal diambil',
                'status' => count($get) > 0 ? 'success' : 'error',
                'data' => count($get) > 0 ? $get : ''
            ]);
        }

        function add_orgz($name, $code, $address_one, $address_two, $telp) {
            $arr = array(
                'name' => $name,
                'code' => $code,
                'address_one' => $address_one,
                'address_two' => $address_two,
                'telp' => $telp
             );

             $add = DB::table('organizations')->insert($arr);
             return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil menambah data Organisasi'
            ]);

        }

        function update_orgz($id, $name, $code, $address_one, $address_two, $telp) {
            $arr = array(
                'name' => $name,
                'code' => $code,
                'address_one' => $address_one,
                'address_two' => $address_two,
                'telp' => $telp
             );

             $update = DB::table('organizations')->where('id', $id)->update($arr);
             return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil mengubah data Organisasi'
            ]);

        }

        function delete_orgz($id) {
            $count = count($id);

            for($i=0; $i<$count;$i++) {
                $delete = DB::select("UPDATE organizations SET deleted=1, deletedTime=now() WHERE id=$id[$i]");
            }
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil menghapus data organisasi'
            ]);

        }
    }

?>