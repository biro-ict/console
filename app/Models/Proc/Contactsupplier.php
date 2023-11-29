<?php
    namespace App\Models\Proc;
    use Illuminate\Database\Eloquent\Model;
    use DB;

    class Contactsupplier extends Model {

        function see_contact_by_supplier($id) {
            $get = DB::Connection('sql_eproc')->select("SELECT * FROM mbpcontact where cardcode = '$id' and deleted=0 ORDER BY contactname ASC");
            if(count($get) > 0) {
                return response()->json([
                    'status' => 'success',
                    'title' => 'Berhasil',
                    'message' => 'Berhasil mengambil data kontak',
                    'data'  => $get
                ]);
            }else {
                return response()->json([
                    'status' => 'error',
                    'title' => 'Gagal',
                    'message' => 'Data kontak masih kosong',
                ]);
            }
        }

        function update_contact($contactcode, $cardcode, $contactname, $profession, $email, $telp, $nohp, $updatedby) {
            $jumlah = count($contactcode);

            for($i=0; $i<$jumlah; $i++) {
                //check: if exists update else create new
                $get = DB::Connection('sql_eproc')->select("SELECT * FROM mbpcontact where contactcode = '$contactcode[$i]'");
                if(count($get) > 0) {
                    $update = DB::Connection('sql_eproc')->select("UPDATE mbpcontact SET cardcode='$cardcode', contactname='$contactname[$i]', profession='$profession[$i]', mailaddress='$email[$i]', phone1='$telp[$i]', cellular='$nohp[$i]', updatedby='$updatedby' WHERE contactcode = $contactcode[$i]");
                }else {
                    $insert =  DB::Connection('sql_eproc')->select("INSERT INTO mbpcontact(cardcode, contactname, profession, mailaddress, phone1, cellular, updatedby) VALUES('$cardcode', '$contactname[$i]', '$profession[$i]', '$email[$i]', '$telp[$i]', '$nohp[$i]', '$updatedby')");
                }
            }

            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil mengubah data kontak',
                'total' => $jumlah
            ]);
        }

        function delete_contact($id, $updatedby) {
            $jumlah = count($id);
            for($i=0; $i<$jumlah; $i++) {
                $delete = DB::Connection('sql_eproc')->select("UPDATE mbpcontact SET deleted=1, updatedby='$updatedby' WHERE contactcode=$id[$i]");
            }

            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil menghapus data kontak',
            ]);
        }

        
    }
?>