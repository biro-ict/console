<?php
    namespace App\Http\Controllers\Proc;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Proc\Itemtype;

    class itemtypeController extends Controller {
        private $model='';

        public function __construct() {
            $this->model = new Itemtype();
        }
        
        public function seeItemtype(Request $req) {
            return $this->model->see_itemtype($req->input('cari'));
        }

        public function seeItemtypeById($id) {
            return $this->model->see_itemtype_by_id($id);
        }

        public function addItemtype(Request $req) {
            return $this->model->add_itemtype(
                $req->input('id'), 
                $req->input('name'),
                $req->input('descr'),
                $req->input('updatedby')
            );
        }

        public function updateItemType(Request $req) {
            return $this->model->edit_itemtype(
                $req->input('id'), 
                $req->input('name'),
                $req->input('descr'),
                $req->input('updatedby')
            );
        }

        public function deleteItemType(Request $req) {
            return $this->model->delete_itemtype(
                $req->input('id'),
                $req->input('updatedby')
            );
        }

        public function seeLastId(){
            return $this->model->see_last_id();
        }


    }

?>