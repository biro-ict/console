<?php 
    namespace App\Http\Controllers\Finance;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Finance\Penerima;

    class penerimaController extends Controller {
        private $model = '';

        public function __construct() {
            $this->model = new Penerima();
        }

        public function seePenerima(Request $req) {
            return $this->model->see_penerima($req->input('cari'));
        }

        public function seePenerimaById($id){
            return $this->model->see_penerima_by_id($id);
        }

        public function addPenerima(Request $req) {
            return $this->model->add_penerima(
                $req->input('penerima'),
                $req->input('Perusahaan'),
                $req->input('isPerson'),
                $req->input('npwp'),
                $req->input('alamat_1'),
                $req->input('alamat_2'),
                $req->input('alamat_3'),
                $req->input('KodeBankIDR'),
                $req->input('NoRek'),
                $req->input('Bank'),
                $req->input('KodeBankUSD'),
                $req->input('NoRekUSD'),
                $req->input('BankUSD'),
                $req->input('mail')
            );
        }

        public function editPenerima(Request $req) {
            return $this->model->edit_penerima(
                $req->input('npwp_id'),
                $req->input('penerima'),
                $req->input('Perusahaan'),
                $req->input('isPerson'),
                $req->input('npwp'),
                $req->input('alamat_1'),
                $req->input('alamat_2'),
                $req->input('alamat_3'),
                $req->input('KodeBankIDR'),
                $req->input('NoRek'),
                $req->input('Bank'),
                $req->input('KodeBankUSD'),
                $req->input('NoRekUSD'),
                $req->input('BankUSD'),
                $req->input('mail')
            );
        }

        public function deletePenerima(Request $req) {
            return $this->model->delete_penerima($req->input('npwp_id'));
        }

  

    }
    
?>