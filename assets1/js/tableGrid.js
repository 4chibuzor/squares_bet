const tableBody = function () {
  const i = "columnNums";
  let cells = `
            <tr key=${i} class="columnNums">
                <th id="squareImgHolder"></th>
                <th id="${i}0" class="columnNum">O</th>
                <th id="${i}1" class="columnNum">O</th>
                <th id="${i}2" class="columnNum">O</th>
                <th id="${i}3" class="columnNum">O</th>
                <th id="${i}4" class="columnNum">O</th>
                <th id="${i}5" class="columnNum">O</th>
                <th id="${i}6" class="columnNum">O</th>
                <th id="${i}7" class="columnNum">O</th>
                <th id="${i}8" class="columnNum">O</th>
                <th id="${i}9" class="columnNum">O</th>
            </tr>`;

  for (let j = 0; j < 10; j++) {
    cells += `
            <tr key=${j}>
                <th id="rowNums${j}" class="rowNum"></th>
                <td id="${j}0" class="squareBox"></td>
                <td id="${j}1" class="squareBox"></td>
                <td id="${j}2" class="squareBox"></td>
                <td id="${j}3" class="squareBox"></td>
                <td id="${j}4" class="squareBox"></td>
                <td id="${j}5" class="squareBox"></td>
                <td id="${j}6" class="squareBox"></td>
                <td id="${j}7" class="squareBox"></td>
                <td id="${j}8" class="squareBox"></td>
                <td id="${j}9" class="squareBox"></td>
            </tr>`;
  }
  return `<tbody>${cells}</tbody>`;
};
