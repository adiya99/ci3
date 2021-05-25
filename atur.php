<?php
$sqlpk=$this->db->query("select column_name as pk,column_key,data_type,extra from information_schema.columns where table_name='$tabel' && table_schema='$database' and column_key='PRI'");
  $rowpk=$sqlpk->row();
  @$view['pk']=$rowpk->pk;
  $where="";
  $select="select *";
  $from=" from $tabel";
  $jointb="";
  $gporder=""; 
 
  $sqlir=$this->db->query("select TABLE_NAME as tb,COLUMN_NAME as cn from information_schema.columns where table_schema='$database' and column_key='PRI' and COLUMN_NAME in(select column_name from information_schema.columns where table_schema='$database' and COLUMN_KEY='Mul' and TABLE_NAME='$tabel') ");

        $tfk2=array();          
        $tname2=array();          
        foreach ($sqlir->result_object() as $rowir) {
        $tname=$rowir->tb;
        $cname=$rowir->cn;
        $onj=$tabel.".".$cname."=".$tname.".".$cname;
        array_push($tfk2,$onj);
        array_push($tname2,$tname);

        }
        $join=implode(" join ", $tname2);
        $on=implode(" and ", $tfk2);
        if(empty($tname2)){}else{

        $select="select *,$rowpk->pk as cetak_detail";
        $from=" from $tabel";
        $jointb=" join $join on $on";
        }
?>
