//mobile menu toggle

document.addEventListener("DOMContentLoaded", function () {
  const menuToggle = document.querySelector(".menu-toggle");
  const mobileMenu = document.querySelector(".mobile-menu");
  const closeMenu = document.querySelector(".close-menu");

  menuToggle.addEventListener("click", () => {
    mobileMenu.classList.add("active");
  });

  closeMenu.addEventListener("click", () => {
    mobileMenu.classList.remove("active");
  });
});

//profile icon dropdown menu toggle

document.addEventListener("DOMContentLoaded", function () {
  const profileToggle = document.querySelector(".profile-toggle");
  const profileDropdown = document.getElementById("profileDropdown");

  if (profileToggle && profileDropdown) {
    profileToggle.addEventListener("click", function (e) {
      e.stopPropagation();
      profileDropdown.classList.toggle("show");
      const expanded = profileDropdown.classList.contains("show");
      this.setAttribute("aria-expanded", expanded);
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", function (e) {
      if (
        !profileToggle.contains(e.target) &&
        !profileDropdown.contains(e.target)
      ) {
        profileDropdown.classList.remove("show");
        profileToggle.setAttribute("aria-expanded", "false");
      }
    });
  }
});

//mobile menu open/close change cinema dropdown menu

const changeCinemaBtn = document.querySelector(".change-cinema-link");
const cinemaOptions = document.querySelector(".mobile-cinema-options");

if (changeCinemaBtn && cinemaOptions) {
  changeCinemaBtn.addEventListener("click", function () {
    cinemaOptions.classList.toggle("show");
    const isExpanded = cinemaOptions.classList.contains("show");
    this.setAttribute("aria-expanded", isExpanded);
  });
}

// open/close cinema location change modal
document.addEventListener("DOMContentLoaded", function () {
  // Modal functionality
  const locationToggle = document.querySelector(".location-toggle");
  const locationModal = document.getElementById("modal-location");
  const closeButton = document.querySelector(".modal-location-close");

  if (locationToggle) {
    locationToggle.onclick = function () {
      locationModal.classList.add("show");
    };
  }

  if (closeButton) {
    closeButton.onclick = function () {
      locationModal.classList.remove("show");
    };
  }

  window.onclick = function (event) {
    if (event.target == locationModal) {
      locationModal.classList.remove("show");
    }
  };

  // W3Schools Accordion Code
  var acc = document.getElementsByClassName("modal-accordion");
  var i;

  for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function () {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight) {
        panel.style.maxHeight = null;
      } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
      }
    });
  }
});

// Get all seat buttons
const seatButtons = document.querySelectorAll(".seat-button");

// Add click event listener to each button
seatButtons.forEach((button) => {
  button.addEventListener("click", function () {
    // If button is already active, remove active class
    if (this.classList.contains("active")) {
      this.classList.remove("active");
    }
    // If button is not active and less than 4 seats are selected
    else if (document.querySelectorAll(".seat-button.active").length < 4) {
      this.classList.add("active");
    }

    // Check the number of active seats
    const activeSeats = document.querySelectorAll(".seat-button.active").length;

    // If exactly 4 seats are now selected, disable all other seats
    if (activeSeats === 4) {
      seatButtons.forEach((btn) => {
        if (!btn.classList.contains("active")) {
          btn.classList.add("disabled");
          btn.disabled = true; // Add disabled boolean property, to make sure it doesnt post the value if a user clicks on a 'disabled' button
        }
      });
    }
    // If less than 4 seats are selected, re-enable all seats
    else {
      seatButtons.forEach((btn) => {
        btn.classList.remove("disabled");
        btn.disabled = false; // Remove disabled boolean property
      });
    }
  });
});
