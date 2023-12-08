<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\Employee;

    class employeeController extends Controller{

        private $model = '';

        public function __construct(){
            $this->model = new Employee();
        }

        public function seeEmployee(){
            return $this->model->see_empl();
        }

        public function seeEmplById($id){
            return $this->model->see_empl_by_id($id);
        }

        public function seeEmplByUsrnm($username){
            return $this->model->see_empl_by_user($username);
        }

        public function seeEmplAccess(){ 
            return $this->model->see_empl_access();
        }

        public function searchEmpl(Request $req) {
            return $this->model->search_employee($req->input('branch'), $req->input('depts'), $req->input('query'));
        }

        public function addEmpl(Request $req) {
            return $this->model->add_empl(
                $req->input('fullname'),
                $req->input('username'),
                $req->input('gender'),
                $req->input('level'),
                $req->input('deptId'),
                $req->input('branchid'),
                $req->input('status'),
                $req->input('grade')
            );
        }

        public function updateEmpl(Request $req) {
            return $this->model->update_empl(
                $req->input('id'),
                $req->input('fullname'),
                $req->input('username'),
                $req->input('gender'),
                $req->input('level'),
                $req->input('deptId'),
                $req->input('branchid'),
                $req->input('status'),
                $req->input('grade')
            );
        }

        public function deleteEmpl(Request $req) {
            return $this->model->delete_empl(
                $req->input('id')
            );
        }

        public function account_ldap() {
            
        }



       
    }

?>