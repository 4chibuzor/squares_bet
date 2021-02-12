(function () {
  "use strict";
  window.addEventListener(
    "load",
    function () {
      document.getElementById("joinSubmitButton").disabled = false;
      const submitSpinner = document.getElementById("submitSpinner");
      const footballModal = document.getElementById("myCalendarModal");
      const modalSpan = document.getElementsByClassName("my_close")[0];

      //userLoginForm
      const userLoginForm = {
        registerForm: document.forms["joinMatch"],
        getResult(response, modalBox) {
          modalBox.innerHTML = "";
          let ajaxFormContent = JSON.parse(response);
          let classType;
          if ("message" in ajaxFormContent) {
            userLoginForm.registerForm.classList.remove("was-validated");
            userLoginForm.registerForm.reset();
            classType = "badge badge-success";
            window.location.href =
              "/derrick/game/view?game_id=" +
              userLoginForm.registerForm.game_id.value;
          } else {
            classType = "badge badge-danger";
          }

          let ajaxFormkeys = Object.keys(ajaxFormContent);
          var feedback = ajaxFormkeys.map(
            (
              content
            ) => `<br/><p style="line-height:1.6em;" class="${classType}">
                        ${ajaxFormContent[content]}</p>`
          );

          var SectionParagraphs = document.createElement("div");
          SectionParagraphs.innerHTML = feedback;
          SectionParagraphs.innerHTML = SectionParagraphs.innerHTML.replace(
            />,/gi,
            ">"
          );
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
              //console.log(pair[0] + " : " + pair[1]);
            }
          } else {
            form.classList.add("was-validated");
            submitSpinner.style.display = "block";
            jQuery.ajax({
              url: userLoginForm.registerForm.action,
              type: "POST",
              data: {
                match_id: userLoginForm.registerForm.match_id.value,
                match_password: userLoginForm.registerForm.match_password.value,
                game_id: userLoginForm.registerForm.game_id.value,
              },
              cache: false,
              success: function (response) {
                submitSpinner.style.display = "none";
                // Success message
                footballModal.style.display = "block";
                userLoginForm.getResult(
                  response,
                  document.getElementById("my_modal-body")
                );
              },
              error: function (request, status, error) {
                submitSpinner.style.display = "none";
                // Fail message
                footballModal.style.display = "block";
                userLoginForm.getResult(
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
      userLoginForm.registerForm.addEventListener("submit", function (e) {
        userLoginForm.handleFormSubmit(e);
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
