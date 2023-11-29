<?php 
    namespace App\Models\Proc;
    use Illuminate\Database\Eloquent\Model;
    use DB;

    class Warehouse extends Model {


        function see_warehouse($cari) {
            $where = '';
            if($cari != '' || $cari != null) {
                $where = " AND (a.warehousename LIKE '%$cari%') OR (a.warehousedescr LIKE '%$cari%')";
            }
            $query = "SELECT a.*, b.areaname FROM mwarehouse a LEFT OUTER JOIN marea b ON a.areaid = b.areaid where a.deleted =0 $where";
            $get = DB::Connection('sql_eproc')->select($query); 
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

        function see_warehouse_by_id($id) {
            $get = DB::Connection('sql_eproc')->select("SELECT * FROM mwarehouse where warehouseid='$id'"); 

            if(count($get) == 1) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengambil data',
                    'title' => 'Berhasil',
                    'data' => $get
                ]);
            }else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengambil data',
                    'title' => 'Gagal',
                    'data' => ''
                ]);
            }
        
        }


        function add_warehouse($id, $name, $descr, $updatedby) {
            $check = DB::Connection('sql_eproc')->select("SELECT * FROM mwarehouse WHERE warehouseid = '$id'");

            if(count($check) > 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data duplikasi',
                    'title' => 'Gagal',
                    'data' => ''
                ]);
            }else{
                $insert = DB::Connection('sql_eproc')->select(
                    "INSERT INTO mwarehouse(warehouseid, warehousename, warehousedescr, updatedby) VALUES('$id', '$name', '$descr', '$updatedby')");

                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menambah data',
                    'title' => 'Berhasil',
                ]); 
            }
        }

        function edit_warehouse($id, $name, $descr, $updatedby) {
            $update = DB::Connection('sql_eproc')->select("UPDATE mwarehouse SET warehousename='$name', warehousedescr='$descr', updatedby='$updatedby' WHERE warehouseid='$id'");

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengubah data',
                'title' => 'Berhasil',
            ]); 
        }

        function delete_warehouse($id, $updatedby) {
            $total = count($id);

            for($i = 0; $i< $total; $i++) {
                $delete = DB::Connection('sql_eproc')->select("UPDATE mwarehouse SET deleted=1, updatedby='$updatedby' WHERE warehouseid='$id[$i]'");

            }
          
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus data',
                'title' => 'Berhasil',
            ]); 
        }

        function see_lastid() {
            $get = DB::Connection('sql_eproc')->select("SELECT RIGHT(warehouseid, 3) AS id  FROM mwarehouse ORDER BY warehouseid DESC LIMIT 1");
            $nilai = (int) $get[0]->id;
            
            $nilai = $nilai + 1;
            $length = 3;
            //echo $nilai;  
            $result = '';
            for($i = 0; $i < $length - strlen($nilai); $i++) {
                $result = $result.'0';
            }

            $result = "DEL".$result.$nilai;
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil mengambil data',
                'data' => $result
            ]);
        }
    }
?>