<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\Directory;

    class directoryController extends Controller {
        private $model = '';

        public function  __construct() {
            $this->model = new Directory();
        }

        public function seeDirectory() {
            return $this->model->see_dirs();
        }

        public function seeDirById($id) {
            return $this->model->see_dir_by_id($id);
        }

        public function searchDir(Request $req) {
            return $this->model->search_dir($req->input('orgz'), $req->input('query'));
        }

        public function addDir(Request $req) {
            return $this->model->add_dir(
                $req->input('name'),
                $req->input('orgId'),
                $req->input('code')
            );
        }

        public function updateDir(Request $req) {
            return $this->model->update_dir(
                $req->input('id'),
                $req->input('name'),
                $req->input('orgId'),
                $req->input('code')
            );
        }

        public function deleteDir(Request $req) {
            return $this->model->delete_dir($req->input('id'));
        }

    }

?>