<?php
    namespace App\Models\Proc;
    use Illuminate\Database\Eloquent\Model;
    use DB;

    class Itemmeasure extends Model {
        function see_itemmeasure($cari) {
            $where = '';
            if($cari != null || $cari != '') {
                $where = " WHERE (itemmeasurename LIKE '%$cari%') OR (itemmeasuredescr LIKE '%$cari%')";
            }

            $get = DB::Connection('sql_eproc')->select("SELECT * FROM mitemmeasure $where");
            if(count($get) > 0) {
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

        function see_itemmeasure_by_id($id) {
            $get = DB::Connection('sql_eproc')->select("SELECT * FROM mitemmeasure where itemmeasureid = '$id'");
            if(count($get) > 0) {
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

        function add_itemmeasure($id, $name, $descr, $updatedby) {
            $check = DB::Connection('sql_eproc')->select("SELECT * FROM mitemmeasure WHERE itemmeasureid = '$id'");
            if(count($check) > 0 ) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data dengan id '.$id.' sudah ada',
                    'title' => 'Duplikasi'
                ]);
            }else{
                $insert = DB::Connection('sql_eproc')->select("INSERT INTO mitemmeasure(itemmeasureid, itemmeasurename, itemmeasuredescr, updatedby) VALUES('$id', '$name', '$descr', '$updatedby')");
                
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menambah data',
                    'title' => 'Berhasil',
                ]); 
            }
        }

        function edit_itemmeasure($id, $name, $descr, $updatedby) {
            $update = DB::Connection('sql_eproc')->select("UPDATE mitemmeasure SET itemmeasurename='$name', itemmeasuredescr='$descr', updatedby='$updatedby' WHERE itemmeasureid='$id')");
                
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengubah data',
                    'title' => 'Berhasil',
                ]); 
            
        }

        function delete_itemmeasure($id, $updatedby) {
            $total = count($id);

            for($i = 0; $i<count($id); $i++) {
                $delete = DB::Connection('sql_eproc')->select("UPDATE mitemmeasure SET deleted=1, updatedby='$updatedby' WHERE itemmeasureid='$id[$i]'");

            }
          
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus data',
                'title' => 'Berhasil',
            ]); 
        }
        
        function see_lastid() {
            $get = DB::Connection('sql_eproc')->select("SELECT RIGHT(itemmeasureid, 3) AS id  FROM mitemmeasure ORDER BY itemmeasureid DESC LIMIT 1");
            $nilai = (int) $get[0]->id;
            
            $nilai = $nilai + 1;
            $length = 3;
            //echo $nilai;  
            $result = '';
            for($i = 0; $i < $length - strlen($nilai); $i++) {
                $result = $result.'0';
            }

            $result = "UNIT".$result.$nilai;
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil mengambil data',
                'data' => $result
            ]);
        }
    }
?>