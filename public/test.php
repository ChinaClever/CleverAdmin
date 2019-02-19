<?php
/**
 * Created by PhpStorm.
 * User: luozhiyong
 * Date: 2019/1/16
 * Time: 15:50
 */


echo 'aaaaaaaaaaa';

$a =  snmpwalkoid("192.168.1.192", "public", "");

for ($i=0; $i<count($a); $i++) {
    echo $a[$i]."<br>\n";
}