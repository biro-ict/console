<?php 
    namespace App\Models\Finance;
    use Illuminate\Database\Eloquent\Model;
    use DB;

    class Budget extends Model {

        function see_area_finance() {
            $get = DB::Connection('mysql_fna')->select("SELECT * FROM area WHERE AreaNoNActive = 0");
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengambil data',
                'title' => 'Berhasil',
                'data' => $get
            ]);
        }
    

        function see_dept_finance() {
            $get = DB::Connection('mysql_fna')->select("SELECT * FROM department WHERE deleted=0 ORDER BY KodeDir, Nomor");
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengambil data',
                'title' => 'Berhasil',
                'data' => $get
            ]);
        }

        function see_budgetheader_finance() {
            $get = DB::Connection('mysql_fna')->select(" SELECT * FROM budget WHERE LENGTH(MataAnggaran) > 4 AND Kelompok = 'Budget' ORDER BY KodeInduk");
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengambil data',
                'title' => 'Berhasil',
                'data' => $get
            ]);
        }

        function see_year_finance() {
            $get = DB::Connection('mysql_fna')->select("SELECT Tahun FROM budgetset WHERE Tahun BETWEEN 2016 AND YEAR(NOW()) GROUP BY Tahun ORDER BY Tahun ASC");

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengambil data',
                'title' => 'Berhasil',
                'data' => $get
            ]);
        }

        function see_detail_budget($area, $dept, $mataanggaran, $tahun){
            $query = "SELECT a.AreaCode, a.DeptID, b.department AS DeptName, c.AreaName, a.MataAnggaran, d.Ikhtisar, a.Tahun, a.Bulan, a.Anggaran, a.Realisasi FROM budgetset a JOIN department b ON a.DeptID = b.DeptID JOIN area c ON a.AreaCode = c.AreaCode JOIN budget d ON a.MataAnggaran = d.MataAnggaran WHERE a.DeptID = '$dept' AND a.AreaCode = '$area' AND a.Tahun = $tahun AND a.MataAnggaran = $mataanggaran ORDER BY a.Bulan ASC";
            $get = DB::Connection('mysql_fna')->select($query);

            $query_failed = "SELECT 
            (SELECT department FROM department WHERE DeptID = '$dept') AS deptName, (SELECT Ikhtisar FROM budget WHERE MataAnggaran = $mataanggaran) AS Ikhtisar";
            $get_failed = DB::Connection('mysql_fna')->select($query_failed);

            if(count($get) > 0) {
                $query_sum = "SELECT SUM(Anggaran) as total_anggaran, SUM(Realisasi) as total_real FROM budgetset a JOIN department b ON a.DeptID = b.DeptID JOIN area c ON a.AreaCode = c.AreaCode JOIN budget d ON a.MataAnggaran = d.MataAnggaran WHERE a.DeptID = '$dept' AND a.AreaCode = '$area' AND a.Tahun = $tahun AND a.MataAnggaran = $mataanggaran";
                $sum = DB::Connection('mysql_fna')->select($query_sum);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengambil data',
                    'title' => 'Berhasil',
                    'total' => $sum,
                    'data' => $get,
                    'data2' => $get_failed
                ]);
            }else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengambil data',
                    'title' => 'Gagal',
                    'data2' => $get_failed
                ]);
            }
        }

        function update_budget($area, $dept, $mataanggaran, $tahun, $bulan, $anggaran) {
            $total = count($bulan); 
            
            $anggaran_total = '';
            for($i=0; $i<$total; $i++) {
                $query_check = "SELECT * from budgetset where AreaCode = '$area' AND DeptID='$dept' AND Tahun=$tahun AND Bulan=$bulan[$i] AND MataAnggaran=$mataanggaran";
                $sql_check = DB::Connection('mysql_fna')->select($query_check);
                if(count($sql_check) == 1) {
                    //if data exists, update
                    $query_data = "UPDATE budgetset SET Anggaran='$anggaran[$i]' where AreaCode = '$area' AND DeptID='$dept' AND Tahun=$tahun AND Bulan='$bulan[$i]' AND MataAnggaran=$mataanggaran";
                }else {
                    //if data empty, insert
                    $query_data = "INSERT INTO budgetset(DeptID, AreaCode, MataAnggaran, Bulan, Tahun, Anggaran) VALUES('$dept', '$area', '$mataanggaran', '$bulan[$i]', $tahun, '$anggaran[$i]')";
                }

                DB::Connection('mysql_fna')->select($query_data);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengupdate budget',
                'title' => 'success'
            ]);
        }
    }

?>