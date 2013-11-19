<?php
include "ldap.php";
$groupname = $_REQUEST['GROUPNAME'];
    $sr=ldap_search($ds, "cn=$groupname,ou=REPO,ou=GROUPS,dc=truelife,dc=th" ,"CN=*");
    $info = ldap_get_entries($ds, $sr);
for ($i=0; $i < $info["count"]; $i++) {
    foreach ($info[$i]['member'] as $value){
                echo $value."<br />";
        }
}
?>

