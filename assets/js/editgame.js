(function () {
  "use strict";
  window.addEventListener(
    "load",
    function () {
      document.getElementById("createGameSubmitButton").disabled = false;
      const submitSpinner = document.getElementById("submitSpinner");
      var footballModal = document.getElementById("myCalendarModal");
      var modalSpan = document.getElementsByClassName("my_close")[0];

      const createGameForm = {
        registerForm: document.forms["createGameForm"],
        getResult(response, modalBox) {
          let ajaxFormContent = JSON.parse(response);
          let classType;
          if ("message" in ajaxFormContent) {
            createGameForm.registerForm.classList.remove("was-validated");
            createGameForm.registerForm.reset();
            classType = "badge badge-success";
            window.location.reload();
          } else {
            classType = "badge badge-danger";
          }

          let ajaxFormkeys = Object.keys(ajaxFormContent);
          var feedback = ajaxFormkeys.map(
            (content) =>
              `<br/><p style="line-height:1.6em;" class="${classType}">${ajaxFormContent[content]}</p>`
          );

          var SectionParagraphs = document.createElement("div");
          SectionParagraphs.innerHTML = feedback;
          SectionParagraphs.innerHTML = SectionParagraphs.innerHTML.replace(
            />,/gi,
            ">"
          );
          modalBox.innerHTML = "";
          modalBox.appendChild(SectionParagraphs);
        },
        handleFormSubmit: function (e) {
          e.preventDefault();
          e.stopPropagation();
          const form = e.target;
          const formData = new FormData(form);

          if (form.checkValidity() === false) {
            form.classList.add("was-validated");
            console.log("all register form value is false");
            for (var pair of formData.entries()) {
              console.log(pair[0] + " : " + pair[1]);
            }
          } else {
            passwordGenerator();
            form.classList.add("was-validated");
            submitSpinner.style.display = "block";
            let formData = {
              game_id: createGameForm.registerForm.game_id.value,
              title: createGameForm.registerForm.title.value,
              match_id: createGameForm.registerForm.match_id.value,
              match_password: createGameForm.registerForm.match_password.value,
              max_allowed: createGameForm.registerForm.max_allowed.value,
              team_a: createGameForm.registerForm.team_a.value,
              team_b: createGameForm.registerForm.team_b.value,
              team_a_score: createGameForm.registerForm.team_a_score.value,
              team_b_score: createGameForm.registerForm.team_b_score.value,
              match_date: createGameForm.registerForm.match_date.value,
              match_time: createGameForm.registerForm.match_time.value,
              match_info: createGameForm.registerForm.match_info.value,
              status: createGameForm.registerForm.status.value,
            };
            jQuery.ajax({
              url: createGameForm.registerForm.action,
              type: "POST",
              data: formData,
              cache: false,
              success: function (response) {
                // Success message
                submitSpinner.style.display = "none";
                footballModal.style.display = "block";
                createGameForm.getResult(
                  response,
                  document.getElementById("my_modal-body")
                );
              },
              error: function (request, status, error) {
                // Fail message
                submitSpinner.style.display = "none";
                footballModal.style.display = "block";
                createGameForm.getResult(
                  response,
                  document.getElementById("my_modal-body")
                );
              },
              complete: function () {
                // alert('message Sent');
              },
            });
          }
        },
      };
      createGameForm.registerForm.addEventListener("submit", function (e) {
        createGameForm.handleFormSubmit(e);
      });
      // When the user clicks on <span> (x), close the modal
      modalSpan.onclick = function () {
        footballModal.style.display = "none";
      };

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function (event) {
        if (event.target == footballModal) {
          footballModal.style.display = "none";
        }
      };
    },
    false
  );
})();
