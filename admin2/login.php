<?php 
// echo phpinfo();

require_once '../config.php';

session_start();

function login(){
  if(empty($_POST['email'])){
    $GLOBALS['message']='请填写邮箱';
    return;
  }
  if(empty($_POST['password'])){
    $GLOBALS['message']='请填写密码';
    return;
  }
  $email=$_POST['email'];
  $password=$_POST['password'];


  $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  // var_dump($connection);

  if (!$connection) {
    exit('<h1>连接数据库失败</h1>');
  }

  $query = mysqli_query($connection,"select * from users where email = '{$email}' limit 1;");

  if (!$query) {
    $GLOBALS['message'] = '登录失败，请重试！';
    return;
  }

  $user = mysqli_fetch_assoc($query);

  if(!$user){
    $GLOBALS['message'] = '邮箱不存在';
    return;
  }
  if($user['password'] != $password){
    $GLOBALS['message'] = '邮箱与密码不匹配';
    return;
  }

  
  $_SESSION['current_login_user'] = $user;

  header('Location: /admin2/index1.php');


}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

  login();
}
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'logout'){
  unset($_SESSION['current_login_user']);
}

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" novalidate autocomplete="off">
      <img class="avatar" src="/static/assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <?php if(isset($message)): ?>
      <div class="alert alert-danger">
        <strong>错误！</strong> <?php echo $message; ?>
      </div>
      <?php endif ?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" name="email" type="email" class="form-control" placeholder="邮箱" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" name="password" type="password" class="form-control" placeholder="密码">
      </div>
      <button class="btn btn-primary btn-block" >登6 录</button>
    </form>
  </div>
</body>
</html>
