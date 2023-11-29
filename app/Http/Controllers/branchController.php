<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\Branch;

    class branchController extends Controller {
        private $model = '';

        public function __construct() {
            $this->model = new Branch();
        }

        public function seeBranch() {
            return $this->model->see_branch();
        }

        public function seeBranchById($id) {
            return $this->model->see_branch_by_id($id);
        }

        public function searchBranch(Request $req) {
            return $this->model->search_branch($req->input('orgz'), $req->input('query'));
        }

        public function addBranch(Request $req) {
            return $this->model->add_branch(
                $req->input('name'),
                $req->input('orgId'),
                $req->input('code')
            );
        } 

        public function updateBranch(Request $req) {
            return $this->model->update_branch(
                $req->input('id'),
                $req->input('name'),
                $req->input('orgId'),
                $req->input('code')
            );
        }

        public function deleteBranch(Request $req) {
            return $this->model->delete_branch($req->input('id'));
        }
    }

?>