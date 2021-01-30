<?php
date_default_timezone_set("Asia/Bangkok");
//convert format tanggal datepicker k datetime > simpan ke DB
function TglWaktu1($tgl) {
    $date = str_replace('/', '-', $tgl );
    $newDate = date("Y-m-d" , strtotime($date))." ".date("H:i:s");
    return $newDate;
}
//change format datetime dari DB Y-m-d > d-m-Y
function DateView1($tgl) {
    $date = str_replace('/', '-', $tgl );
    $newDate = date("d-m-Y" , strtotime($date));
    return $newDate;
}
//change format datetime dari DB Y-m-d > d-m-y
function DateView2($tgl) {
    $date = str_replace('/', '-', $tgl );
    $newDate = date("d/m/y" , strtotime($date));
    return $newDate;
}
//change format datetime dari DB Y-m-d > d-m-y
function DateView3($tgl) {
    $date = str_replace('/', '-', $tgl );
    $newDate = date("d/m/Y H:i:s" , strtotime($date));
    return $newDate;
}
//fungsi format rupiah view
function rupiah($angka){	
    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
    return $hasil_rupiah;

}
function TglPicker($tgl) {
    $date = str_replace('/', '-', $tgl );
    $newDate = date("Y-m-d" , strtotime($date));
    return $newDate;
}
function filter_by_value ($array, $index, $value){
    if(is_array($array) && count($array)>0) 
    {
        foreach(array_keys($array) as $key){
            $temp[$key] = $array[$key][$index];

            if ($temp[$key] == $value){
                $newarray[$key] = $array[$key];
            }
        }
      }
  return $newarray;
}

//fungsi simpan history
    function inserthistory($desc, $idkey, $tableref, $user){
        $ci =& get_instance();
        $param = array(
            'tgl' => date("Y-m-d H:i:s"),
            'user' => $user,
            'deskripsi' => $desc,
            'idkey' => $idkey,
            'tableref' => $tableref
        );
        $ci->db->insert('history_akses', $param);
        $save = $ci->db->affected_rows();
        if($save > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

