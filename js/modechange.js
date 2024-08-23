$(function () {
  checkNightMode();
  $("#cb3").click(function () {
    var beforeContent = window.getComputedStyle($("#cb-btn")[0], "::before").getPropertyValue("left");
    var afterContent = window.getComputedStyle($("#cb-btn")[0], "::after").getPropertyValue("left");
    if (beforeContent == "0px") {
      $("body").addClass("dark");
      setCookie("dark_mode", 1, 7)
    }
    if (afterContent == "0px") {
      $("body").removeClass("dark");
      setCookie("dark_mode", 0, 7)
    }
  });
})

function checkNightMode() {
  var Mode = getCookie("dark_mode");
  cookiesExp = new Date(new Date().setMonth(new Date().getMonth() + 1));

  //存在暗色模式标识符，且Cookies中DarkMode值为1
  if (Mode == 1) {
    // 值为1：切换为暗色模式
    $("body").addClass("dark");
    // 手动设置切换标签
    $("#cb3").click();
  }
  //不存在暗色模式标识符情况下，是否需要启用暗色模式
  else if (Mode == null || Mode == "undefined" || Mode == "") {
    $("body").removeClass("dark");
    if (isAuto) {
      // 媒体查询，用户系统是否启动暗色模式
      if (matchMedia('(prefers-color-scheme: dark)').matches) {
        $("body").addClass("dark");
        $("#cb3").click();
      }
      // 媒体查询，用户系统是否启动亮色模式
      else if (matchMedia('(prefers-color-scheme: light)').matches) {
        $("body").removeClass("dark");
      }
    }
  }
}

function setCookie(name, value, days) {
  var expires = "";
  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    expires = "; expires=" + date.toUTCString();
  }
  document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i].trim();
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
  }
  return null;
}