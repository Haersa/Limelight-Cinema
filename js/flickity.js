var elem = document.querySelector(".main-carousel");
var flkty = new Flickity(elem, {
  cellAlign: "left",
  contain: true,
  wrapAround: true,
  autoPlay: 4000, // autoplay every 4s
});
