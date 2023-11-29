<?php 
    namespace App\Models\ICT;
    use Illuminate\Database\Eloquent\Model;
    use DB;

    class Corus extends Model { 

        function see_configurasi() {
            $get = DB::Connection('sql_corus')->select("SELECT a.serialnumber, a.corusVersion, a.ConnectionName, b.Converter_Serial_Number, a.RemoteAddress, a.STATUS, a.LastInfo FROM configurasi a LEFT OUTER JOIN instaneous_log b ON a.CorusVersion = b.Customer WHERE a.status = 1 ORDER BY corusVersion ASC");

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
                    'title' => 'Gagal'
                ]);
            }
        }

        function see_customer() {
            $get = DB::Connection('sql_corus')->select("SELECT a.Customer_data_1, b.ConnectionName,  a.Converter_Serial_Number FROM param_log a INNER JOIN configurasi b ON a.Customer_Data_1 = b.CorusVersion");

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
                    'title' => 'Gagal'
                ]);
            }

        }

        function see_old_number($cust) {
            $get = DB::Connection('sql_corus')->select("SELECT a.Customer_data_1, b.ConnectionName,  a.Converter_Serial_Number FROM param_log a INNER JOIN configurasi b ON a.Customer_Data_1 = b.CorusVersion where a.Customer_Data_1 = '$cust' LIMIT 1");

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
                    'title' => 'Gagal'
                ]);
            }

        }

        function update_corus($username, $customer, $old_sn, $new_sn) {
            $update =  DB::Connection('sql_corus')->select("UPDATE param_log SET Converter_Serial_Number = '$new_sn' WHERE Customer_Data_1='$customer'");

            $update2 = DB::Connection('sql_corus')->select("UPDATE instaneous_log SET Converter_Serial_Number = '$new_sn' WHERE Customer = '$customer'");

            //for sensor
            $get = DB::Connection('sql_corus')->select("SELECT * FROM sensor_log where Customer = '$customer'");
            if(count($get) > 0) {
                $update = DB::Connection('sql_corus')->select("UPDATE sensor_log SET Converter_Serial_Number='$new_sn' WHERE Customer='$customer';");
            }

            $log = DB::Connection('sql_corus')->select("INSERT INTO log_change_corus(username, customer, old_sn, new_sn) VALUES('$username', '$customer', '$old_sn', '$new_sn')");
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengupdate data',
                'title' => 'Berhasil'
            ]);
        }

        function checkDuplicate () {
            $get = DB::Connection('sql_corus')->select("SELECT Customer, COUNT(*) as total FROM instaneous_log GROUP BY Customer");
            
            foreach($get as $g) {
                if($g->total > 1) {
                    $check = DB::Connection('sql_corus')->select("SELECT * FROM instaneous_log WHERE Customer = '$g->Customer' ORDER BY Current_Date_Time ASC LIMIT 1");
                    $Converter_Serial_Number =  $check[0]->Converter_Serial_Number;
                    $delete = DB::Connection('sql_corus')->select("DELETE FROM instaneous_log WHERE Converter_Serial_Number = '$Converter_Serial_Number'");
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Berhasil menghapus duplikasi',
                        'title' => 'Berhasil'
                    ]);

                }else{
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Tidak ada duplikasi terdeteksi',
                        'title' => 'Error'
                    ]);
                }
            }
        }
    }
?>