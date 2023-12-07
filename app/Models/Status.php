<?php 
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class Status extends Model {

        function see_status() {
            $get = DB::Select("SELECT * FROM mstatus WHERE deleted=0");

            if(count($get) > 0) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully get data',
                    'title' => 'Berhasil',
                    'data' => $get
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry, grade not found',
                    'title' => 'Ooops'
                ]);
            }

        }

        function see_by_id($id) {
            $get = DB::Select("SELECT * FROM mstatus WHERE deleted=0 AND id=$id");

            if(count($get) > 0) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully get data',
                    'title' => 'Berhasil',
                    'data' => $get
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry, grade not found',
                    'title' => 'Ooops'
                ]);
            }

        }

        function add_status($name, $code) {
            $check = DB::select("SELECT * FROM mstatus where statusCode='$code'");

            if(count($check) > 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'status with code '.$code.' already exists',
                    'title' => 'Duplicate'
                ]);
            }else {  

                $insert = DB::Select("INSERT INTO mstatus(statusName, statusCode) VALUES('$name', '$code')");
                return response()->json([
                    'status' => 'success',
                    'message' => 'successfully add data',
                    'title' => 'Yeah!'
                ]);
            }

        }

        function update_status($id, $name, $code) {
            $update = DB::Select("UPDATE mstatus SET statusName='$name', statusCode='$code' WHERE id=$id");
            return response()->json([
                'status' => 'success',
                'message' => 'successfully update data',
                'title' => 'Yeah!'
            ]);
      
        }

        function delete_status($id) {
            $total = count($id);

            for($i=0; $i<$total; $i++) {
                $delete = DB::SELECT("UPDATE mstatus SET deleted=1, deletedTime=now() WHERE id='$id[$i]'");
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully deleted some data',
                'title' => 'Yeah!'
            ]);
        }
    }