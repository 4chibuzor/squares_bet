const boardHeader = {
  horizontal: document.getElementById("horizontalNum"),
  vertical: document.getElementById("verticalNum"),
  createElement(tag, attributes, content) {
    const element = document.createElement(tag);
    for (let att in attributes) {
      element.setAttribute(att, attributes[att]);
    }
    element.textContent = content;
    return element;
  },
  getHorizVertNum() {
    if (this.horizontal.value && this.vertical.value) {
      const horiz = this.horizontal.value.replace(/,/gi, "");
      const vert = this.vertical.value.replace(/,/gi, "");
      this.rows = [...horiz].map((num) => parseInt(num));
      this.cols = [...vert].map((num) => parseInt(num));
    } else {
      this.rows = ["X", "X", "X", "X", "X", "X", "X", "X", "X", "X"];
      this.cols = ["X", "X", "X", "X", "X", "X", "X", "X", "X", "X"];
    }
    return [this.rows, this.cols];
  },
  placeNumbers(array) {
    const [colNums, rowNums] = array;
    this.getHorizVertNum();
    colNums.forEach((colHeaderElement, i) => {
      colHeaderElement.textContent = this.cols[i];
    });
    rowNums.forEach((rowHeaderElement, i) => {
      rowHeaderElement.textContent = this.rows[i];
    });
  },
  setNameInitials(names) {
    const initial = names.split(" ");
    return `${initial[0][0].toUpperCase()} ${initial[1][0].toUpperCase()}`;
  },
  fillBoxes(array, squareBoxes) {
    const [taken_squares, player_names] = array;
    taken_squares.forEach((squares, index) => {
      squares.forEach((square) => {
        squareBoxes[parseInt(square)].textContent = this.setNameInitials(
          player_names[index]
        );
        squareBoxes[parseInt(square)].classList.add("squareBoxFilled");
      });
    });
  },
};

document.addEventListener("DOMContentLoaded", () => {
  const responsiveStyle = boardHeader.createElement(
    "link",
    {
      rel: "stylesheet",
      href: "/derrick/assets/css/bet-slip-responsive.css",
    },
    null
  );
  const squareBoardStyle = boardHeader.createElement(
    "link",
    {
      rel: "stylesheet",
      href: "/derrick/assets/css/squares.css",
    },
    null
  );
  document.head.appendChild(responsiveStyle);
  document.head.appendChild(squareBoardStyle);
  const table = document.createElement("table");
  table.setAttribute("id", "squareBoxTable");
  table.innerHTML = tableBody().replace(/>,/gi, ">");
  document.getElementById("squareBoard").appendChild(table);
});

window.addEventListener("load", () => {
  document.getElementById("squareImgHolder").style.backgroundImage =
    "url(/derrick/assets1/images/sb.jpg)";

  const squareColumnHeader = document.getElementsByClassName("columnNum");
  const squareRowHeader = document.getElementsByClassName("rowNum");
  const squareBoxes = document.getElementsByClassName("squareBox");

  boardHeader.placeNumbers([[...squareColumnHeader], [...squareRowHeader]]);
  boardHeader.fillBoxes([taken_squares, player_names], [...squareBoxes]);
  document
    .getElementById("squareBoard")
    .addEventListener("click", function (e) {
      if (e.target.classList[0] == "squareBox") {
        e.target.classList.toggle("squareBoxSelected");
        footballGame.updateTokenCost();
      }
    });
});
