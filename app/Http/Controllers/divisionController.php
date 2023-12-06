<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\Division;

    class divisionController extends Controller {
        private $model='';

        public function __construct() {
            $this->model = new Division();
        }

        public function seeDivision() {
            return $this->model->see_division();
        }

        public function searchDivision(Request $req) {
            return $this->model->search_division($req->input('cari'), $req->input('dir'));
        }

        public function addDivision(Request $req) {
            return $this->model->add_division($req->input('divisionName'), $req->input('divisiCode'), $req-> input('dirId'));
        }

        public function updateDivision(Request $req) {
            return $this->model->update_division($req->input('divisionName'), $req->input('divisiCode'), $req-> input('dirId'), $req->input('id'));
        }

        public function deleteDivision(Request $req) {
            return $this->model->delete_division($req->input('id'));
        }
    }
?>