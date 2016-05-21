<?
include ("db_KDlog.inc");
ini_set('display_errors',1);
error_reporting(E_ALL);
header('Content-type: application/json');

// get the POST variable
$info = $_POST ["info"];

// extract all the properties of the request
if (isset ( $info ['call'] )) {
	$call = $info ['call'];
	if (strtolower($call) == "*all*")
	{
		$result = mysql_query("select `call`,`band`,`freq`,`mode`,`qso_date`,`time_on`, `wwff_ref` from log order by `qso_date` desc ,`time_on` desc ") or die('Error: ' . mysql_error());
	}
	else if(substr( $call, 0, 1 ) == "*")
	{
		$call = substr( $call, 1, strlen($call)-1);
		$result = mysql_query("select `call`,`band`,`freq`,`mode`,`qso_date`,`time_on`, `wwff_ref` from log where `call` = '$call' order by `qso_date` desc ,`time_on` desc ") or die('Error: ' . mysql_error());
	}
	else
	{
		$result = mysql_query("select `call`,`band`,`freq`,`mode`,`qso_date`,`time_on`, `wwff_ref` from log where `call` = '$call' order by `qso_date` desc ,`time_on` desc ") or die('Error: ' . mysql_error());
		mysql_query("insert into audit (`call`) values ('$call')");
	}
} 
else 
{
	$result = '';
}
while($obj = mysql_fetch_object($result)) {
$res[] = $obj;
}
echo json_encode($res);
?>

