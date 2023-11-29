<?php
    namespace App\Models\Proc;
    use Illuminate\Database\Eloquent\Model;
    use DB;

    class Groupsupplier extends Model {

        function see_group($cari) {
            $where = '';

            if($cari != null || $cari = '') {
                $where = " AND ((bpgroupname LIKE '%$cari%') OR (bpgroupdescr LIKE '%$cari%'))";
            }

            $get = DB::Connection('sql_eproc')->select("SELECT * FROM mbpgroup where deleted=0 $where ORDER BY bpgroupname ASC");
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

        function see_group_by_id($id) {
            $get = DB::Connection('sql_eproc')->select("SELECT * FROM mbpgroup where bpgroupid='$id' ORDER BY bpgroupname ASC");
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

        function add_group($bpgroupid, $bpgroupname, $bpgroupdescr, $updatedby) {
            $check = DB::Connection('sql_eproc')->select("SELECT * FROM mbpgroup WHERE bpgroupid='$bpgroupid'");
            if(count($check) > 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Group id sudah ada',
                    'title' => 'Duplikasi',
                    'id' => $bpgroupid
                ]);
            }else{
                $insert = DB::Connection('sql_eproc')->select("INSERT INTO mbpgroup(bpgroupid, bpgroupname, bpgroupdescr, bpgrouptype, updatedby) VALUES('$bpgroupid', '$bpgroupname', '$bpgroupdescr', 'S', '$updatedby')");
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menambah data',
                    'title' => 'Berhasil',
                ]);
            }
        }

        function edit_group($bpgroupid, $bpgroupname, $bpgroupdescr, $updatedby) {
            $update = DB::Connection('sql_eproc')->select("UPDATE mbpgroup SET bpgroupname='$bpgroupname', bpgroupdescr='$bpgroupdescr', updatedby='$updatedby' WHERE bpgroupid='$bpgroupid'");
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengubah data',
                'title' => 'Berhasil',
            ]);
        }

        function delete_group($bpgroupid, $updatedby) {
            $count = count($bpgroupid);
            for($i=0; $i<$count; $i++) {
                $delete = DB::Connection('sql_eproc')->select("UPDATE mbpgroup SET deleted=1, updatedby='$updatedby' WHERE bpgroupid='$bpgroupid[$i]'");
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus data',
                'title' => 'Berhasil',
            ]);
        }

        
        function see_last_id() {
            $get = DB::Connection('sql_eproc')->select("SELECT MAX(bpgroupid) AS id FROM mbpgroup");
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