<?php 
    namespace App\Models\Proc;
    use Illuminate\Database\Eloquent\Model;
    use DB;

    class Itemtype extends Model {
        
        function see_itemtype($cari) {

            $where = '';
            if($cari != '' || $cari != null) {
                $where = " AND (itemtypename LIKE '%$cari%') OR (itemtypedescr LIKE '%$cari%')";
            }

            $get = DB::Connection('sql_eproc')->select("SELECT * FROM mitemtype where deleted=0 $where");
            if(count($get) > 0 ){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengambil data',
                    'title' => 'Berhasil',
                    'data' => $get
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengambil data',
                    'title' => 'Gagal',
                    'data' => ''
                ]);
            }
        }

        function see_itemtype_by_id($id) {
            $get = DB::Connection('sql_eproc')->select("SELECT * FROM mitemtype WHERE itemtypeid = '$id'");
            if(count($get) > 0 ){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengambil data',
                    'title' => 'Berhasil',
                    'data' => $get
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengambil data',
                    'title' => 'Gagal',
                    'data' => ''
                ]);
            }
        }

        function add_itemtype($id, $name, $descr, $updatedby) {
            $check = DB::Connection('sql_eproc')->select("SELECT * FROM mitemtype WHERE itemtypeid = '$id'");
            if(count($check) > 0 ){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data sudah ada',
                    'title' => 'Duplikasi',
                ]);
            }else{
                $insert = DB::Connection('sql_eproc')->select("INSERT INTO mitemtype(itemtypeid, itemtypename, itemtypedescr, updatedby) VALUES('$id', '$name', '$descr', '$updatedby')");
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menyimpan data',
                    'title' => 'Berhasil'
                ]);
            }
        }

        function edit_itemtype($id, $name, $descr, $updatedby) {
            $update = DB::Connection('sql_eproc')->select("UPDATE mitemtype SET itemtypename='$name', itemtypedescr='$descr', updatedby='$updatedby' WHERE itemtypeid = '$id'");

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengubah data',
                'title' => 'Berhasil'
            ]);
        }

        function delete_itemtype($id, $updatedby) {

            $total = count($id);

            for($i = 0; $i< $total; $i++) {
                $delete = DB::Connection('sql_eproc')->select("UPDATE mitemtype SET deleted=1 AND updatedby='$updatedby' WHERE itemtypeid='$id[$i]'");

            }
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus data',
                'title' => 'Berhasil'
            ]);
        }

        function see_last_id() {
            $get = DB::Connection('sql_eproc')->select("SELECT MAX(itemtypeid) AS id FROM mitemtype");
            $nilai = (int) $get[0]->id;
            $nilai = $nilai + 1;
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil mengambil data',
                'data' => $nilai
            ]);


        }



    }
?>