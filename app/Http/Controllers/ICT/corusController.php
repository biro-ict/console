<?php
    namespace App\Http\Controllers\ICT;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\ICT\Corus;

    class corusController extends Controller {
        private $model = '';

        public function __construct() { $this->model = new Corus(); }
        public function seeConfigurasi() {return $this->model->see_configurasi();}
        public function seeCustomer() {return $this->model->see_customer();}
        public function seeOldNumber($id) {return $this->model->see_old_number($id);}
        public function updateCorus(Request $req) {return $this->model->update_corus($req->input('username'), $req->input('customer'), $req->input('old_sn'), $req->input('new_sn'));}
        public function checkCorus(){ return $this->model->checkDuplicate();}

    }
?>