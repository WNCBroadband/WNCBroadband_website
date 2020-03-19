 var collapse = document.getElementsByClassName("mapkeycollapsible");
var i;

for (i = 0; i < collapse.length; i++) {
  collapse[i].addEventListener("click", function() {
    this.classList.toggle("mapkeyexpanded");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
      content.style.height = "250px";
      content.style.bottom = "0px";
      content.style.transition = "max-height .5s ease-out";
    }
  });
}