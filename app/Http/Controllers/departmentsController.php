<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\Departments;

    class departmentsController extends Controller{
        private $model = '';

        public function __construct() {
            $this->model = new Departments();
        }

        public function seeDepts() {
            return $this->model->see_depts();
        }

        public function searchDepts(Request $req) {
            return $this->model->search_depts($req->input('dirs'), $req->input('query'));
        }

        public function seeDeptById($id) {
            return $this->model->see_depts_by_id($id);
        }

        public function addDepts(Request $req) {
            return $this->model->add_depts(
                $req->input('dirid'),
                $req->input('name'),
                $req->input('code')
            );
        }

        public function updateDepts(Request $req) {
            return $this->model->update_depts(
                $req->input('id'),
                $req->input('dirid'),
                $req->input('name'),
                $req->input('code')
            );
        }

        public function deleteDepts(Request $req) {
            return $this->model->delete_depts(
                $req->input('id')
            );
        }
    }

?>