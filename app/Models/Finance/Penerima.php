<?php
    namespace App\Models\Finance;
    use Illuminate\Database\Eloquent\Model;
    use DB;

    class Penerima extends Model {
        function see_penerima() {
            $get = DB::Connection('mysql_fna')->select("SELECT a.npwp_id, a.penerima, a.Perusahaan, (CASE WHEN a.isPerson = 1 THEN 'Perorangan' ELSE 'Perusahaan' END) AS isPerson, a.npwp, a.alamat_1, a.alamat_2, a.alamat_3, a.KodeBankIDR, a.NoRek, a.Bank, a.KodeBankUSD, a.BankUSD, a.mail  FROM npwp a ORDER BY a.penerima ");

            if(count($get) == 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data  tidak ditemukan',
                    'title' => 'Gagal'
                ]);
            }else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengambil data',
                    'title' => 'Berhasil',
                    'data' => $get
                ]);
            }
        }

        function see_penerima_by_id($id) {
            $get = DB::Connection('mysql_fna')->select("SELECT *  FROM npwp  where npwp_id = $id");
            if(count($get) == 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data  tidak ditemukan',
                    'title' => 'Gagal'
                ]);
            }else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengambil data',
                    'title' => 'Berhasil',
                    'data' => $get
                ]);
            }

        }

        function add_penerima($penerima, $perusahaan, $isperson, $npwp, $alamat_1, $alamat_2, $alamat_3, $KodeBankIDR, $noRek, $bank, $kodebankUSD, $norekUSD, $bankUSD, $mail) {
            $insert = DB::Connection('mysql_fna')->select("INSERT INTO npwp (penerima, Perusahaan, isPerson, npwp, alamat_1, alamat_2, alamat_3, KodeBankIDR, NoRek, Bank, KodeBankUSD, NoRekUSD, BankUSD, Mail) VALUES('$penerima', '$perusahaan', '$isperson', '$npwp', '$alamat_1', '$alamat_2', '$alamat_3', '$KodeBankIDR', '$noRek', '$bank', '$kodebankUSD', '$norekUSD', '$bankUSD', '$mail')");

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menyimpan data',
                'title' => 'Berhasil'
            ]);
        }

        function edit_penerima($npwp_id, $penerima, $perusahaan, $isperson, $npwp, $alamat_1, $alamat_2, $alamat_3, $KodeBankIDR, $noRek, $bank, $kodebankUSD, $norekUSD, $bankUSD, $mail) {
            $update = DB::Connection('mysql_fna')->select("UPDATE npwp SET 
                penerima = '$penerima',
                Perusahaan = '$perusahaan',
                isPerson = '$isperson',
                npwp = '$npwp',
                alamat_1 = '$alamat_1',
                alamat_2 = '$alamat_2',
                alamat_3 = '$alamat_3',
                KodeBankIDR = '$KodeBankIDR',
                NoRek = '$noRek',
                Bank = '$bank',
                KodeBankUSD = '$kodebankUSD',
                NoRekUSD = '$norekUSD',
                BankUSD = '$bankUSD',
                Mail = '$mail'
            Where npwp_id = $npwp_id");

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengubah data',
                'title' => 'Berhasil'
            ]);
        }


        function delete_penerima($array) {
            $total = count($array);

            for($i = 0; $i< $total; $i++) {
                $delete = DB::Connection('mysql_fna')->select("DELETE FROM npwp  where npwp_id = ".$array[$i]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus data',
                'title' => 'Berhasil',
            ]);
        }
    }
?>