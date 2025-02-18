// JavaScript for the modal
document.addEventListener("DOMContentLoaded", function () {
  // Get the modal
  var modal = document.getElementById("locationModal");

  // Get the button that opens the modal
  var btn = document.querySelector(".location-toggle");

  // Get the <span> element that closes the modal
  var span = document.querySelector(".close");

  // When the user clicks the button, open the modal
  if (btn) {
    btn.onclick = function (e) {
      e.preventDefault();
      modal.style.display = "block";
    };
  }

  // When the user clicks on <span> (x), close the modal
  span.onclick = function () {
    modal.style.display = "none";
  };

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };
});
