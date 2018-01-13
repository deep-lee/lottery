function login(){
    var username = $('#username').val();
    var password = $('#password').val();
    var postData = {};
    postData.username = username;
    postData.password = password;
    $.ajax({
        type:"get",
        contentType : "text/html;charset=utf-8",
        url:"../back/login.php",
        dataType:"json",
        data:postData,
        success:function(data){
          var rt_code = data.rt_code;
          if (rt_code == -1) {
            alert("Something wrong, please contact dev.")
          } else if (rt_code == 0) {
            alert("Something wrong, please contact dev.")
          } else if (rt_code == 2) {
            alert("用户名或密码错误");
          } else {
            location.href="./index.html";
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert(XMLHttpRequest.status);
            alert(XMLHttpRequest.readyState);
            alert(textStatus);
        }
    });
}
