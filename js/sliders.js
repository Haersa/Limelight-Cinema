document.addEventListener("DOMContentLoaded", function () {
  // index page hero carousel
  const carousel = new Flickity(".hero-carousel", {
    cellAlign: "center",
    contain: false,
    prevNextButtons: false,
    pageDots: true,
    wrapAround: true,
    autoPlay: 5000,
    percentPosition: true,
    selectedAttraction: 0.03,
    friction: 0.3,
    adaptiveHeight: false,
    initialIndex: 0,
    draggable: false,
  });

  document
    .querySelector(".hero-navigation-buttons .prev-button")
    .addEventListener("click", () => {
      carousel.previous();
    });

  document
    .querySelector(".hero-navigation-buttons .next-button")
    .addEventListener("click", () => {
      carousel.next();
    });
});

// top films flickity carousel
document.addEventListener("DOMContentLoaded", function () {
  var elem = document.querySelector(".films-flickity-carousel");

  var flkty = new Flickity(elem, {
    cellAlign: "left",
    contain: true,
    wrapAround: true,
    pageDots: false,
    prevNextButtons: false,
    groupCells: 1,
    percentPosition: false,
    draggable: false,
  });

  var previousButton = document.querySelector(".films-nav-button.prev-button");
  var nextButton = document.querySelector(".films-nav-button.next-button");

  previousButton.addEventListener("click", function () {
    flkty.previous();
  });

  nextButton.addEventListener("click", function () {
    flkty.next();
  });
});
