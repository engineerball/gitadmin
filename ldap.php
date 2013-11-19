<?php
include "config.inc.php";

        $ds=ldap_connect($ldap['server']);
        $r=ldap_bind($ds,$ldap['user'],$ldap['password']);     // this is an "anonymous" bind, typically
    $sr=ldap_search($ds, $ldap['base'],"CN=*");
    $info = ldap_get_entries($ds, $sr);
?>
