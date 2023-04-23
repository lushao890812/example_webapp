/*
** filename: member.js
** description: PHP範例網路應用程式會員資料頁js檔
** author: Brian Tao / brian.tao@informc.com
** modification history:
**** 2017.07.20: created
*/
$(document).ready(function($) {
  /////////////////////////////////////////////////////
  // 將所儲存的 sessionStorage 資料放入頁面中
  /////////////////////////////////////////////////////
  $("#header").html("目前登入者：" + sessionStorage.title + " " + sessionStorage.memName);
  
  
  /////////////////////////////////////////////////////
  // 跟server要個人資料
  /////////////////////////////////////////////////////
  $.ajax({
      type: "POST",
      url: "process-member.php",
      data: {action: "getData", memId: sessionStorage.memId},
      dataType: "json"
  })
  .done(function(data, msg, obj) {
    console.log(data);
    // 如果 _responseCode 不是 0，代表有錯誤
    if (data._responseCode !== "0"){
      // 顯示 _responseString （內容即為該錯誤）
      $("#header").html(data._responseString);
    }else{
      // 資料傳回，填入相關欄位
      $("#memId").val(data._responseValues.memId);
      $("#memName").val(data._responseValues.memName);
      $("#memPwd").val("");
      $("#title").val(data._responseValues.title);
      $("#lastModified").val(data._responseValues.lastModified);
    }
  })
  // 伺服器端正確執行完成發生問題
  .fail(function(obj, msg, err) {
    alert("伺服器程式錯誤");
  })
  // 不管伺服器是否發生問題都要執行
  .always(function() {
    // do nothing
  });
  
  
  /////////////////////////////////////////////////////
  // bind form submit 儲存資料
  /////////////////////////////////////////////////////
  $("#formMember").submit(function(e){
    // 避免網頁預設送出
    e.preventDefault();
    // 改用AJAX呼叫
    $.ajax({
      type: "POST",
      url: "process-member.php",
      data: $(this).serializeArray(),
      dataType: "json"
    })
    // 伺服器端正確執行完成
    .done(function(data, msg, obj) {
      // 將回傳資料寫入console (F12)
      console.log(data);
      // 如果 _responseCode 不是 0，代表有錯誤
      if (data._responseCode !== "0"){
        // 顯示 _responseString （內容即為該錯誤）
        alert(data._responseString);
      }else{
        // 儲存完成
        alert(data._responseString);
        // 重新載入網頁
        location.reload();
      }
    })
    // 伺服器端正確執行完成發生問題
    .fail(function(obj, msg, err) {
      alert("伺服器程式錯誤");
    })
    // 不管伺服器是否發生問題都要執行
    .always(function() {
      // do nothing
    });
  });
  
  
  /////////////////////////////////////////////////////
  // bind loadSalary button 檢視歷史調薪紀錄
  /////////////////////////////////////////////////////
  $("#loadSalary").click(function(e){
    $.ajax({
      type: "POST",
      url: "process-member.php",
      data: {action: "loadSalary", memId: sessionStorage.memId},
      dataType: "html"
    })
    // 伺服器端正確執行完成
    .done(function(data, msg, obj) {
      // 將回傳資料直接放入網頁區塊
      $(".salaryContent").attr("style","display:block;");
      $("#salaryTable").html(data);
    })
    // 伺服器端正確執行完成發生問題
    .fail(function(obj, msg, err) {
      alert("伺服器程式錯誤");
    })
    // 不管伺服器是否發生問題都要執行
    .always(function() {
      // do nothing
    });
  });
  
  /////////////////////////////////////////////////////
  // bind addSalary button 新增調薪紀錄
  /////////////////////////////////////////////////////
  $("#addSalary").click(function(e){
    salary=$('input[name="salary"]').val();
    reason=$('input[name="reason"]').val();
    if(salary!=""){
      if(reason!=""){
        $.ajax({
          type: "POST",
          url: "process-member.php",
          data: {
                  action: "addSalary",
                  memId: sessionStorage.memId,
                  salary:salary,
                  reason:reason
                },
          dataType: "html"
        })
        // 伺服器端正確執行完成
        .done(function(data, msg, obj) {
          // 將回傳資料直接放入網頁區塊
          $('#addSalaryModal').modal('toggle'); 
          alert("新增成功");
          $('input[name="salary"]').val("");
          $('input[name="reason"]').val("");
          $("#salaryTable").html(data);
            
        })
        // 伺服器端正確執行完成發生問題
        .fail(function(obj, msg, err) {
          
          alert("伺服器程式錯誤");
        })
        // 不管伺服器是否發生問題都要執行
        .always(function() {
          // do nothing
        });
      }
      else{
        alert("調整薪資不可為空");
      }
    }
    else{
      alert("調整原因不可為空");
    }
    
  });
  
  /////////////////////////////////////////////////////
  // bind logout button 登出
  /////////////////////////////////////////////////////
  $("#logout").click(function(e){
    sessionStorage.clear();
    location.replace("../login/login.php");
  });

  
  
  

});
