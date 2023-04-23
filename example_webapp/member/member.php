<?php
/*
** filename: member.php
** description: 範例PHP網路應用程式會員資料頁
** author: Brian Tao | brian.tao@informc.com
** modification history:
**** 2017.07.20: created
*/

include_once("../library/config.php");
?>
<html>
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <title><?php echo $config['sys_title']; ?></title>
  <link rel="stylesheet" href="../css/global.css" />    
</head>
<body>
<div class="modal fade" id="addSalaryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form name="formMember"  method="POST">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addSalaryModalLabel">新增調薪紀錄</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form name="formMember" id="formMember" method="POST">
            <div class="mb-3">
              <label for="salaryInput" class="form-label">調整後薪資</label>
              <input type="text" class="form-control" id="salary" name="salary">
            </div>
            <div class="mb-3">
              <label for="reasonInput" class="form-label">調薪原因</label>
              <input type="text" class="form-control" id="reason" name="reason">
            </div>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
          <button type="button" id="addSalary" class="btn btn-success" value="儲存">儲存</button>
        </div>
      </form> 
    </div>
  </div>
</div>
<div class="content">
  <div class="informaiton">
    <h1 id="header">&nbsp;</h1>
    <form name="formMember" id="formMember" method="POST">   
      <div class="mb-3 row">
        <label for="inputPassword" class="col-sm-2 col-form-label">員工編號</label>
        <div class="col-sm-10">
          <fieldset disabled>
            <input type="text" class="form-control"name="memId" id="memId" readOnly>
          </fieldset>
        </div>
      </div>
      <div class="mb-3 row">
        <label for="inputPassword" class="col-sm-2 col-form-label">員工姓名</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" name="memName" id="memName">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="inputPassword" class="col-sm-2 col-form-label">密碼（若需修改密碼再填寫）</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" name="memPwd" id="memPwd">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="inputPassword" class="col-sm-2 col-form-label">職稱</label>
        <div class="col-sm-10">
          <fieldset disabled>
            <input type="text" class="form-control" name="title" id="title" readOnly>
          </fieldset >
        </div>
      </div>
      <div class="mb-3 row">
        <label for="inputPassword" class="col-sm-2 col-form-label">資料更新時間</label>
        <div class="col-sm-10">
          <fieldset disabled>
            <input type="text" class="form-control" name="lastModified" id="lastModified" readOnly>
          </fieldset>
        </div>
      </div>
          

      <div class="ActionGroup">
        <input type="hidden" name="action" value="saveData">
        <input type="submit" value="儲存"  class="btn btn-primary">
        <button type="button" id="loadSalary" value="檢視歷史調薪紀錄" class="btn btn-success">檢視歷史調薪紀錄</button>
        <button type="button" id="addSalaryModal" value="新增調薪紀錄"  class="btn btn-warning"  data-bs-toggle="modal" data-bs-target="#addSalaryModal">新增調薪紀錄</button>
        <button type="button" id="logout" value="登出"  class="btn btn-danger">登出</button>
      </div>
    </form>
    <div id="salaryTable" class="salaryContent"></div>
  </div>
  
 
</div>

<!-- js最適放置為 body tag 結束前 -->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/member.js"></script>
</body>
</html>