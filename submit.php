<?php
include "config.php";
    $SVNNAME = $_POST['SVNNAME'];
    $GROUP = $_POST['GROUPNAME'];
    $REQUESTOR = $_POST['REQUESTOR'];
    $out = "/tmp/ball.out";
    $err = "/tmp/ball.err";
    if ( $SVNNAME != "" &&  $GROUP != "" ){
$descriptorspec = array(
   0 => array("pipe", "r"),  // stdin
   1 => array("pipe", "w"),  // stdout
   2 => array("pipe", "w"),  // stderr
);
$process = proc_open("/bin/bash -x /var/scripts/gitcreate.sh $SVNNAME $GROUP", $descriptorspec, $pipes, dirname(__FILE__), null);
$stdout = stream_get_contents($pipes[1]);
fclose($pipes[1]);

$stderr = stream_get_contents($pipes[2]);
fclose($pipes[2]);

echo "stdout : \n";
var_dump($stdout);

echo "stderr :\n";
var_dump($stderr);

#        $cmd = exec("/bin/bash -x /var/scripts/gitcreate.sh $SVNNAME $GROUP 2>&1", $out, $err);
		$link = mysql_connect('10.1.21.113', 'gitapp', 'g1tg1t');
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db("gitdb", $link);
		$sql = "INSERT INTO git (`Name`, `Group`, `CreateDate`, `Requestor`) VALUES ('$SVNNAME', '$GROUP','". date("Y-m-d H:i:s")."','$REQUESTOR')";
		if (!mysql_query($sql,$link))
		{
		  die('Error: ' . mysql_error());
		}
		mysql_close($link);

		echo "Create <b>$SVNNAME</b> for group <b>$GROUP</b> on AD done!!!";
		echo "<br />";
		echo "URL : <a href=\"http://git02.truelife.th/$SVNNAME.git\">http://git02.truelife.th/$SVNNAME.git</a>";
    }else{
	echo "NULL!!";
    }
?>
