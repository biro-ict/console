<?php 
    namespace App\Http\Controllers\Finance;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Finance\Rekening;

    class rekeningController extends Controller {
        private $model = '';

        public function __construct() {
            $this->model = new Rekening();
        }

        #bank
        public function seeBank(Request $req) {
            return $this->model->show_bank($req->input('cari'));
        }

        #rekening
        public function seeNoRek(Request $req) {
            return $this->model->show_rekening($req->input('DataSource'), $req->input('KodeBank'));
        }

        public function seeNoRekById($id) {
            return $this->model->show_rekening_by_id($id);
        }

        public function addRekening(Request $req) {
            return $this->model->add_rekening(
                $req->input('KodeBank'),
                $req->input('NoRekening'),
                $req->input('MataUang'),
                $req->input('Branch'),
                $req->input('Pemilik'),
                $req->input('MataAnggaran'),
                $req->input('BM_Prefix'),
                $req->input('BK_Prefix'),
                $req->input('TR_Prefix'),
                $req->input('DataSource')
            );
        }

        public function updateRekening(Request $req) {
            return $this->model->edit_rekening(
                $req->input('KodeBank'),
                $req->input('NoRekening'),
                $req->input('MataUang'),
                $req->input('Branch'),
                $req->input('Pemilik'),
                $req->input('MataAnggaran'),
                $req->input('BM_Prefix'),
                $req->input('BK_Prefix'),
                $req->input('TR_Prefix'),
                $req->input('DataSource')
            );
        }

        public function deleteRekening(Request $req) {
            return $this->model->delete_rekening($req->input('NoRekening'));
        }

        #currency
        public function seeCurrency(Request $req) {
            return $this->model->show_currency($req->input('cari'));
        }

        public function seeCurrencyById($id) {
            return $this->model->show_currency_by_id($id);
        }

        public function addCurrency(Request $req) {
            return $this->model->add_currency($req->input('MataUang'), $req->input('NamaMataUang'), $req->input('Negara'));
        }

        public function updateCurrency(Request $req) {
            return $this->model->edit_currency($req->input('MataUang'), $req->input('NamaMataUang'), $req->input('Negara'));
        }

        public function deleteCurrency(Request $req) {
            return $this->model->delete_currency($req->input('currency'));
        }

      

    }
    
?>