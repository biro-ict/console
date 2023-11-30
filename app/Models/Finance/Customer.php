<?php
    namespace App\Models\Finance;
    use Illuminate\Database\Eloquent\Model;
    use DB;

    class Customer extends Model {

        function see_customers($cari) {
            $where='';
            if($cari!=null || $cari!='') {$where=" WHERE Perusahaan LIKE '%$cari%'";}
            $get = DB::Connection('mysql_fna')->select("SELECT CustID, DeviceID, KodePerusahaan, Perusahaan, npwp, KontakPerson, Telephone, Jabatan, MataAnggaran FROM customer $where");
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

        function  add_customer() {

        }

        function update_customer() {

        }

        function delete_customer($id) {
            $total = count($id);
            for($i=0; $i<$total; $i++) {
                $delete =DB::Connection('mysql_fna')->select("DELETE FROM provider WHERE CustID='$id[$i]'");   
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus data Customer',
                'title' => 'Berhasil'
            ]);
        }
    }
?>