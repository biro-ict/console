<?php 
    namespace App\Http\Controllers\Auth;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Auth\Users as Users;

    class authController extends Controller {
        private $model = '';

        public function __construct() {
            $this->model = new Users();
        }

        public function authUsers(Request $req) {
            $check_ldap = $this->model->auth_ldap($req->username, $req->password);
            //return $checkLDAP;
            return $check_ldap == 'true' ? $this->model->auth_console($req->username) : response()->json([
                'status' => 'error',
                'message' => $check_ldap,
                'title' => 'Login Authentification',
                'data' => ''
            ]);
        }

        public function accessUsers(Request $req) {
            return $this->model->auth_dept($req->input('username'));
        }

        public function detailUsers(Request $req) {
            return $this->model->detail_user(($req->input('username')));
        }

        public function showAppsUser(Request $req) {
            return $this->model->show_user_apps($req->input('username'));
        }

        public function showDefaultApps() {
            return $this->model->show_apps();
        }
    }
    
?>