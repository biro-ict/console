<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\Licenses;

    class licensesController extends Controller {

        private $model = '';

        public function __construct() {
            $this->model = new Licenses();
        }

        public function seeLicenses() {
            return $this->model->see_licenses();
        }

        public function seeLicensesById($id) {
            return $this->model->see_licenses_by_id($id);
        }

        public function seeLicensesByUser($username) {
            return $this->model->see_licenses_by_username($username);
        }

        public function addLicenses(Request $req) {
            return $this->model->add_licenses(
                $req->input('username'),
                $req->input('winType'),
                $req->input('winSerKey'),
                $req->input('officeType'),
                $req->input('officeSerKey'),
                $req->input('location'),
                $req->input('device')
            );
        }

        public function updateLicenses(Request $req) {
            return $this->model->update_licenses(
                $req->input('id'),
                $req->input('username'),
                $req->input('winType'),
                $req->input('winSerKey'),
                $req->input('officeType'),
                $req->input('officeSerKey'),
                $req->input('location'),
                $req->input('device')
            );
        }

        public function deleteLicenses(Request $req) {
            return $this->model->delete_licenses($req->input('id'));
        }
    }

?>