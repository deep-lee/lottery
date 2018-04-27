var search_type = 0;

$(function () {

  //1.初始化Table
  var oTable = new TableInit();
  oTable.Init();

  //2.初始化Button的点击事件
  var oButtonInit = new ButtonInit();
  oButtonInit.Init();

});

function search() {
  $('#tb_departments').bootstrapTable('refresh');
}

function selectOnchang(obj) {
  //获取被选中的option标签选项 
  search_type = obj.selectedIndex;
  console.log(search_type);
}

function change_password() {
  if ($("#txt_new_password").val() == null) {
    alert("密码不能为空");
  } else {

    var requestData = {
      "newpass": $("#txt_new_password").val(),
    };

    $.ajax({
      type: "get",
      contentType: "text/html;charset=utf-8",
      url: "./back/change_password.php",
      data: requestData,
      dataType: "json",
      success: function (data) {
        console.log(data);
        var rt_code = data.rt_code;
        if (rt_code == -1) {
          alert("Something wrong, please contact dev.")
        } else if (rt_code == 0) {
          alert("Something wrong, please contact dev.")
        } else if (rt_code == -2) {
          location.href = "./login.html";
        } else if (rt_code == 1) {
          alert("密码修改成功");
          location.href = "./login.html";
        }
      },
      error: function () {
        toastr.error('Error');
      },
      complete: function () {
      }
    });
  }
}

function clear_cache() {

  var requestData = {
    "appids": $("#txt_cache_appid").val(),
  };

  $.ajax({
    type: "get",
    contentType: "text/html;charset=utf-8",
    url: "./back/clear_cache.php",
    data: requestData,
    dataType: "json",
    success: function (data) {
      console.log(data);
      var rt_code = data.rt_code;
      if (rt_code == -1) {
        alert("Something wrong, please contact dev.")
      } else if (rt_code == 0) {
        alert("Something wrong, please contact dev.")
      } else if (rt_code == -2) {
        location.href = "./login.html";
      } else if (rt_code == 1) {
        alert("缓存清理成功");
      }
    },
    error: function () {
      toastr.error('Error');
    },
    complete: function () {
    }
  });
}

function set_show_urls() {
  console.log($("#txt_set_show_appids").val());
  console.log($("#txt_set_show_url").val());
  if ($("#txt_set_show_appids").val() == '') {
    alert("AppID不能为空");
  } else {
    var requestData = {
      "appids": $("#txt_set_show_appids").val(),
      "show_url": $("#txt_set_show_url").val(),
    };

    $.ajax({
      type: "get",
      contentType: "text/html;charset=utf-8",
      url: "./back/set_appids_url.php",
      data: requestData,
      dataType: "json",
      success: function (data) {
        console.log(data);
        var rt_code = data.rt_code;
        if (rt_code == -1) {
          alert("Something wrong, please contact dev.")
        } else if (rt_code == 0) {
          alert("Something wrong, please contact dev.")
        } else if (rt_code == -2) {
          location.href = "./login.html";
        } else if (rt_code == 1) {
          alert("设置跳转网址成功");
          $('#tb_departments').bootstrapTable('refresh');
        }
      },
      error: function () {
        toastr.error('Error');
      },
      complete: function () {
      }
    });
  }
}

function set_not_show() {
  console.log($("#txt_set_not_show_appids").val());
  if ($("#txt_set_not_show_appids").val() == '') {
    alert("AppID不能为空");
  } else {
    var requestData = {
      "appids": $("#txt_set_not_show_appids").val(),
    };

    $.ajax({
      type: "get",
      contentType: "text/html;charset=utf-8",
      url: "./back/set_appids_not_show.php",
      data: requestData,
      dataType: "json",
      success: function (data) {
        console.log(data);
        var rt_code = data.rt_code;
        if (rt_code == -1) {
          alert("Something wrong, please contact dev.")
        } else if (rt_code == 0) {
          alert("Something wrong, please contact dev.")
        } else if (rt_code == -2) {
          location.href = "./login.html";
        } else if (rt_code == 1) {
          alert("设置不跳转成功");
          $('#tb_departments').bootstrapTable('refresh');
        }
      },
      error: function () {
        toastr.error('Error');
      },
      complete: function () {
      }
    });
  }
}

