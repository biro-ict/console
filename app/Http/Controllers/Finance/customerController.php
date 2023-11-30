<?php 
    namespace App\Http\Controllers\Finance;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Finance\Customer;

    class customerController extends Controller {
        private $model='';

        public function __construct() { $this->model = new Customer();}
        public function seeCustomer(Request $req) { return $this->model->see_customers($req->input('cari'));}
    }

?>