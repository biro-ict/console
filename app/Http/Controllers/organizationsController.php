<?php 
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\Organizations;

    class organizationsController extends Controller {

        private $model = '';

        public function __construct()
        {
            $this->model = new Organizations();
        }

        public function seeOrgz() {
            return $this->model->see_orgz();
        }

        public function seeOrgzById($id) {
            return $this->model->see_orgz_by_id($id);
        }

        public function searchOrgz(Request $req) {
            return $this->model->search_orgz($req->input('query'));
        }

        public function addOrgz(Request $req) {
            return $this->model->add_orgz($req->input('name'), $req->input('code'), $req->input('address_one'), $req->input('address_two'), $req->input('telp'));
        }

        public function updateOrgz(Request $req) {
            return $this->model->update_orgz(
                $req->input('id'),
                $req->input('name'), $req->input('code'), $req->input('address_one'), $req->input('address_two'), $req->input('telp')
            );
        }

        public function deleteOrgz(Request $req) {
            return $this->model->delete_orgz($req->input('id'));
        }
    }

?>