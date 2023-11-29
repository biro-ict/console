<?php
    namespace App\Models\Proc;
    use Illuminate\Database\Eloquent\Model;
    use DB;

    class Itemcategory extends Model {

        function see_itemcategory($cari) {
            $where = '';

            if($cari != null ||$cari !='') {
                $where = " AND ((itemcategoryname LIKE '%$cari%') OR (itemcategorydescr LIKE '%$cari%'))";
            }

            $get = DB::Connection('sql_eproc')->select("SELECT * FROM mitemcategory where deleted=0 $where");
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

        function see_itemcategory_by_id($id) {
            $get = DB::Connection('sql_eproc')->select("SELECT * FROM mitemcategory where itemcategoryid = '$id'");
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

        function add_itemcategory($id, $name, $descr, $updatedby) {
            $check = DB::Connection('sql_eproc')->select("SELECT * FROM mitemcategory WHERE itemcategoryid = '$id'");
            if(count($check) > 0 ) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data dengan id '.$id.' sudah ada',
                    'title' => 'Duplikasi'
                ]);
            }else{
                $insert = DB::Connection('sql_eproc')->select("INSERT INTO mitemcategory(itemcategoryid, itemcategoryname, itemcategorydescr, updatedby) VALUES('$id', '$name', '$descr', '$updatedby')");
                
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menambah data',
                    'title' => 'Berhasil',
                ]); 
            }
        }

        function edit_itemcategory($id, $name, $descr, $updatedby) {
            $update = DB::Connection('sql_eproc')->select("UPDATE mitemcategory SET itemcategoryname='$name', itemcategorydescr='$descr', updatedby='$updatedby' WHERE itemcategoryid='$id'");
                
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengubah data',
                    'title' => 'Berhasil',
                ]); 
            
        }

        function delete_itemcategory($id, $updatedby) {
            $total = count($id);

            for($i = 0; $i<count($id); $i++) {
                $delete = DB::Connection('sql_eproc')->select("UPDATE mitemcategory SET deleted=1, updatedby='$updatedby' WHERE itemcategoryid='$id[$i]'");

            }
          
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus data',
                'title' => 'Berhasil',
            ]); 
        }
        
        function see_last_id() {
            $get = DB::Connection('sql_eproc')->select("SELECT MAX(itemcategoryid) AS id FROM mitemcategory");
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