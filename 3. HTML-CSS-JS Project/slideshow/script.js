const IMG_WIDTH = 350;
const slideContainer = $(".slides");
const slideImages = [...$$(".slide")];

slideContainer.style.width = `${slideImages.length * IMG_WIDTH}px`;

let index = 0;

function next() {
  if (index < slideImages.length - 1) {
    index++;
  } else {
    index = 0;
  }

  slideContainer.style.transform = `translateX(-${IMG_WIDTH * index}px)`;
}
function prev() {
  if (index === 0) {
    index = slideImages.length - 1;
  } else {
    index--;
  }

  slideContainer.style.transform = `translateX(-${IMG_WIDTH * index}px)`;
}

$("#next").addEventListener("click", () => {
  next();
});
$("#prev").addEventListener("click", () => {
  prev();
});

setInterval(() => {
  next();
}, 2 * 1000);
