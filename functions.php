<?php 

require_once 'config.php';

session_start();

function xiu_get_current_user () {
	if (empty($_SESSION['current_login_user'])) {
	  header('Location: ./login.php');
	  exit();
	}else{
		return $_SESSION['current_login_user'];
	}
}

function xiu_fetch_all ($sql) {

	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if (!$conn) {
		exit('连接数据库失败');
	}

	$query = mysqli_query($conn,$sql);
	if(!$query){
		return false;
	}

	while ($row = mysqli_fetch_assoc($query)) {
		$result[] = $row;
	}

	mysqli_free_result($query);
	mysqli_close($conn);

	return $result;
}
function xiu_fetch_one ($sql) {

	$res = xiu_fetch_all($sql);

	return isset($res[0]) ? $res[0] : null;

}

function xiu_execute ($sql) {
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  if (!$conn) {
    exit('连接失败');
  }

  $query = mysqli_query($conn, $sql);
  if (!$query) {
    return false;
  }

  $affected_rows = mysqli_affected_rows($conn);

  mysqli_close($conn);

  return $affected_rows;
}

?>