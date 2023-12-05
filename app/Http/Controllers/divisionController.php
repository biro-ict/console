<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\Division;

    class divisionController extends Controller {
        private $model='';

        public function __construct() {
            $this->model = new Division();
        }

        public function seeDivision() {
            return $this->model->see_division();
        }
    }
?>