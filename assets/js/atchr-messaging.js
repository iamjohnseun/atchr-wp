(function () {
  var elem = document.createElement("script"),
    frame = document.getElementsByTagName("script")[0];
  elem.async = true;
  elem.src = "https://embed.atchr.com/" + atchrMessaging.embedCode;
  elem.charset = "UTF-8";
  elem.setAttribute("crossorigin", "*");
  elem.setAttribute("scrolling", "no");
  elem.setAttribute("allowTransparency", "true");
  frame.parentNode.insertBefore(elem, frame);
})();
