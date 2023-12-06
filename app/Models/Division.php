<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class Division extends Model {

        function see_division() {
            $get = DB::table('division')->where('deleted', 0)->get();
            if(count($get) == 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry, nothing found',
                    'title' => 'We don\'t have data'
                ]);
            }else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data has been loaded successfully',
                    'title' => 'We have the data',
                    'data' => $get
                ]);
            }

        }

        function see_division_by_id($id) {
            $get = DB::select('SELECT * FROM division WHERE deleted=0 and id='.$id);
            if(count($get) == 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry, nothing found',
                    'title' => 'We don\'t have data'
                ]);
            }else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data has been loaded successfully',
                    'title' => 'We have the data',
                    'data' => $get
                ]);
            }

        }

        function search_division($search, $dirs) {
            $where = '';
            if($search != null || $search == '') {
                $where = "AND ((a.divisionName LIKE '%$search%') OR (a.divisiCode LIKE '%$search%'))"; 
            }

            if($dirs != null || $dirs != '') {
                $where = " $where AND a.dirId=$dirs"; 
            }

            $query = "SELECT a.id, a.divisionName, a.divisiCode, b.name as dirName FROM division  a JOIN directory b ON a.dirId =b.id WHERE a.deleted=0 $where ORDER BY a.divisionName ASC";
            $get = DB::select($query);
            if(count($get) == 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry, nothing found',
                    'title' => 'We don\'t have data'
                ]);
            }else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data has been loaded successfully',
                    'title' => 'We have the data',
                    'data' => $get,
                ]);
            }

        }


        function add_division($divisionName, $divisiCode, $dirId) {
            $query = "SELECT * FROM division WHERE divisiCode ='$divisiCode' ";
            $check = DB::SELECT($query);
            if(count($check) == 1) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You already have division whom have this code',
                    'title' => 'Duplicate'
                ]);
            }else {
                $query = "INSERT INTO division(divisionName, divisiCode, dirId) VALUES('$divisionName', '$divisiCode', '$dirId')";
                $insert = DB::SELECT($query);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully add division',
                    'title' => 'Successfully Added'
                ]);
            }
        }
    
        function update_division($divisionName, $divisiCode, $dirId, $id) {
            $query = "SELECT * FROM divison WHERE divisiCode ='$divisiCode' ";
            $check = DB::SELECT($query);
            if(count($check) == 1) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You already have division whom have this code',
                    'title' => 'Duplicate'
                ]);
            }else {
                $query = "UPDATE division SET divisionName='$divisionName', divisiCode='$divisiCode', dirId='$dirId' WHERE id=$id)";
                $insert = DB::SELECT($query);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully update division',
                    'title' => 'Succesfully Updated'
                ]);
            }
        }
    
        function delete_division($id) {
            $count = count($id);
            for($i=0;$i<$count;$i++) {
                $query = "UPDATE division SET deleted=1, deletedTime=now() WHERE id=$id[$i]";
                $insert = DB::SELECT($query);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully delete division',
                    'title' => 'Succesfully deleted'
                ]); 
           }
        }
    }
?>