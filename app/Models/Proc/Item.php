<?php
    namespace App\Models\Proc;
    use Illuminate\Database\Eloquent\Model;
    use DB;

    class Item extends Model {

        function see_item($tipe, $kategori, $s_po, $s_stock, $cari) {
            $where = $tipe != '' ? " AND (a.itemtypeid='$tipe')" : '';
            $where = $kategori != '' ? " AND (a.itemcategoryid='$kategori')" : $where;
            $where = $s_po != '' ? "AND (a.itemmeasureid_buy='$s_po')" : $where;
            $where = $s_stock != '' ? "AND (a.itemmeasureid_base='$s_stock')" : $where;
            $where = $cari != '' ? "AND ((a.itemname LIKE '%$cari%' ) OR (a.usertext  LIKE '%$cari'))" : $where;

            $query = "SELECT a.itemid, a.itemname, c.itemtypedescr AS tipe, b.itemcategoryname AS kategori,  d.itemmeasurename AS satuan_po, (SELECT itemmeasurename FROM mitemmeasure WHERE itemmeasureid = a.itemmeasureid_base) AS satuan_stok, a.usertext AS spesifikasi FROM mitem a LEFT JOIN mitemcategory b ON a.itemcategoryid = b.itemcategoryid LEFT JOIN mitemtype c ON c.itemtypeid = a.itemtypeid LEFT JOIN mitemmeasure d ON a.itemmeasureid_buy = d.itemmeasureid where a.deleted=0 $where LIMIT 1000";

            $get = DB::Connection('sql_eproc')->select($query); 
            if(count($get) > 0) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengambil data',
                    'title' => 'Berhasil',
                    'data' => $get,
                    'query' => $query
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

        function see_item_by_id($id) {
            $get = DB::Connection('sql_eproc')->select("SELECT * FROM mitem where itemid = '$id'");
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

        function add_item($itemid, $itemcategory, $itemtype, $itemmeasureid_buy, $itemmeasureid_base, $itemname, $usertext, $updatedby) {
            $check = DB::Connection("sql_eproc")->select("SELECT * FROM mitem WHERE itemid = '$itemid'");
            if(count($check) > 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Item id sudah ada',
                    'title' => 'Duplikasi'
                ]);
            }else{
                $insert = DB::Connection('sql_eproc')->select("INSERT INTO mitem(itemid, itemcategoryid, itemtypeid, itemmeasureid_buy, itemmeasureid_base, itemname, usertext, updatedby) VALUES('$itemid', '$itemcategory', '$itemtype', '$itemmeasureid_buy', '$itemmeasureid_base', '$itemname', '$usertext', '$updatedby')");

                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menambah data',
                    'title' => 'Berhasil'
                ]);
            }
        }

        function edit_item($itemid, $itemcategory, $itemtype, $itemmeasureid_buy, $itemmeasureid_base, $itemname, $usertext, $updatedby){
            $update = DB::Connection('sql_eproc')->select("UPDATE mitem SET itemcategoryid='$itemcategory', itemtypeid='$itemtype', itemmeasureid_buy='$itemmeasureid_buy', itemmeasureid_base='$itemmeasureid_base', itemname='$itemname', usertext='$usertext', updatedby='$updatedby' WHERE itemid='$itemid'");

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengubah data',
                'title' => 'Berhasil'
            ]);

        }
        
        function delete_item($itemid,  $updatedby) {
            $count = count($itemid);

            for($i=0; $i<$count; $i++) {
                $delete = DB::Connection('sql_eproc')->select("UPDATE mitem SET deleted=1 AND updatedby='$updatedby' WHERE itemid='$itemid[$i]'");
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus data',
                'title' => 'Berhasil'
            ]);
        }

        function see_last_id() {
            $get = DB::Connection('sql_eproc')->select("SELECT RIGHT(itemid, 5) AS id  FROM mitem ORDER BY itemid DESC LIMIT 1");
            $nilai = (int) $get[0]->id;
            
            $nilai = $nilai + 1;
            $length = 7;
            //echo $nilai;  
            $result = '';
            for($i = 0; $i < $length - strlen($nilai); $i++) {
                $result = $result.'0';
            }

            $result = "ITE".$result.$nilai;
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil mengambil data',
                'data' => $result
            ]);
        }
    }
?>