<?php 
    namespace App\Http\Controllers\Proc;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Proc\Itemmeasure;

    class itemmeasureController extends Controller {
        private $model = '';

        public function __construct() {
            $this->model = new Itemmeasure();
        }

        public function seeItemmeasure(Request $req) {
            return $this->model->see_itemmeasure($req->input('cari'));
        }

        public function seeItemmeasureById($id) {
            return $this->model->see_itemmeasure_by_id($id);
        }

        public function addItemmeasure(Request $req) {
            return $this->model->add_itemmeasure(
                $req->input('id'),
                $req->input('name'),
                $req->input('descr'),
                $req->input('updatedby'),
            );
        }

        public function updateItemmeasure(Request $req) {
            return $this->model->edit_itemmeasure(
                $req->input('id'),
                $req->input('name'),
                $req->input('descr'),
                $req->input('updatedby'),
            );
        }

        public function deleteItemmeasure(Request $req) {
            return $this->model->delete_itemmeasure($req->input('id'), $req->input('updatedby'));
        }

        public function seeLastId() {
            return $this->model->see_lastid();
        }

    }
    
?>