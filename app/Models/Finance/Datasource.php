<?php
    namespace App\Models\Finance;
    use Illuminate\Database\Eloquent\Model;
    use DB;

    class Datasource extends Model {

        function see_datasource($cari) {
            $where = $cari != '' ? " WHERE (DataSourceName LIKE '%$cari%' OR DataSource LIKE '%$cari%' OR Approved LIKE '%$cari%')" : "";
            $get = DB::Connection('mysql_fna')->select("SELECT * FROM datasource $where"); 

            if(count($get) > 0) {
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

        function see_datasource_detil($id) {
            $get = DB::Connection('mysql_fna')->select("SELECT * FROM datasource where DataSource = $id");
            if(count($get) == 1) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengambil data',
                    'title' => 'Berhasil',
                    'data' => $get
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan',
                    'title' => 'Gagal',
                    'data' => ''
                ]);
            }
        }

        function add_dataSource($id, $name, $desc, $appr) {
            $get = DB::Connection('mysql_fna')->select("SELECT * FROM datasource where DataSource = $id");
            if(count($get) > 0) {
                //if exists
                return response()->json([
                    'status' => 'error',
                    'title' => 'Duplicate',
                    'message' => 'Datasource sudah ada',
                ]);
            }else {
                //add 
                $insert = DB::Connection('mysql_fna')->select("INSERT INTO datasource (DataSource, DataSourceName, DataSourceDescr, Approved) VALUES('$id', '$name', '$desc', '$appr')");

                return response()->json([
                    'status' => 'success',
                    'title' => 'Berhasil',
                    'message' => 'Berhasil menambah datasource',
                ]);
            }
        }


        function updateData($id, $name, $desc, $appr) {
            $query = "UPDATE datasource SET DataSourceName='$name', DataSourceDescr='$desc', Approved='$appr' where DataSource = '$id'";
            $insert = DB::Connection('mysql_fna')->select($query);

            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil mengubah datasource'
            ]);
            
        }

        function delDataSource($array) {
            $total = count($array);


            for($i = 0 ; $i < $total; $i++) {
                $delete = DB::Connection('mysql_fna')->select('DELETE FROM datasource where  DataSource= '.$array[$i]);
            }
               
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil menghapus datasource'
            ]);
            
        }
    }
?>