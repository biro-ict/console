<?php 
    namespace App\Http\Controllers\Finance;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Finance\Providers;

    class providersController extends Controller {
        private $model = '';

        public function __construct() {
            $this->model = new Providers();
        }

        public function seeProviders(Request $req) {
            return $this->model->see_providers($req->input('cari'));
        }

        public function seeProvidersById($id) {
            return $this->model->see_providers_by_id($id);
        }

        public function addProvider(Request $req) {
            return $this->model->add_providers(
                $req->input('ProviderID'),
                $req->input('Perusahaan'),
                $req->input('NPWP'),
                $req->input('Alamat_1'),
                $req->input('Alamat_2'),
                $req->input('Alamat_3'),
                $req->input('Telephone'),
                $req->input('Fax'),
                $req->input('Bank_USD'),
                $req->input('Rekening_USD'),
                $req->input('Pemilik_USD'),
                $req->input('Bank_IDR'),
                $req->input('Rekening_IDR'),
                $req->input('Pemilik_IDR'),
                $req->input('MataAnggaran'),
                $req->input('DeptID'),
                $req->input('AreaCode'),
                $req->input('COANonGas'),
                $req->input('DeptNonGas'),
                $req->input('AreaNonGas')
            );
        }

        public function updateProvider(Request $req) {
            return $this->model->update_providers(
                $req->input('ProviderID'),
                $req->input('Perusahaan'),
                $req->input('NPWP'),
                $req->input('Alamat_1'),
                $req->input('Alamat_2'),
                $req->input('Alamat_3'),
                $req->input('Telephone'),
                $req->input('Fax'),
                $req->input('Bank_USD'),
                $req->input('Rekening_USD'),
                $req->input('Pemilik_USD'),
                $req->input('Bank_IDR'),
                $req->input('Rekening_IDR'),
                $req->input('Pemilik_IDR'),
                $req->input('MataAnggaran'),
                $req->input('DeptID'),
                $req->input('AreaCode'),
                $req->input('COANonGas'),
                $req->input('DeptNonGas'),
                $req->input('AreaNonGas')
            );
        }

        public function deleteProvider(Request $req) {
            return $this->model->delete_providers($req->input('ProviderID'));
        }
    }