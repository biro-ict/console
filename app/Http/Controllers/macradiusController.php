<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\Macradius;
    
    class macradiusController extends Controller {

        private $model = '';

        public function  __construct() {
            $this->model = new Macradius();
        }

        public function searchMacaddr(Request $req) {
            return $this->model->search_mac($req->input('query'));
        }

        public function seeMacaddrById($mac) {
            return $this->model->see_by_id($mac);
        }

        public function addMacaddr(Request $req) {
            return $this->model->add_macradius($req->input('mac'), $req->input('desc'), $req->input('ipaddr'));
        }

        public function updateMacaddr(Request $req) {
            return $this->model->update_macradius($req->input('mac'), $req->input('desc'), $req->input('ipaddr'));
        }

        public function deleteMacaddr(Request $req) {
            return $this->model->delete_macradius($req->input('mac'));
        }
    }

?>