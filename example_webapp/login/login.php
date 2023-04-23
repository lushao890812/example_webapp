<?php
/*
** filename: login.php
** description: 範例PHP網路應用程式登入頁
** author: Brian Tao | brian.tao@informc.com
** modification history:
**** 2017.07.20: created
*/

include_once("../library/config.php");
?>
<html>
<head>
  <title><?php echo $config['sys_title']; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/global.css" />    
</head>
<body>


<div class="loginContent">
<p>測試可用 0001/0001, 0002/0002, 0003/0003, 0004/0004 或 0005/0005</p>
<form name="formLogin" id="formLogin" method="POST">
  <div class="mb-3">
      <label for="memid" class="form-label">帳號</label>
      <input type="text" class="form-control" id="memId" name="memId">
    </div>
    <div class="mb-3">
      <label for="memPwd" class="form-label">密碼</label>
      <input type="password" class="form-control" id="memPwd" name="memPwd">
    </div>
    <div class="loginButton">
      <input type="submit" class="btn btn-primary" value="登入">
    </div>
    
</form>
</div>

<!-- js最適放置為 body tag 結束前 -->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/login.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>