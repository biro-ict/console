<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\Application;

    class applicationController extends Controller {

        private $model = '';

        public function __construct() {
            $this->model = new Application();
        }

        public function seeApps() {
            return $this->model->see_apps();
        }

        public function seeDetailsApps() {
            return $this->model->see_details_apps();
        }

        public function seeAppsById($id) {
            return $this->model->see_apps_by_id($id);
        }

        public function seeAppsAccess() {
            return $this->model->see_apps_access();
        }

        public function seeUserByApps(Request $req) {
            return $this->model->see_user_by_apps($req->input('id'), $req->input('func'));
        }

        public function addApps(Request $req) {
            return $this->model->add_apps(
                $req->input('appsName'),
                $req->input('appsURL'),
                $req->input('appsUriFE'),
                $req->input('appsUriBE'),
                $req->input('appsDBHost'),
                $req->input('appsDBName'),
                $req->input('needLogin'),
                $req->input('status')
            );
        }

        public function updateApps(Request $req) {
            return $this->model->update_apps(
                $req->input('id'),
                $req->input('appsName'),
                $req->input('appsURL'),
                $req->input('appsUriFE'),
                $req->input('appsUriBE'),
                $req->input('appsDBHost'),
                $req->input('appsDBName'),
                $req->input('needLogin'),
                $req->input('status')
            );
        }

        public function deleteApps(Request $req) {
            return $this->model->delete_apps($req->input('id'));
        }

        public function seeStatusApps() {
            return $this->model->see_status_apps();
        }

        public function seeStatusAppsById($id) {
            return $this->model->see_status_apps_by_id($id);
        }

        public function addStatusApps(Request $req) {
            return $this->model->add_status_apps(
                $req->input('name'),
                $req->input('code')
            );
        }

        public function updateStatusApps(Request $req) {
            return $this->model->update_status_apps(
                $req->input('id'),
                $req->input('name'),
                $req->input('code')
            );
        }

        public function deleteStatusApps(Request $req) {
            return $this->model->delete_status_apps(
                $req->input('id')
            );
        }

        public function seeLoginLevel() {
            return $this->model->see_login_level();
        }

        public function addAccessApp(Request $req) {
            return $this->model->add_access_apps($req->input('userid'), $req->input('appsid'));
        }

        public function delAccessApp(Request $req) {
            return $this->model->delete_access_apps($req->input('userid'), $req->input('appsid'));
        }
    }
?>