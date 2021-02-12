const footballGame = {
  token: 5,
  myBetForm: document.forms["myBetForm"],
  footballModal: document.getElementById("myCalendarModal"),
  footballSpan: document.getElementsByClassName("my_close")[0],
  tokenNum: document.getElementById("tokenNum"),
  tokenCost: document.getElementById("tokenCost"),
  tokenReturns: document.getElementById("tokenReturns"),
  updateTokenCost() {
    const squareBoxSelected = document.getElementsByClassName(
      "squareBoxSelected"
    );
    const squareBoxFilled = document.getElementsByClassName("squareBoxFilled");
    let predictNumber = squareBoxSelected.length;
    this.tokenNum.textContent = `${
      String(predictNumber).length <= 1 ? "0" + predictNumber : predictNumber
    }`;
    this.tokenCost.textContent = (
      Math.round(this.token * predictNumber * 100) / 100
    ).toFixed(2);

    let returns =
      squareBoxFilled.length * this.token - this.tokenCost.textContent;
    this.tokenReturns.textContent = (Math.round(returns * 100) / 100).toFixed(
      2
    );
  },
  watch(window) {
    const footballGame = this;
    this.myBetForm.addEventListener("submit", (e) => {
      e.preventDefault();
      e.stopPropagation();
      this.selectSquares();
      this.validateData(this.myBetForm);
    });
    this.footballSpan.addEventListener("click", () => {
      footballGame.footballModal.style.display = "none";
    });
    window.addEventListener("click", function (event) {
      if (event.target == footballGame.footballModal) {
        footballGame.footballModal.style.display = "none";
      }
    });
  },
  selectSquares() {
    let selectedSquares = document.getElementsByClassName("squareBoxSelected");
    selectedSquares = [...selectedSquares].map((element) => element.id);
    if (selectedSquares.length) {
      this.myBetForm.squares.value = selectedSquares;
    }
  },
  validateData(form) {
    const horizontalData = document.getElementById("horizontalNum");
    const squares = form.squares.value;

    if (horizontalData.value) {
      alert("This game have ended!");
      return false;
    }

    if (squares == "") {
      alert("Please select at least one square.");
      return false;
    } else {
      this.processData(this);
      return true;
    }
  },
  processData(footballGame) {
    const { myBetForm } = footballGame;
    jQuery.ajax({
      url: "/derrick/game/view",
      type: "POST",
      data: {
        squares: myBetForm.squares.value,
        game_id: myBetForm.game_id.value,
      },
      cache: false,
      success: function (response) {
        // Success message
        footballGame.footballModal.style.display = "block";
        let responseObject = JSON.parse(response);
        document.getElementById("my_modal-body").innerHTML =
          responseObject.output;
        footballGame.updateSquares(responseObject);
      },
      error: function (request, status, error) {
        // Fail message
        footballGame.footballModal.style.display = "block";
        document.getElementById("my_modal-body").innerHTML =
          request.responseText;
      },
      complete: function () {
        // alert('message Sent');
      },
    });
  },
  updateSquares(responseObject) {
    const { squares_arr, names_arr } = responseObject;
    const squareBoxes = document.getElementsByClassName("squareBox");
    // reset the user interface.
    this.myBetForm.squares.value = "";
    [...squareBoxes].forEach((boxCell) => {
      boxCell.textContent = "";
      if (boxCell.classList.contains("squareBoxSelected")) {
        boxCell.classList.remove("squareBoxSelected");
      }
      boxCell.style.backgroundColor = "";
    });
    //update the ui
    boardHeader.fillBoxes([squares_arr, names_arr], [...squareBoxes]);
  },
};
window.addEventListener("load", () => footballGame.watch(window));
