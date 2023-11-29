<?php 
    namespace App\Http\Controllers\Users;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Auth\Users as Users;

    class usersController extends Controller {
        private $model = '';

        public function __construct() {
            $this->model = new Users();
        }

        public function dashboardUsers(Request $req) {
            return $this->model->dashboard_user(($req->input('username')));
        }
    }
    
?>