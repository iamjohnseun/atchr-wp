(function () {
  if (typeof atchrMessaging !== 'undefined' && atchrMessaging.entityID) {
    var elem = document.createElement("script"),
      frame = document.getElementsByTagName("script")[0];
    elem.async = true;
    elem.src = "https://embed.atchr.com/" + atchrMessaging.entityID;
    elem.setAttribute("crossorigin", "*");
    elem.setAttribute("scrolling", "no");
    elem.setAttribute("allowTransparency", "true");
    frame.parentNode.insertBefore(elem, frame);
  }
})();
