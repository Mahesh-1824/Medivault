const indi = document.getElementById("individual");
const org = document.getElementById("organization");
const toggle = document.getElementById("toggle-btn");

toggle.addEventListener("click", function () {
  if (indi.className === "solid") {
    indi.className = "line";
    org.className = "solid";
  } else {
    indi.className = "solid";
    org.className = "line";
  }
});
