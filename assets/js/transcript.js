(function () {
  var transcriptButton = document.getElementById("transcriptButton");
  var transcriptArticle = document.getElementById("transcriptArticle");

  var pageName = window.location.pathname;
  var transcriptUrl = "https://purposefullday.xyz/transcript?t=" + pageName;

  window.addEventListener("DOMContentLoaded", () => {
    fetch(transcriptUrl, {
      mode: "cors",
      redirect: "follow",
      cache: "no-cache",
    })
      .then((response) => {
        console.log("Waiting for response ...");
        if (response.ok) {
          return response;
        }
        throw Error(response.statusText);
      })
      .then((response) => response.json())
      .then((jsonResponse) => {
        let transcriptContent = jsonResponse;
        transcriptArticle.innerHTML = transcriptContent.content.content;
      })
      .catch((error) => {
        transcriptArticle.innerHTML = `<p>Transcript not available at this time</p>`;
        console.log("There was an error: ", error);
      }, false);
  });
  transcriptButton.addEventListener("click", function () {
    if (transcriptArticle.style.display == "none") {
      transcriptArticle.style.display = "block";
      transcriptButton.textContent = "HIDE TRANSCRIPT";
    } else {
      transcriptArticle.style.display = "none";
      transcriptButton.textContent = "SHOW TRANSCRIPT";
    }
  });
})();
