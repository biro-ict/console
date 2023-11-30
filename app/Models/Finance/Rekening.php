<?php
    namespace App\Models\Finance;
    use Illuminate\Database\Eloquent\Model;
    use DB;

    class Rekening extends Model {
       
        function show_bank($cari) {
            $where = '';
            if($cari!=null || $cari !='') {
                $where=" WHERE NamaBank LIKE '%$cari%'";
            }

            $get = DB::Connection('mysql_fna')->select("SELECT * FROM bank $where ORDER BY NamaBank");
            if(count($get) == 0 ) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data kosong',
                    'title' => 'Gagal'
                ]);
            }else{
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengambil data',
                    'title' => 'Berhasil',
                    'data' => $get
                ]);
            }
        }

        function show_rekening($datasource, $kodebank) {
            $where = '';
            if($datasource!=null) {$where = $where . " AND a.DataSource=$datasource";}
            if($kodebank!=null) {$where = $where . " AND a.KodeBank='$kodebank'";}
            $query = "SELECT a.KodeBank, b.NamaBank, a.Branch, a.NoRekening, a.MataUang, a.DataSource, a.MataAnggaran, (SELECT saldo FROM saldo WHERE NoRekening = a.NoRekening AND Tahun = YEAR(NOW()) AND Bulan = MONTH(NOW())) AS saldo FROM rekening a LEFT OUTER JOIN bank b ON a.KodeBank = b.KodeBank WHERE non_aktif = 0 $where ORDER BY a.MataUang";
            $get = DB::Connection('mysql_fna')->select($query);
            if(count($get) == 0 ) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data kosong',
                    'title' => 'Gagal'
                ]);
            }else{
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengambil data',
                    'title' => 'Berhasil',
                    'data' => $get,
                ]);
            }
        }

        function show_rekening_by_id($id) {
            $get = DB::Connection('mysql_fna')->select("SELECT * FROM rekening where NoRekening = '$id'");
            if(count($get) == 0 ) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data kosong',
                    'title' => 'Gagal'
                ]);
            }else{
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengambil data',
                    'title' => 'Berhasil',
                    'data' => $get
                ]);
            }
        }

        function show_currency($cari) {
            $where = $cari != '' ? " WHERE (MataUang LIKE '%$cari%') OR (NamaMataUang LIKE '%$cari%') OR (Negara LIKE '%$cari%')" : '';
            $get = DB::Connection('mysql_fna')->select("SELECT * FROM currency $where");
            if(count($get) == 0 ) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data kosong',
                    'title' => 'Gagal'
                ]);
            }else{
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengambil data',
                    'title' => 'Berhasil',
                    'data' => $get
                ]);
            }
        }

        function show_currency_by_id($id) {
            $get=DB::Connection('mysql_fna')->select("SELECT * FROM currency WHERE MataUang='$id'");
            if(count($get) == 0 ) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data kosong',
                    'title' => 'Gagal'
                ]);
            }else{
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengambil data',
                    'title' => 'Berhasil',
                    'data' => $get
                ]);
            }
        }

        function add_currency($matauang, $nama, $negara) {
            $check = DB::Connection('mysql_fna')->select("SELECT * FROM currency WHERE MataUang='$matauang'");
            if(count($check)==0){
                $insert=DB::Connection('mysql_fna')->select("INSERT INTO currency(MataUang, NamaMataUang, Negara) VALUES('$matauang', '$nama', '$negara')");
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menambah mata uang',
                    'title' => 'Berhasil'
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Kode mata uang sudah ada',
                    'title' => 'Gagal'
                ]);
            }
        }

        function edit_currency($matauang, $nama, $negara) {
            $update=DB::Connection('mysql_fna')->select("UPDATE currency SET NamaMataUang='$nama', Negara='$negara' WHERE MataUang='$matauang'");
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengubah mata uang '.$matauang,
                'title' => 'Berhasil'
            ]);
        }

        function delete_currency($array){
            $total=count($array);
            for($i=0;$i<$total;$i++) {
                $delete=DB::Connection('mysql_fna')->select("DELETE FROM currency WHERE MataUang='$array[$i]'");
            }

            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil menghapus mata uang'
            ]);
        }

        function add_rekening($kodeBank, $noRek, $matauang, $branch, $pemilik, $mataanggaran, $bm_prefix, $bk_prefix, $tr_prefix, $datasource) {
            $check = DB::Connection('mysql_fna')->select("SELECT * FROM rekening where NoRekening = $noRek");

            if(count($check) == 0) {
                $insert = DB::Connection('mysql_fna')->select("INSERT INTO rekening (KodeBank, NoRekening, MataUang, Branch, Pemilik, MataAnggaran, BM_Prefix, BK_Prefix, TR_Prefix, DataSource, non_aktif) VALUES('$kodeBank', '$noRek', '$matauang', '$branch', '$mataanggaran', '$bm_prefix', '$bk_prefix', '$tr_prefix', '$datasource', '0')");


                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menambah rekening',
                    'title' => 'Berhasil'
                ]);
            }else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Nomor rekening sudah ada',
                    'title' => 'Gagal'
                ]);
            }
        }

        function edit_rekening($kodeBank, $noRek, $matauang, $branch, $pemilik, $mataanggaran, $bm_prefix, $bk_prefix, $tr_prefix, $datasource) {
           
          
            $update = DB::Connection('mysql_fna')->select("UPDATE rekening SET KodeBank='$kodeBank', NoRekening='$noRek', MataUang='$matauang', Branch='$branch', Pemilik='$pemilik', MataAnggaran='$mataanggaran', BM_Prefix = '$bm_prefix', BK_Prefix='$bk_prefix', TR_Prefix='$tr_prefix', DataSource='$datasource' WHERE NoRekening='$noRek'");


            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menambah rekening',
                'title' => 'Berhasil'
            ]);
            
        }

        function delete_rekening($array) {
            $totals = count($array);
            for($i=0; $i<$totals; $i++) {
                $delete = DB::Connection('mysql_fna')->select("DELETE FROM rekening where NoRekening = ".$array[$i]);
                $delSaldo = DB::Connection('mysql_fna')->select("DELETE FROM saldo where NoRekening = ".$array[$i]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus rekening',
                'title' => 'Berhasil'
            ]);
        }
    }
?>