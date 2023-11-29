<?php
    namespace App\Http\Controllers\Proc;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Proc\Supplier;

    class supplierController extends Controller {
        private $model='';

        public function __construct() {
            $this->model = new Supplier();
        }

        public function seeSupplier() {
            return $this->model->see_supplier();
        }

        public function seeSupplierByGroup($id) {
            return $this->model->see_supplier_by_group($id);
        }

        public function seeSupplierById($id) {
            return $this->model->see_supplier_by_id($id);
        }

        public function addSupplier(Request $req) {
            return $this->model->add_supplier(
                $req->input('id'),
                $req->input('name'),
                $req->input('group'),
                $req->input('alamat'),
                $req->input('kodepos'),
                $req->input('telp'),
                $req->input('nohp'),
                $req->input('fax'),
                $req->input('mail'),
                $req->input('notes'),
                $req->input('updatedby')
            );
        }

          public function updateSupplier(Request $req) {
            return $this->model->update_supplier(
                $req->input('id'),
                $req->input('name'),
                $req->input('group'),
                $req->input('alamat'),
                $req->input('kodepos'),
                $req->input('telp'),
                $req->input('nohp'),
                $req->input('fax'),
                $req->input('mail'),
                $req->input('notes'),
                $req->input('updatedby')
            );
        }

        public function deleteSupplier(Request $req) {
            return $this->model->delete_supplier(
                $req->input('id'),
                $req->input('updatedby')
            );
        }

        public function seeLastId(){
            return $this->model->see_last_id();
        }


    }

?>