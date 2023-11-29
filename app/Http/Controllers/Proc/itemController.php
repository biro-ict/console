<?php 
    namespace App\Http\Controllers\Proc;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Proc\Item;

    class itemController extends Controller {
        private $model='';

        public function __construct() {
            $this->model = new Item();
        }

        public function seeItems(Request $req) {
            return $this->model->see_item(
                $req->input('tipe'),
                $req->input('kategori'),
                $req->input('satuan_po'),
                $req->input('satuan_stock'),
                $req->input('cari')
            );
        }

        public function seeItemById($id) {
            return $this->model->see_item_by_id($id);
        }

        public function addItem(Request $req) {
            return $this->model->add_item(
                $req->input('itemid'),
                $req->input('itemcategory'),
                $req->input('itemtype'),
                $req->input('itemmeasureid_buy'),
                $req->input('itemmeasureid_base'),
                $req->input('itemname'),
                $req->input('usertext'),
                $req->input('updatedby')
            );
        }

        public function updateItem(Request $req) {
            return $this->model->edit_item(
                $req->input('itemid'),
                $req->input('itemcategory'),
                $req->input('itemtype'),
                $req->input('itemmeasureid_buy'),
                $req->input('itemmeasureid_base'),
                $req->input('itemname'),
                $req->input('usertext'),
                $req->input('updatedby')
            );
        }

        public function deleteItems(Request $req) {
            return $this->model->delete_item(
                $req->input('id'),
                $req->input('updatedby')
            );
        }

        public function seeLastId() {
            return $this->model->see_last_id();
        }
    }
?>