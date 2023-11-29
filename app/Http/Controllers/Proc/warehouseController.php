<?php 
    namespace App\Http\Controllers\Proc;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Proc\Warehouse;

    class warehouseController extends Controller {
        private $model = '';

        public function __construct() {
            $this->model = new Warehouse();
        }

        public function seeWarehouse(Request $req) {
            return $this->model->see_warehouse($req->input('cari'));
        }

        public function seeWarehousebyId($id) {
            return $this->model->see_warehouse_by_id($id);
        }

        public function addWarehouse(Request $req) {
            return $this->model->add_warehouse(
                $req->input('id'),
                $req->input('name'),
                $req->input('descr'),
                $req->input('updatedby'),
            );
        }

        public function updateWarehouse(Request $req) {
            return $this->model->edit_warehouse(
                $req->input('id'),
                $req->input('name'),
                $req->input('descr'),
                $req->input('updatedby'),
            );
        }

        public function deleteWarehouse(Request $req) {
            return $this->model->delete_warehouse($req->input('id'), $req->input('updatedby'));
        }

        public function seeLastId() {
            return $this->model->see_lastid();
        }

    }
    
?>