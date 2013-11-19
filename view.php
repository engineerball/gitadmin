<?php
include "ldap.php";
include "query.js";
#ldapconnect();
    echo "Location: ou=REPO,ou=GROUPS,dc=truelife,dc=th</ br>";
?>
<form name="form1" method="post" action="submit.php">
    <label>Enter project name : </label>
    <input name="SVNNAME" type="text" size="20" /><br />
    <label>Select group : </label>
    <select size="1" name="GROUPNAME" onchange="changeContent(this.value)">
    <?php    for ($i=0; $i<$info["count"]; $i++) {?>
        <option value="<?php echo $info[$i]['cn'][0] ?>"><?php echo $info[$i]['cn'][0] ?> </option>
    <?php    }?>
    </select><br />
    <label>Requestor E-mail : </label>
    <input name="REQUESTOR" type="text" size="60" /><br />
    <input type="submit" value="Submit" />
</form>

<h2>Member list:</h2>
<div id="content">(Empty)</div>

<?php
        ldap_close($ds);

$chandle = mysql_connect($mysql['host'], $mysql['user'], $mysql['password']) or die("Connection Failure to Database");
mysql_select_db($mysql['dbname'], $chandle) or die ($mysql['dbname'] . " Database not found. " . $mysql['user']);

$query1="SELECT *
FROM `git`
ORDER BY `git`.`id` ASC ";
$result = mysql_db_query($mysql['dbname'], $query1) or die("Failed Query of " . $query1);
echo "<table><tr><td>No.</td><td>Project</td><td>On AD Group name</td><td>Create Date</td><td>Requestor</td></tr>";
while($thisrow=mysql_fetch_row($result))
{
  $i=0;
  echo "<tr>";
  while ($i < mysql_num_fields($result))
  {
    $field_name=mysql_fetch_field($result, $i);
    echo "<td>" . $thisrow[$i] . "</td>";
    $i++;
  }
echo "</tr>";
}
echo "</table>";
?>
