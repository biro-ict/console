<?php
    namespace App\Models\Finance;
    use Illuminate\Database\Eloquent\Model;
    use DB;

    class Providers extends Model {
        function see_providers($cari) {
            $where = '';

            if($cari  != null || $cari != '') {
                $where = " Where (ProviderID LIKE '%$cari%') OR (Perusahaan LIKE '%$cari%')";
            }

            $get = DB::Connection('mysql_fna')->select("SELECT ProviderID, Perusahaan, ifnull(NPWP, '') as NPWP, ifnull(Rekening_USD, '') as Rekening_USD, ifnull(Rekening_IDR, '') as Rekening_IDR, MataAnggaran, COANonGas FROM provider $where");
            if(count($get) == 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data kosong',
                    'title' => 'Gagal',
                    'data' => ''
                ]);
            }else{
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data berhasil diambil',
                    'title' => 'Berhasil',
                    'data' => $get
                ]);
            }
        }

        function see_providers_by_id($id) {
            $get = DB::Connection('mysql_fna')->select("SELECT * FROM provider WHERE ProviderID='$id'");
            if(count($get) == 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data kosong',
                    'title' => 'Gagal',
                    'data' => ''
                ]);
            }else{
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data berhasil diambil',
                    'title' => 'Berhasil',
                    'data' => $get
                ]);
            }
        }

        function add_providers($id, $providerName, $providerNPWP, $providerAddress_1, $providerAddress_2, $providerAddress_3, $telp, $fax, $bank_usd, $rekeningname_usd, $rekening_usd, $bank_idr, $rekeningname_idr, $rekening_idr, $coagas, $deptgas, $areagas, $coanongas, $deptnongas, $areanongas) {
            $check = DB::Connection('mysql_fna')->select("SELECT * FROM provider WHERE ProviderID='$id'");
            if(count($check) > 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Kode Produsen Sudah ada',
                    'title' => 'Duplikasi'
                ]);
            }else{
                $add = DB::Connection('mysql_fna')->select("INSERT INTO 
                    provider(ProviderID, Perusahaan, NPWP, Alamat_1, Alamat_2, Alamat_3, Telephone, Fax, Bank_USD, Rekening_USD, Pemilik_USD, Bank_IDR, Rekening_IDR, Pemilik_IDR, MataAnggaran, DeptID, AreaCode, COANonGas, DeptNonGas, AreaNonGas) 
                    VALUES('$id', '$providerName', '$providerNPWP', '$providerAddress_1', '$providerAddress_2', '$providerAddress_2', '$providerAddress_3', '$telp', '$fax', '$bank_usd', '$rekening_usd', '$rekeningname_usd', '$bank_idr', '$rekening_idr', '$rekeningname_idr', '$coagas', '$deptgas', '$areagas', '$coanongas', '$deptnongas', '$areanongas')");

                return response()->json([
                    'status' => 'success',
                    'message' => 'Data berhasil disimpan',
                    'title' => 'Berhasil',
                ]);
            }
        }

        function update_providers($id, $providerName, $providerNPWP, $providerAddress_1, $providerAddress_2, $providerAddress_3, $telp, $fax, $bank_usd, $rekeningname_usd, $rekening_usd, $bank_idr, $rekeningname_idr, $rekening_idr, $coagas, $deptgas, $areagas, $coanongas, $deptnongas, $areanongas){
            $update = DB::Connection('mysql_fna')->select("UPDATE provider SET 
                Perusahaan='$providerName', NPWP='$providerNPWP', Alamat_1='$providerAddress_1', Alamat_2='$providerAddress_2',
                Alamat_3='$providerAddress_3', Telephone='$telp', Fax='$fax', Bank_USD='$bank_usd', Rekening_USD='$rekening_usd', Pemilik_USD='$rekeningname_usd', Bank_IDR='$bank_idr', Rekening_IDR='$rekening_idr', 'Pemilik_IDR='$rekeningname_idr', MataAnggaran='$coagas', DeptID='$deptgas', AreaCode='$areagas', COANonGas='$coanongas', DeptNonGas='$deptnongas', AreaNonGas='$areanongas'
            WHERE ProviderID='$id'");

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diubah',
                'title' => 'Berhasil',
            ]);
        }

        function delete_providers($id) {
            $total = count($id);
            for($i=0; $i<$total; $i++) {
                $delete =DB::Connection('mysql_fna')->select("DELETE FROM provider WHERE ProviderID='$id[$i]'");   
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus data produsen',
                'title' => 'Berhasil'
            ]);
        }




    }
?>