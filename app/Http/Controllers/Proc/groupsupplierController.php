<?php
    namespace App\Http\Controllers\Proc;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Proc\Groupsupplier;

    class groupsupplierController extends Controller {
        private $model='';

        public function __construct() {
            $this->model = new Groupsupplier();
        }
        
        public function seeGroupsupplier(Request $req) {
            return $this->model->see_group($req->input('cari'));
        }

        public function seeGroupsupplierById($id) {
            return $this->model->see_group_by_id($id);
        }

        public function addGroupsupplier(Request $req) {
            return $this->model->add_group(
                $req->input('id'), 
                $req->input('name'),
                $req->input('descr'),
                $req->input('updatedby')
            );
        }

        public function updateGroupsupplier(Request $req) {
            return $this->model->edit_group(
                $req->input('id'), 
                $req->input('name'),
                $req->input('descr'),
                $req->input('updatedby')
            );
        }

        public function deleteGroupsupplier(Request $req) {
            return $this->model->delete_group(
                $req->input('id'),
                $req->input('updatedby')
            );
        }

        public function seeLastId(){
            return $this->model->see_last_id();
        }


    }

?>