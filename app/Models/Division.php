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
                    'title' => 'We have the data'
                ]);
            }

        }

        function search_division($search, $dirs) {
            $where = '';
            if($search != null || $search != '') {
                $where = " AND (divisionName LIKE '%$search%') OR (divisiCode LIKE '%$search%')'"; 
            }
            if($dirs != null || $dirs != '') {
                $where = " AND dirId=$dirs"; 
            }

            $query = "SELECT * FROM division WHERE deleted=0 $where ORDER BY divisionName ASC";
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
                    'title' => 'We have the data'
                ]);
            }

        }
    }

?>