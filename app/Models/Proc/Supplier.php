<?php
    namespace App\Models\Proc;
    use Illuminate\Database\Eloquent\Model;
    use DB;

    class Supplier extends Model {
        function see_supplier() {
            $result = array();
            $get = DB::Connection('sql_eproc')->select("SELECT cardcode, cardname, bpgroupid, address, zipcode, phone1, phone2,mailaddres, fax, notes FROM mbp where deleted=0 ORDER BY cardname DESC");
            if(count($get) > 0) {
                $index = 0;
                foreach($get as $item) {
             
                    $group = $item->bpgroupid;
                    $arr = explode(';', $group);

                    //if wanna filter by bpgroupid
                    // if(in_array(0, $arr)) {
                       
                    // }

                    $params = "(";
                    for($i=0; $i<count($arr); $i++ ) {
                        $value =  $arr[$i] == '' ? 0 : $arr[$i];
                        $value =  $arr[$i] == ' ' ? 0 : $value;
                        if(count($arr) != 1 ) {

                            $params = $params.$value. ', ';
                        }else{

                            $params = $params.$value;
                        }
                    }

                    $params = count($arr) == 1 ? $params.')' : $params."'')";

                    $query =  "SELECT * FROM mbpgroup where bpgroupid IN $params";
                 //   echo ($index+1) .'. '. $query."<br />";
                    $group = DB::Connection('sql_eproc')->select($query);
                    $bpgroup = '';
                    foreach($group as $g) {
                        $bpgroup = $g->bpgroupname.'; '.$bpgroup;
                    }
                   // echo $bpgroup. "<br />";
                    $result[$index] = array(
                        'cardcode' => $item->cardcode,
                        'cardname' => $item->cardname,
                        'groupid' => $bpgroup,
                        'alamat' => $item->address,
                        'kodepos' => $item->zipcode,
                        'phone1' => $item->phone1,
                        'phone2' => $item->phone2,
                        'mailaddres' => $item->mailaddres,
                        'fax' => $item->fax,
                        'notes' => $item->notes
                    );
                    $index++;
                  
                }

               // print_r($result);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengambil data',
                    'title' => 'Berhasil',
                    'data' => $result
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengambil data',
                    'title' => 'Gagal',
                    'data' => ''
                ]);
            }
        }

        function see_supplier_by_group($id) {
            $result = array();
            $get = DB::Connection('sql_eproc')->select("SELECT cardcode, cardname, bpgroupid, address, zipcode, phone1, phone2, mailaddres, fax, notes FROM mbp ORDER BY cardcode DESC");
            if(count($get) > 0) {
                $index = 0;
                foreach($get as $item) {
             
                    $group = $item->bpgroupid;
                    $arr = explode(';', $group);

                    //if wanna filter by bpgroupid
                    if(in_array($id, $arr)) {
                        $params = "(";
                        for($i=0; $i<count($arr); $i++ ) {
                            $value =  $arr[$i] == '' ? 0 : $arr[$i];
                            $value =  $arr[$i] == ' ' ? 0 : $value;
                            if(count($arr) != 1 ) {
    
                                $params = $params.$value. ', ';
                            }else{
    
                                $params = $params.$value;
                            }
                        }
    
                        $params = count($arr) == 1 ? $params.')' : $params."'')";
    
                        $query =  "SELECT * FROM mbpgroup where bpgroupid IN $params";
                     //   echo ($index+1) .'. '. $query."<br />";
                        $group = DB::Connection('sql_eproc')->select($query);
                        $bpgroup = '';
                        foreach($group as $g) {
                            $bpgroup = $g->bpgroupname.'; '.$bpgroup;
                        }
                       // echo $bpgroup. "<br />";
                        $result[$index] = array(
                            'cardcode' => $item->cardcode,
                            'cardname' => $item->cardname,
                            'groupid' => $bpgroup,
                            'alamat' => $item->address,
                            'kodepos' => $item->zipcode,
                            'phone1' => $item->phone1,
                            'phone2' => $item->phone2,
                            'mailaddres' => $item->mailaddres,
                            'fax' => $item->fax,
                            'notes' => $item->notes
                        );
                        $index++;
                    }

                  
                  
                }

               // print_r($result);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengambil data',
                    'title' => 'Berhasil',
                    'data' => $result
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengambil data',
                    'title' => 'Gagal',
                    'data' => ''
                ]);
            }
        }

        function see_supplier_by_id($id) {
            $get = DB::Connection('sql_eproc')->select("SELECT * FROM mbp where cardcode='$id'");
            if(count($get) > 0) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengambil data',
                    'title' => 'Berhasil',
                    'data' => $get
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengambil data',
                    'title' => 'Gagal',
                ]);
            }

        }

        function add_supplier($id, $name, $group, $alamat, $kodepos, $telp, $nohp, $fax, $email, $notes, $updatedby) {
            if(is_array($group)) {
                $groupid ='';
                for($i=0; $i<count($group); $i++) {
                    $groupid = $groupid . $group[$i].";";
                }

            }
            $insert = DB::Connection('sql_eproc')->select("INSERT INTO mbp(cardcode, cardname, cardtype, bpgroupid, address, zipcode, phone1, cellular, fax, mailaddres, notes, updatedby) VALUES('$id', '$name', 'S', '$groupid', '$alamat', '$kodepos', '$telp', '$nohp', '$fax', '$email', '$notes', '$updatedby')");
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menyimpan data',
                'title' => 'Berhasil'
            ]); 
        }

        function update_supplier($id, $name, $group, $alamat, $kodepos, $telp, $nohp, $fax, $email, $notes, $updatedby) {
            if(is_array($group)) {
                $groupid ='';
                for($i=0; $i<count($group); $i++) {
                    $groupid = $groupid . $group[$i].";";
                }
            }

            $update = DB::Connection('sql_eproc')->select("UPDATE mbp SET cardname='$name', bpgroupid='$groupid', address='$alamat', zipcode='$kodepos', phone1='$telp', cellular='$nohp', fax='$fax', mailaddres='$email', notes='$notes',
            updatedby='$updatedby' WHERE cardcode = '$id'");
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengubah data',
                'title' => 'Berhasil'
            ]); 
        }

        function delete_supplier($id, $updatedby) {
            $count = count($id);
            for($i=0; $i<$count; $i++) {
                $delete = DB::Connection('sql_eproc')->select("UPDATE mbp SET deleted = 1, updatedby='$updatedby' WHERE cardcode='$id[$i]'");
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus data',
                'title' => 'Berhasil'
            ]); 
        }

        function see_last_id() {
            $get = DB::Connection('sql_eproc')->select("SELECT MAX(CAST(TRIM(MID(mbp.cardcode,4,LENGTH(mbp.cardcode))) AS SIGNED)) AS nomor FROM  mbp");
            $nilai = (int) $get[0]->nomor;
            $nilai = $nilai + 1;
            $nilai = "SUP".$nilai;
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil mengambil data',
                'data' => $nilai
            ]);
        }
    }
?>