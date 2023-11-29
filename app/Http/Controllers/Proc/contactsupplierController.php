<?php
    namespace App\Http\Controllers\Proc;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Proc\Contactsupplier;

    class contactsupplierController extends Controller {
        private $model = '';

        public function __construct()
        {
            $this->model = new Contactsupplier();
        }

        public function showContact(Request $req) {
            return $this->model->see_contact_by_supplier($req->input('id'));
        } 

        public function updateContact(Request $req){
            return $this->model->update_contact(
                $req->input('id'),
                $req->input('code'),
                $req->input('name'),
                $req->input('profession'),
                $req->input('email'),
                $req->input('telp'),
                $req->input('nohp'),
                $req->input('updatedby')
            );
        }

        public function deleteContact(Request $req) {
            return $this->model->delete_contact(
                $req->input('id'),
                $req->input('updatedby')
            );
        }

   }