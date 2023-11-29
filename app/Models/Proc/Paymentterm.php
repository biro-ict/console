<?php 
    namespace App\Models\Proc;
    use Illuminate\Database\Eloquent\Model;
    use DB;

    class Paymentterm extends Model {

        function see_paymentterm($cari) {
            $where = '';

            if($cari != null || $cari != ''){
                $where = " AND ((paymenttermname LIKE '%$cari%') OR (paymenttermdescr LIKE '%$cari%'))";
            }

            $get = DB::Connection('sql_eproc')->select("SELECT * FROM mpaymentterm where deleted=0 $where");
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

        function see_paymentterm_by_id($id) {
            $get = DB::Connection('sql_eproc')->select("SELECT * FROM mpaymentterm where paymenttermid='$id'");
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

        function add_paymentterm($paymenttermid, $paymenttermname, $paymenttermdescr, $updatedby) {
            $check = DB::Connection('sql_eproc')->select("SELECT * FROm mpaymentterm where paymenttermid='$paymenttermid'");

            if(count($check) > 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data sudah ada',
                    'title' => 'Duplikasi',
                ]);
            }else {
                $insert = DB::Connection('sql_eproc')->select("INSERT INTO mpaymentterm(paymenttermid, paymenttermname, paymenttermdescr, updatedby) VALUES('$paymenttermid', '$paymenttermname', '$paymenttermdescr', '$updatedby')");

                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menambah data',
                    'title' => 'Berhasil'
                ]);
            }
        }

        function edit_paymentterm($paymenttermid, $paymenttermname, $paymenttermdescr, $updatedby){
            $update = DB::Connection('sql_eproc')->select("UPDATE mpaymentterm SET paymenttermname='$paymenttermname', paymenttermdescr='$paymenttermdescr', updatedby='$updatedby' WHERE paymenttermid='$paymenttermid'");

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menambah data',
                'title' => 'Berhasil'
            ]);
        }

        function delete_payment($paymenttermid, $updatedby) {
            $count = count($paymenttermid);

            for($i=0; $i<$count; $i++) {
                $delete = DB::Connection('sql_eproc')->select("UPDATE mpaymentterm SET deleted=1, updatedby='$updatedby' where paymenttermid='$paymenttermid[$i]'");
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus data',
                'title' => 'Berhasil'
            ]);
        }

        function see_last_id() {
            $get = DB::Connection('sql_eproc')->select("SELECT RIGHT(paymenttermid, 3) AS id  FROM mpaymentterm ORDER BY paymenttermid DESC LIMIT 1");
            $nilai = (int) $get[0]->id;
            
            $nilai = $nilai + 1;
            $length = 3;
            //echo $nilai;  
            $result = '';
            for($i = 0; $i < $length - strlen($nilai); $i++) {
                $result = $result.'0';
            }

            $result = "PAY".$result.$nilai;
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil mengambil data',
                'data' => $result
            ]);
        }
    }

    
?>