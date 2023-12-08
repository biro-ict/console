<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\Grade;

    class gradeController extends Controller {
        private $model='';

        public function __construct(){
            $this->model = new Grade();
        }

        public function seeGrade() {
            return $this->model->see_grade();
        }

        public function seeById($id) {
            return $this->model->see_by_id($id);
        }


        public function searchGrade(Request $req) {
            return $this->model->search_grade($req->input('query'));
        }

        public function addGrade(Request $req) {
            return $this->model->add_grade($req->input('name'), $req->input('code'));
        }

        public function updateGrade(Request $req) {
            return $this->model->update_grade(
                $req->input('id'), 
                $req->input('name'), 
                $req->input('code'));
        }

        public function deleteGrade(Request $req) {
            return $this->model->delete_grade($req->input('id'));
        }
    }
?>