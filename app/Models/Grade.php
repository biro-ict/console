<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class Grade extends Model {
        function see_grade() {
            $get = DB::SELECT("SELECT * FROM grade WHERE deleted=0");
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
            $get = DB::SELECT("SELECT * FROM grade WHERE deleted=0 AND id=$id");

        }

        function add_grade($name, $code) {
            $check = DB::select("SELECT * FROM grade where gradeCode='$code'");

            if(count($check) > 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'grade with code '.$code.' already exists',
                    'title' => 'Duplicate'
                ]);
            }else {

                $insert = DB::Select("INSERT INTO grade(gradeName, gradeCode) VALUES('$name', '$code')");
                return response()->json([
                    'status' => 'success',
                    'message' => 'successfully add data',
                    'title' => 'Yeah!'
                ]);
            }
        }

        function update_grade($id, $name, $code) {
            $check = DB::select("SELECT * FROM grade where gradeCode='$code'");

            if(count($check) > 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'grade with code '.$code.' already exists',
                    'title' => 'Duplicate'
                ]);
            }else {

                $insert = DB::Select("UPDATE grade SET gradeName='$name', gradeCode='$code' WHERE id=$id");
                return response()->json([
                    'status' => 'success',
                    'message' => 'successfully add data',
                    'title' => 'Yeah!'
                ]);
            }
        }

        function delete_grade($id) {
            $total = count($id);

            for($i=0; $i<$total; $i++) {
                $delete = DB::SELECT("DELETE FROM grade WHERE id='$id[$i]'");
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully deleted some data',
                'title' => 'Yeah!'
            ]);
        }
    }


?>