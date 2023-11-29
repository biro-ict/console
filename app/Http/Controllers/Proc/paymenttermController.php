<?php
        namespace App\Http\Controllers\Proc;
        use App\Http\Controllers\Controller;
        use Illuminate\Http\Request;
        use App\Models\Proc\Paymentterm;

        class paymenttermController extends Controller {
            private $model='';
            public function __construct() {
                $this->model = new Paymentterm();
            }

            public function seePaymentterm(Request $req) {
                return $this->model->see_paymentterm($req->input('cari'));
            }

            public function seePaymenttermById($id) {
                return $this->model->see_paymentterm_by_id($id);
            }

            public function addPaymentterm(Request $req) {
                return $this->model->add_paymentterm(
                    $req->input('id'),
                    $req->input('name'),
                    $req->input('descr'),
                    $req->input('updatedby')
                );
            }

            public function updatePaymentterm(Request $req) {
                return $this->model->edit_paymentterm(
                    $req->input('id'),
                    $req->input('name'),
                    $req->input('descr'),
                    $req->input('updatedby')
                );
            }

            public function deletePaymentterm(Request $req) {
                return $this->model->delete_payment(
                    $req->input('id'),
                    $req->input('updatedby')
                );
            }

            public function seeLastId() {
                return $this->model->see_last_id();
            }
        }

?>