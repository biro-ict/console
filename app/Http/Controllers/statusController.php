<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\Status;

    class statusController extends Controller {
        private $model='';

        public function __construct(){
            $this->model = new Status();
        }

        public function seeStatus() {
            return $this->model->see_status();
        }

        public function seeById($id) {
            return $this->model->see_by_id($id);
        }

        public function searchStatus(Request $req) {
            return $this->model->search_status($req->input('search'));
        }

        public function addStatus(Request $req) {
            return $this->model->add_status($req->input('name'), $req->input('code'));
        }

        public function updateStatus(Request $req) {
            return $this->model->update_status(
                $req->input('id'), 
                $req->input('name'), 
                $req->input('code'));
        }

        public function deleteStatus(Request $req) {
            return $this->model->delete_status($req->input('id'));
        }
    }
?>