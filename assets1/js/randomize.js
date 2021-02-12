function shuffle(array) {
  var currentIndex = array.length,
    temporaryValue,
    randomIndex;

  // While there remain elements to shuffle...
  while (0 !== currentIndex) {
    // Pick a remaining element...
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex -= 1;

    // And swap it with the current element.
    temporaryValue = array[currentIndex];
    array[currentIndex] = array[randomIndex];
    array[randomIndex] = temporaryValue;
  }
  return array;
}

var getHorizontalNumber = document.getElementById("horizontalNum");
var getVerticalNumber = document.getElementById("verticalNum");

getHorizontalNumber.value = shuffle([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
getVerticalNumber.value = shuffle([9, 8, 7, 6, 5, 4, 3, 2, 1, 0]);

window.addEventListener("DOMContentLoaded", () => {
  var completedHorizontal = document.getElementById("horizontalNum");
  var completedVertical = document.getElementById("verticalNum");
  squaresCompleted.horizontal = completedHorizontal.value;
  squaresCompleted.vertical = completedVertical.value;
});