function logout() {
  $.ajax({
    type: "get",
    contentType: "text/html;charset=utf-8",
    url: "./back/logout.php",
    dataType: "json",
    success: function (data) {
      console.log(data);
      var rt_code = data.rt_code;
      if (rt_code == 1) {
        location.href = "./login.html";
      }
    },
    error: function () {
      toastr.error('Error');
    },
    complete: function () {
    }
  });
}

var responseHandler = function (data) {
  console.log(data);
  if (data.rt_code == 1) {
    data.rt_data.rows = data.rt_data.rows || [];
    return data.rt_data;
  } else {
    location.href = "./login.html";
  }
};

var TableInit = function () {
  var oTableInit = new Object();
  //初始化Table
  oTableInit.Init = function () {
    $('#tb_departments').bootstrapTable({
      url: './back/get_app_data.php',    //请求后台的URL（*）
      method: 'get',                      //请求方式（*）
      toolbar: '#toolbar',                //工具按钮用哪个容器
      striped: true,                      //是否显示行间隔色
      cache: false,                       //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）
      pagination: true,                   //是否显示分页（*）
      sortable: false,                    //是否启用排序
      sortOrder: "asc",                   //排序方式
      queryParams: oTableInit.queryParams,//传递参数（*）
      sidePagination: "server",           //分页方式：client客户端分页，server服务端分页（*）
      pageNumber: 1,                       //初始化加载第一页，默认第一页
      pageSize: 100,                       //每页的记录行数（*）
      pageList: [10, 25, 50, 100],        //可供选择的每页的行数（*）
      // search: true,                    //是否显示表格搜索，此搜索是客户端搜索，不会进服务端，所以，个人感觉意义不大
      strictSearch: true,
      showColumns: true,                  //是否显示所有的列
      showRefresh: true,                  //是否显示刷新按钮
      minimumCountColumns: 2,             //最少允许的列数
      clickToSelect: true,                //是否启用点击选中行
      height: 1000,                        //行高，如果没有设置height属性，表格自动根据记录条数觉得表格高度
      uniqueId: "id",                     //每一行的唯一标识，一般为主键列
      showToggle: true,                    //是否显示详细视图和列表视图的切换按钮
      cardView: false,                    //是否显示详细视图
      detailView: false,                  //是否显示父子表
      responseHandler: responseHandler,   // 返回数据回调函数
      columns: [
        {
          field: 'checked',
          checkbox: true,
        }, {
          field: 'app_name',
          title: 'app名称'
        }, {
          field: 'appid',
          title: '应用ID'
        }, {
          field: 'url',
          title: '跳转链接'
        }, {
          field: 'show_url',
          title: '是否跳转'
        }, {
          field: 'update_url',
          title: '强更地址'
        }, {
          field: 'is_update',
          title: '是否强更'
        }, {
          field: 'type',
          title: '应用平台'
        }, {
          field: 'qqNumber',
          title: 'QQ客服'
        }, {
          field: 'username',
          title: '创建账户'
        }, {
          field: 'comment',
          title: '备注'
        }, {
          field: 'request_num',
          title: '请求次数'
        }, {
          field: 'createAt',
          title: '创建时间'
        },]
    });
  };

  //得到查询的参数
  oTableInit.queryParams = function (params) {
    var temp = {   //这里的键的名字和控制器的变量名必须一直，这边改动，控制器也需要改成一样的
      limit: params.limit,   //页面大小
      offset: params.offset,  //页码
      search_text: $("#txt_search").val(),
      search_type: search_type,
    };
    return temp;
  };
  return oTableInit;
};

function check_add_params_empty() {
  // alert($("input[name='add_type']:checked").val());
  var flag = true;
  if ($("#txt_add_app_id").val() == '') {
    flag = false;
  } else if ($("input[name='add_show']:checked").val() == null) {
    flag = false;
  } else if ($("input[name='add_type']:checked").val() == null) {
    flag = false;
  } else if ($("input[name='add_update']:checked").val() == null) {
    flag = false;
  }

  return flag;
}

function check_register_params_empty() {
  // alert($("input[name='add_type']:checked").val());
  var flag = true;
  if ($("#txt_register_username").val() == '') {
    flag = false;
  } else if ($("#txt_register_password").val() == '') {
    flag = false;
  }

  return flag;
}

