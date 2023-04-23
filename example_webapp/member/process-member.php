<?php
/*
** filename: process-member.php
** description: 範例PHP網路應用程式會員資料處理頁
** author: Brian Tao | brian.tao@informc.com
** modification history:
**** 2017.07.20: created
*/

include_once("../library/config.php");
include_once("../library/db.php");

// 將POST資料解析至變數內
foreach ($_POST as $key => $val) $$key = trim($val);
irmclog("$action: $memId", $logFile);

// 預設值
$responseValues = array();



// 由 $action 來判斷需要處理的項目
switch ($action){
  // 要會員資料
  case "getData":
    /////////////////////////////////////////////////////
    // 抓資料庫會員資料
    /////////////////////////////////////////////////////
    try{
      $sql = "SELECT * FROM $cfg_db.test_member WHERE memId=?";
      $stmt = $db->prepare($sql);
      $stmt->bindValue(1, $memId);
      $stmt->execute();
    }catch(PDOException $e){
      // 資料查詢錯誤
      irmclog("(SQL ERROR) [" . $e->getCode() . "] " . $e->getMessage(), $logFile);
      irmcwrite($sql . ";", $logFile);
      echo irmc_compose_response("0", $responseValues, "sql-error", "資料庫查詢錯誤，請通知系統管理者");
      exit();
    }
    
    // 若有資料則回傳
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      echo irmc_success_response($row);
    }else{
      echo irmc_compose_response("0", $responseValues, "data-error", "查無成員 $memId");
    }
  break;
  
  
  
  case "saveData":
    /////////////////////////////////////////////////////
    // 存資料庫
    /////////////////////////////////////////////////////
    try{
      if (empty($memPwd)){
        $sql = "UPDATE $cfg_db.test_member SET memName=?, lastModified=NOW() WHERE memId=?";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $memName);
        $stmt->bindValue(2, $memId);
      }else{
        $sql = "UPDATE $cfg_db.test_member SET memName=?, memPwd=?, lastModified=NOW() WHERE memId=?";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $memName);
        $stmt->bindValue(2, $memPwd);
        $stmt->bindValue(3, $memId);
      }
      $stmt->execute();
    }catch(PDOException $e){
      // 資料查詢錯誤
      irmclog("(SQL ERROR) [" . $e->getCode() . "] " . $e->getMessage(), $logFile);
      irmcwrite($sql . ";", $logFile);
      echo irmc_compose_response("0", $responseValues, "sql-error", "資料庫儲存錯誤，請通知系統管理者");
      exit();
    }
    echo irmc_compose_response("0", $responseValues, "0", "儲存完成");
  break;
  
  
  
  case "loadSalary":
    /////////////////////////////////////////////////////
    // 回傳薪資紀錄
    /////////////////////////////////////////////////////
    try{
      $sql = "SELECT * FROM $cfg_db.salary_history WHERE memId=? ORDER BY startDateTime DESC";
      $stmt = $db->prepare($sql);
      $stmt->bindValue(1, $memId);
      $stmt->execute();
    }catch(PDOException $e){
      // 資料查詢錯誤
      irmclog("(SQL ERROR) [" . $e->getCode() . "] " . $e->getMessage(), $logFile);
      irmcwrite($sql . ";", $logFile);
      echo "資料庫查詢錯誤，請通知系統管理者";
      exit();
    }
    
    // 若有資料則回傳
    if ($stmt->rowCount() > 0){
      echo "<h2>薪資紀錄</h2>" . PHP_EOL;
      echo "<div class='salaryTable'>".PHP_EOL;
      echo "<table class='table'>
      <thead>
        <tr>
          <th style='background-color:#FFFFFF'scope='col'>調整時間</th>
          <th style='background-color:#FFFFFF' scope='col'>薪資</th>
          <th style='background-color:#FFFFFF' scope='col'>調整原因</th>
        </tr>
      </thead>
      <tbody>". PHP_EOL;
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo "<tr>
        <td>".$row["startDateTime"];echo"</td>".PHP_EOL;
        echo"  <td>".$row["salary"];echo"</td>".PHP_EOL;
        echo"  <td>".$row["reason"];echo"</td>".PHP_EOL;
        echo"</tr>";
      };
    
      echo"</tbody>
      </table>
      </div>";
      
    }else{
      echo "<h2>查無資料</h2>" . PHP_EOL;
    }
  break;

  case "addSalary":
    if($salary!="" && $reason!=""){
      try{
      
        $sql = "INSERT INTO $cfg_db.salary_history set memId=? ,startDateTime=NOW(),salary=?,reason=?";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $memId);
        $stmt->bindValue(2, $salary);
        $stmt->bindValue(3, $reason);
        $stmt->execute();
        $sql = "SELECT * FROM $cfg_db.salary_history WHERE memId=? ORDER BY startDateTime DESC";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $memId);
        $stmt->execute();
      }catch(PDOException $e){
        
      
      }
      
      if ($stmt->rowCount() > 0){
        echo "<h2>薪資紀錄</h2>" . PHP_EOL;
        echo "<div class='salaryTable'>".PHP_EOL;
        echo "<table class='table'>
        <thead>
          <tr>
            <th style='background-color:#FFFFFF'scope='col'>調整時間</th>
            <th style='background-color:#FFFFFF' scope='col'>薪資</th>
            <th style='background-color:#FFFFFF' scope='col'>調整原因</th>
          </tr>
        </thead>
        <tbody>". PHP_EOL;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          echo "<tr>
          <td>".$row["startDateTime"];echo"</td>".PHP_EOL;
          echo"  <td>".$row["salary"];echo"</td>".PHP_EOL;
          echo"  <td>".$row["reason"];echo"</td>".PHP_EOL;
          echo"</tr>";
        };
      
        echo"</tbody>
        </table>
        </div>";
        
      }else{
        echo "<h2>查無資料</h2>" . PHP_EOL;
      }
    }
    
    break;
  
  
  default:
    echo irmc_compose_response("0", $responseValues, "action-error", "未知的項目「" . $action . "」");
    exit();
}
?>
