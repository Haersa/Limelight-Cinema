function showConfirmModal(messageId) {
  document.getElementById("messageIdInput").value = messageId;
  document.getElementById("confirmModal").style.display = "flex";
}

function closeModal() {
  document.getElementById("confirmModal").style.display = "none";
  // Uncheck the checkbox if cancelled
  const checkboxes = document.getElementsByClassName("reply-checkbox");
  for (let checkbox of checkboxes) {
    checkbox.checked = false;
  }
}

// restrict access to screen sizes that aren't laptop/desktop.
function checkScreenSize() {
  const mobileRestriction = document.querySelector(".mobile-restriction");
  const adminContent = document.querySelector(".admin-content");
  const navbar = document.querySelector(".navbar");

  if (window.innerWidth <= 1024) {
    mobileRestriction.style.display = "flex";
    if (adminContent) adminContent.style.display = "none";
    if (navbar) navbar.style.display = "none";
  } else {
    mobileRestriction.style.display = "none";
    if (adminContent) adminContent.style.display = "block";
    if (navbar) navbar.style.display = "block";
  }
}

window.addEventListener("load", checkScreenSize);
window.addEventListener("resize", checkScreenSize);