function check_update_password_params_empty() {
  // alert($("input[name='add_type']:checked").val());
  var flag = true;
  if ($("#txt_update_username").val() == '') {
    flag = false;
  } else if ($("#txt_update_password").val() == '') {
    flag = false;
  }

  return flag;
}


function get_update_password_params() {
  var requestData = {
    "username": $("#txt_update_username").val(),
    "newpass": $("#txt_update_password").val(),
  };

  return requestData;
}

function get_register_params() {
  var requestData = {
    "username": $("#txt_register_username").val(),
    "password": $("#txt_register_password").val(),
  };

  return requestData;
}

function get_add_params() {
  var requestData = {
    "url": $("#txt_add_url").val(),
    "appid": $("#txt_add_app_id").val(),
    "appName": $("#txt_add_app_name").val(),
    "type": $("input[name='add_type']:checked").val() == 'android' ? "android" : 'ios',
    "show": $("input[name='add_show']:checked").val() == 'Yes' ? 1 : 0,
    "isUpdate": $("input[name='add_update']:checked").val() == 'Yes' ? 1 : 0,
    "updateUrl": $("#txt_add_update_url").val(),
    "comment": $("#txt_add_comment").val(),
    "qqNumber": $("#txt_add_qqnumber").val(),
  };

  return requestData;
}

function check_edit_params_empty() {
  var flag = true;
  if ($("#txt_edit_app_id").val() == '') {
    flag = false;
  } else if ($("input[name='edit_show']:checked").val() == null) {
    flag = false;
  } else if ($("input[name='edit_type']:checked").val() == null) {
    flag = false;
  } else if ($("input[name='edit_update']:checked").val() == null) {
    flag = false;
  }

  return flag;
}

function check_multi_update_params_all_empty() {
  var flag = false;
  if ($("#txt_multi_update_url").val() != '') {
    flag = true;
  } else if ($("input[name='multi_update_show']:checked").val() != null) {
    flag = true;
  } else if ($("#txt_multi_update_qqnumber").val() != '') {
    flag = true;
  } else if ($("input[name='edit_multi_update_update']:checked").val() != null) {
    flag = true;
  } else if ($("#txt_multi_update_update_url").val() != '') {
    flag = true;
  }

  return flag;
}

function get_multi_update_params() {
  var arrselections = $("#tb_departments").bootstrapTable('getSelections');

  // ids
  var arrayLength = arrselections.length;
  var ids = '';

  console.log($("input[name='multi_update_show']:checked").val());


  for (var i = 0; i < arrayLength; i++) {
    ids += arrselections[i].id + ',';
  }

  var show = '';
  if ($("input[name='multi_update_show']:checked").val() == 'Yes' || $("input[name='multi_update_show']:checked").val() == 'No') {
    show = $("input[name='multi_update_show']:checked").val() == 'Yes' ? 1 : 0;
  }

  var is_update = '';
  if ($("input[name='edit_multi_update_update']:checked").val() == 'Yes' || $("input[name='edit_multi_update_update']:checked").val() == 'No') {
    is_update = $("input[name='edit_multi_update_update']:checked").val() == 'Yes' ? 1 : 0;
  }

  var requestData = {
    "ids": ids,
    "url": $("#txt_multi_update_url").val(),
    "qqNumber": $("#txt_multi_update_qqnumber").val(),
    "show": show,
    "isUpdate": is_update,
    "updateUrl": $("#txt_multi_update_update_url").val(),
  };

  console.log(requestData);

  return requestData;
}

function get_edit_params() {
  var arrselections = $("#tb_departments").bootstrapTable(
    'getSelections');
  var requestData = {
    "id": arrselections[0].id,
    "url": $("#txt_edit_url").val(),
    "appid": $("#txt_edit_app_id").val(),
    "appName": $("#txt_edit_app_name").val(),
    "type": $("input[name='edit_type']:checked").val() == 'android' ? "android" : 'ios',
    "show": $("input[name='edit_show']:checked").val() == 'Yes' ? 1 : 0,
    "isUpdate": $("input[name='edit_update']:checked").val() == 'Yes' ? 1 : 0,
    "updateUrl": $("#txt_edit_update_url").val(),
    "comment": $("#txt_edit_comment").val(),
    "qqNumber": $("#txt_edit_qqnumber").val(),
  };

  return requestData;
}

