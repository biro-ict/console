<?php
    namespace App\Http\Controllers\Proc;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Proc\Itemcategory;

    class itemcategoryController extends Controller {
        private $model='';

        public function __construct() {
            $this->model = new Itemcategory();
        }
        
        public function seeItemCategory(Request $req) {
            return $this->model->see_itemcategory($req->input('cari'));
        }

        public function seeItemCategoryById($id) {
            return $this->model->see_itemcategory_by_id($id);
        }

        public function addItemCategory(Request $req) {
            return $this->model->add_itemcategory(
                $req->input('id'), 
                $req->input('name'),
                $req->input('descr'),
                $req->input('updatedby')
            );
        }

        public function updateItemCategory(Request $req) {
            return $this->model->edit_itemcategory(
                $req->input('id'), 
                $req->input('name'),
                $req->input('descr'),
                $req->input('updatedby')
            );
        }

        public function deleteItemCategory(Request $req) {
            return $this->model->delete_itemcategory(
                $req->input('id'),
                $req->input('updatedby')
            );
        }

        public function seeLastId(){
            return $this->model->see_last_id();
        }


    }

?>