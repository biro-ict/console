<?php
    namespace App\Http\Controllers\Finance;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Finance\Budget;

    class budgetController extends Controller {
        private $model = '';

        public function __construct() { $this->model = new Budget(); }
        public function seeAreaFinance() {return $this->model->see_area_finance();}
        public function seeDeptFinance() {return $this->model->see_dept_finance();}
        public function seeBudgetHead() {return $this->model->see_budgetheader_finance();}
        public function seeYearFinance() {return $this->model->see_year_finance();}
        public function seeDetaiBudget(Request $req) {return $this->model->see_detail_budget($req->input('area'), $req->input('dept'), $req->input('head'), $req->input('year'));}
        public function updateBudget(Request $req) { return $this->model->update_budget($req->input('area'), $req->input('dept'), $req->input('mataanggaran'), $req->input('tahun'), $req->input('bulan'), $req->input('anggaran')); }
    
    }
?>