var ButtonInit = function () {
  var oInit = new Object();
  var postdata = {};

  oInit.Init = function () {
    //初始化页面上面的按钮事件
    $("#btn_add").click(
      function () {
        $('#myModal1').modal();
      });
    $("#btn_add_submit").click(
      function () {
        if (!check_add_params_empty()) {
          alert("请填写完整");
        } else {
          var requestData = get_add_params();
          $.ajax({
            type: "get",
            contentType: "text/html;charset=utf-8",
            url: "./back/add.php",
            data: requestData,
            dataType: "json",
            success: function (data) {
              var rt_code = data.rt_code;
              if (rt_code == -1) {
                console.log("-1");
                alert("Something wrong, please contact dev.")
              } else if (rt_code == 0) {
                console.log("0");
                alert("Something wrong, please contact dev.")
              } else if (rt_code == 2) {
                console.log("2");
                // 有重复的appid
                alert("Appid 重复");
              } else if (rt_code == -2) {
                location.href = "./login.html";
              } else {
                console.log("Add success");
                $('#myModal1').modal('hide');
                $('#tb_departments').bootstrapTable('refresh');
              }
            },
            error: function () {
              toastr.error('Error');
            },
            complete: function () {

            }

          });
        }
      });

    $("#btn_multi_update").click(
      function () {
        var arrselections = $("#tb_departments").bootstrapTable(
          'getSelections');

        if (arrselections.length <= 0) {
          alert("请选择需要编辑的条目");
          return;
        }

        $('#myModal4').modal();
      });

    $("#btn_multi_update_submit").click(
      function () {
        if (!check_multi_update_params_all_empty()) {
          alert("请至少填写一个");
        } else {
          var requestData = get_multi_update_params();
          $.ajax({
            type: "get",
            contentType: "text/html;charset=utf-8",
            url: "./back/update_multiple.php",
            data: requestData,
            dataType: "json",
            success: function (data) {
              var rt_code = data.rt_code;
              if (rt_code == -1) {
                alert("Something wrong, please contact dev.")
              } else if (rt_code == 0) {
                alert("Something wrong, please contact dev.")
              } else if (rt_code == -2) {
                location.href = "./login.html";
              } else {
                alert("修改成功")
                console.log("Update success");
              }
              $('#myModal4').modal('hide');
              $('#tb_departments').bootstrapTable('refresh');
            },
            error: function () {
              console.log('Error');
            },
            complete: function () {

            }

          });
        }
      });

    $("#btn_edit").click(
      function () {
        var arrselections = $("#tb_departments").bootstrapTable(
          'getSelections');
        if (arrselections.length > 1) {
          alert("只能选择一个编辑");
          return;
        }
        if (arrselections.length <= 0) {
          alert("请选择需要编辑的条目");
          return;
        }
        $("#txt_edit_app_id").val(arrselections[0].appid);
        if (arrselections[0].show_url == 1) {
          $('input[id=optradio_edit_show_yes]').prop('checked', true);
          $('input[id=optradio_edit_show_false]').prop('checked', false);
        } else {
          $('input[id=optradio_edit_show_yes]').prop('checked', false);
          $('input[id=optradio_edit_show_false]').prop('checked', true);
        }
        $("#txt_edit_url").val(arrselections[0].url);

        if (arrselections[0].is_update == 1) {
          $('input[id=optradio_edit_update_yes]').prop('checked', true);
          $('input[id=optradio_edit_update_false]').prop('checked', false);
        } else {
          $('input[id=optradio_edit_update_yes]').prop('checked', false);
          $('input[id=optradio_edit_update_false]').prop('checked', true);
        }
        $("#txt_edit_update_url").val(arrselections[0].update_url);

        if (arrselections[0].type == 'android') {
          $('input[id=optradio_edit_ios]').prop('checked', false);
          $('input[id=optradio_edit_android]').prop('checked', true);
        } else {
          $('input[id=optradio_edit_ios]').prop('checked', true);
          $('input[id=optradio_edit_android]').prop('checked', false);
        }

        $("#txt_edit_comment").val(arrselections[0].comment);
        $("#txt_edit_app_name").val(arrselections[0].app_name);

        $("#txt_edit_qqnumber").val(arrselections[0].qqNumber);

        postdata.ROLE_ID = arrselections[0].ROLE_ID;
        $('#myModal2').modal();
      });

    $("#btn_edit_submit").click(
      function () {
        if (!check_edit_params_empty()) {
          alert("请填写完整");
        } else {
          var requestData = get_edit_params();
          $.ajax({
            type: "get",
            contentType: "text/html;charset=utf-8",
            url: "./back/update.php",
            data: requestData,
            dataType: "json",
            success: function (data) {
              var rt_code = data.rt_code;
              if (rt_code == -1) {
                alert("Something wrong, please contact dev.")
              } else if (rt_code == 0) {
                alert("Something wrong, please contact dev.")
              } else if (rt_code == -2) {
                location.href = "./login.html";
              } else {
                console.log("Update success");
              }
              $('#myModal2').modal('hide');
              $('#tb_departments').bootstrapTable('refresh');
            },
            error: function () {
              toastr.error('Error');
            },
            complete: function () {

            }

          });
        }
      });

    $("#btn_register").click(
      function () {
        $('#myModal3').modal();
      });


    $("#btn_register_submit").click(
      function () {
        if (!check_register_params_empty()) {
          alert("请填写完整");
        } else {
          var requestData = get_register_params();
          $.ajax({
            type: "get",
            contentType: "text/html;charset=utf-8",
            url: "./back/register.php",
            data: requestData,
            dataType: "json",
            success: function (data) {
              var rt_code = data.rt_code;
              if (rt_code == -1) {
                alert("Something wrong, please contact dev.")
              } else if (rt_code == 0) {
                alert("Something wrong, please contact dev.")
              } else if (rt_code == 3) {
                alert("注册失败！目前只支持主帐号注册子账号")
              } else if (rt_code == 4) {
                alert("注册失败！用户名已被注册")
              } else {
                alert("注册成功")
                console.log("Register success");
                $('#myModal3').modal('hide');
              }
            },
            error: function () {
              toastr.error('Error');
            },
            complete: function () {

            }

          });
        }
      });

    $("#btn_update_password").click(
      function () {
        $('#myModal5').modal();
      });


    $("#btn_update_password_submit").click(
      function () {
        if (!check_update_password_params_empty()) {
          alert("请填写完整");
        } else {
          var requestData = get_update_password_params();
          $.ajax({
            type: "get",
            contentType: "text/html;charset=utf-8",
            url: "./back/change_password.php",
            data: requestData,
            dataType: "json",
            success: function (data) {
              var rt_code = data.rt_code;
              if (rt_code == -1) {
                alert("Something wrong, please contact dev.")
              } else if (rt_code == 0) {
                alert("Something wrong, please contact dev.")
              } else if (rt_code == 3) {
                alert("更新失败！目前只支持主帐号修改子账户密码")
              } else {
                alert("更新密码成功")
                console.log("update password success");
                $('#myModal3').modal('hide');
              }
            },
            error: function () {
              toastr.error('Error');
            },
            complete: function () {

            }

          });
        }
      });

    $("#btn_delete").click(
      function () {
        var arrselections = $("#tb_departments")
          .bootstrapTable('getSelections');
        if (arrselections.length <= 0) {
          alert("至少选择一个");
          return;
        }
        var ids = "";
        console.log(arrselections.length);
        for (var i = 0; i < arrselections.length; i++) {
          ids = ids + arrselections[i].id + ",";
        }

        var requestData = {
          "ids": ids.substring(0, ids.length - 1),
        };

        $.ajax({
          type: "get",
          contentType: "text/html;charset=utf-8",
          url: "./back/del.php",
          data: requestData,
          dataType: "json",
          success: function (data) {
            var rt_code = data.rt_code;
            if (rt_code == -1) {
              alert("Something wrong, please contact dev.")
            } else if (rt_code == 0) {
              alert("Something wrong, please contact dev.")
            } else if (rt_code == -2) {
              location.href = "./login.html";
            } else {
              console.log("Delete success");
            }
            $('#myModal2').modal('hide');
            $('#tb_departments').bootstrapTable('refresh');
          },
          error: function () {
            toastr.error('Error');
          },
          complete: function () {
          }

        });

      });
  };

  return oInit;
};