<?php 
    namespace App\Http\Controllers\Finance;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Finance\Datasource;

    class datasourceController extends Controller {
        private $model = '';

        public function __construct() {
            $this->model = new Datasource();
        }

        public function seeDataSource(Request $req) {
            return $this->model->see_datasource($req->input('cari'));
        }

        public function seeDataSourceById($id) {
            return $this->model->see_datasource_detil($id);
        } 

        public function addDataSource(Request $req) {
            return $this->model->add_dataSource(
                $req->input('datasource'),
                $req->input('datasourcename'),
                $req->input('datasourcedescr'),
                $req->input('approved')
            );
        }

        public function updateDataSource(Request $req) {
            return $this->model->updateData(
                $req->input('datasource'),
                $req->input('datasourcename'),
                $req->input('datasourcedescr'),
                $req->input('approved')
            );
        }

        public function deleteDataSource(Request $req) {
            return $this->model->delDataSource($req->input('datasource'));
        }


    }
    
?>