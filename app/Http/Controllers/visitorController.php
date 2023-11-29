<?php 
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\Visitor;

    class visitorController extends Controller {

        private $model = '';

        public function __construct()
        {
            $this->model = new Visitor();
        }

        public function seeVisitor(Request $req) {
            return $this->model->see_visitor($req->input('query'));
        }

        public function seeVisitorById($id) {
            return $this->model->see_visitor_by_id($id);
        }

        public function addVisitor(Request $req) {
            return $this->model->add_visitor($req->input('username'), $req->input('area'));
        }

        public function updateVisitor(Request $req) {
            return $this->model->update_visitor($req->input('id'), $req->input('username'), $req->input('area'));
        }


       public function delVisitor(Request $req) {
            return $this->model->delete_visitor($req->input('id'));
       }
    }

?>