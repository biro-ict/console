<?php 
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class Licenses extends Model { 

        function see_licenses(){
            $get = DB::select("select a.Id, b.fullname, a.winType, a.winSerKey , a.officeType , a.officeSerKey , c.name as location, a.device  from licenses_user a join users b on a.username = b.id join branch c on a.location = c.id");
            return response()->json([
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'message' => count($get) > 0 ? 'Data lisensi berhasil diambil' : 'Data lisensi kosong',
                'status' => count($get) > 0 ? 'success' : 'error',
                'data' => count($get) > 0 ? $get : ''
            ]);
        }

        function see_licenses_by_id($id) {
            $get = DB::table('licenses_user')->where('Id', $id)->get();
            return response()->json([
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'message' => count($get) > 0 ? 'Data lisensi berhasil diambil' : 'Data lisensi kosong',
                'status' => count($get) > 0 ? 'success' : 'error',
                'data' => count($get) > 0 ? $get : ''
            ]);
        }

        function see_licenses_by_username($username) {
            $get = DB::table('licenses_user')->where('username', $username)->get();
            return response()->json([
                'title' => count($get) > 0 ? 'Berhasil' : 'Gagal',
                'message' => count($get) > 0 ? 'Data lisensi berhasil diambil' : 'Data lisensi kosong',
                'status' => count($get) > 0 ? 'success' : 'error',
                'data' => count($get) > 0 ? $get : ''
            ]);
        }

        function add_licenses($username, $winType, $winSerKey, $officeType, $officeSerKey, $location, $device) {
            $insert = array(
                'username' => $username,
                'winType' => $winType,
                'winSerKey' => $winSerKey,
                'officeType' => $officeType,
                'officeSerKey' => $officeSerKey,
                'location' => $location,
                'device' => $device
            );

            $add = DB::table('licenses_user')->insert($insert);
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil menambah data lisensi'
            ]);
        }

        function update_licenses($id, $username, $winType, $winSerKey, $officeType, $officeSerKey, $location, $device) {
            $insert = array(
                'username' => $username,
                'winType' => $winType,
                'winSerKey' => $winSerKey,
                'officeType' => $officeType,
                'officeSerKey' => $officeSerKey,
                'location' => $location,
                'device' => $device
            );

            $add = DB::table('licenses_user')->where('Id', $id)->update($insert);
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil mengubah data lisensi'
            ]);
        }

        function delete_licenses($id) {
            $delete = DB::select("DELETE FROM licenses_user where Id = $id");
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil menghapus data lisensi',
            ]);
        }
    }
?>