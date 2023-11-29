<?php 
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class Macradius extends Model {
        function search_mac($q) {
            $where = "(mac LIKE '%$q%') or (description LIKE '%$q%') or (ipaddr LIKE '%$q%')";
            $get = DB::connection('mysql_second')->select("SELECT * FROM macaddr where $where");
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengambil data',
                'title' => 'Berhasil',
                'data' => $get
            ]);
        }

        function see_by_id($mac) {
            $get = DB::connection('mysql_second')->select("Select * from macaddr where mac = '$mac'");
            return (count($get) > 0)  ? response()->json([
                'title' => 'Berhasil',
                'message' => 'Berhasil mengambil data',
                'status' => 'success',
                'data' => $get
            ]) : response()->json([
                'title' => 'Gagal',
                'message' => 'Gagal mengambil data',
                'status' => 'error'
            ]);
        }

        function add_macradius($mac, $desc, $ipaddr) {
            $check = DB::Connection('mysql_second')->select("SELECT * FROM macaddr WHERE mac = '$mac'");
            if(count($check) > 0) {
                return response()->json([
                    'status' => 'error',
                    'title' => 'Duplikasi',
                    'message' => 'Ooops, mac address yang kamu masukan sudah ada'
                ]);
            }
            
            $insert = DB::Connection('mysql_second')->select("INSERT INTO macaddr (mac, description, ipaddr) values ('$mac', '$desc', '$ipaddr')");
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menambah data',
                'title' => 'Berhasil'
            ]);
        }

        function update_macradius($mac, $desc, $ipaddr) {
            $insert = DB::Connection('mysql_second')->select("UPDATE macaddr SET description = '$desc', ipaddr='$ipaddr' WHERE mac='$mac'");
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengubah data',
                'title' => 'Berhasil'
            ]);
        }

        function delete_macradius($mac) {
            $delete = DB::connection('mysql_second')->select("DELETE FROM macaddr where mac = '$mac'");
            return response()->json([
                'title' => 'Berhasil',
                'status' => 'success',
                'message' => 'Berhasil menghapus data'
            ]);
        }
    }
?>