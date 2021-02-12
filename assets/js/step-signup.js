$(document).ready(function () {
  var inputed = false;

  // confirmation step
  var firstConfirm = $("#first-confirm");
  var secondConfirm = $("#2nd-confirm");
  var thirdConfirm = $("#3rd-confirm");
  var finalConfirm = $("#final-confirm");

  // all form step
  var firstBtn = $("#first-step").find(".next");
  var secondBtn = $("#second-step").find(".next");
  var thirdBtn = $("#third-step").find(".next");

  // all prev form step
  var secondPrevBtn = $("#second-step").find(".prev");
  var thirdPrevBtn = $("#third-step").find(".prev");

  function nextStep() {
    $("#first-step").hide(500);
    $("#second-step").show(500);
    secondConfirm.addClass("active");
  }

  function prevStep() {
    $("#second-step").hide(500);
    $("#first-step").show(500);
    secondConfirm.removeClass("active");
    firstConfirm.addClass("active");
  }

  function secondStep() {
    $("#second-step").hide(500);
    $("#third-step").show(500);
    thirdConfirm.addClass("active");
  }
  function secondPrev() {
    $("#third-step").hide(500);
    $("#second-step").show(500);
    thirdConfirm.removeClass("active");
    secondConfirm.addClass("active");
  }

  function finalStep() {
    $("#third-step").hide(500);
    $("#fourth-step").show(0);
    finalConfirm.addClass("active");
    console.log("formsubmitted");
  }
  class RegisterValidation {
    constructor() {
      this.submitSpinner = document.getElementById("submitSpinner");
      this.footballModal = document.getElementById("myCalendarModal");
      this.modalSpan = document.getElementsByClassName("my_close")[0];
      this.RegisterForm = document.forms["registerForm"];

      /*firstName*/
      this.firstName = this.RegisterForm["firstName"];
      this.firstNamePattern = /([^\s])/;
      let errorFirstNameTag = this.createErrorElement(
        "small",
        { class: "RegisterFormError", style: "display:none;" },
        "Please provide a valid First name"
      );
      this.firstName.parentNode.appendChild(errorFirstNameTag);

      /*lastName*/
      this.lastName = this.RegisterForm["lastName"];
      this.lastNamePattern = /([^\s])/;
      let errorLastNameTag = this.createErrorElement(
        "small",
        { class: "RegisterFormError", style: "display:none;" },
        "Please provide a valid Last Name"
      );
      this.lastName.parentNode.appendChild(errorLastNameTag);

      /*YourEmail*/
      this.YourEmail = this.RegisterForm["emailAdd"];
      this.YourEmailPattern = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
      let errorEmailTag = this.createErrorElement(
        "small",
        { class: "qqf_RegisterFormError", style: "display:none;" },
        "Invalid Email Address"
      );
      this.YourEmail.parentNode.appendChild(errorEmailTag);

      /*countryName*/
      this.countryName = this.RegisterForm["countryName"];
      this.countryNamePattern = /([^\s])/;
      let errorcountryNameTag = this.createErrorElement(
        "small",
        { class: "RegisterFormError", style: "display:none;" },
        "Please provide a valid Country"
      );
      this.countryName.parentNode.appendChild(errorcountryNameTag);

      /*countryName*/
      this.address = this.RegisterForm["address-line"];
      this.addressPattern = /([^\s])/;
      let erroraddressTag = this.createErrorElement(
        "small",
        { class: "RegisterFormError", style: "display:none;" },
        "Please provide a valid Address"
      );
      this.address.parentNode.appendChild(erroraddressTag);

      /*cityName*/
      this.cityName = this.RegisterForm["cityName"];
      this.cityNamePattern = /([^\s])/;
      let errorcityNameTag = this.createErrorElement(
        "small",
        { class: "RegisterFormError", style: "display:none;" },
        "Please provide a valid city name"
      );
      this.cityName.parentNode.appendChild(errorcityNameTag);

      /*userName*/
      this.userName = this.RegisterForm["userName"];
      this.userNamePattern = /([^\s])/;
      let erroruserNameTag = this.createErrorElement(
        "small",
        { class: "RegisterFormError", style: "display:none;" },
        "Please provide a valid username"
      );
      this.userName.parentNode.appendChild(erroruserNameTag);

      /*passwordNo*/
      this.passwordNo = this.RegisterForm["passwordNo"];
      this.passwordNoPattern = /([^\s])/;
      let errorpasswordNoTag = this.createErrorElement(
        "small",
        { class: "RegisterFormError", style: "display:none;" },
        "Please provide a valid password"
      );
      this.passwordNo.parentNode.appendChild(errorpasswordNoTag);

      /*passwordNo*/
      this.passwordAgain = this.RegisterForm["passwordAgain"];
      this.passwordAgainPattern = /([^\s])/;
      let errorpasswordAgainTag = this.createErrorElement(
        "small",
        { class: "RegisterFormError", style: "display:none;" },
        "Password does not match"
      );
      this.passwordAgain.parentNode.appendChild(errorpasswordAgainTag);
    }

    createErrorElement(tag, attributes, content) {
      let element = document.createElement(tag);
      for (const key in attributes) {
        element.setAttribute(key, attributes[key]);
      }
      element.textContent = content;
      return element;
    }
    validatePasswordAgainInput(element, submitButton) {
      if (element.value != this.passwordNo.value) {
        element.nextElementSibling.nextElementSibling.style.display = "block";
        element.nextElementSibling.nextElementSibling.style.border =
          "1px solid orangered";
        submitButton.disabled = true;
      } else {
        element.nextElementSibling.nextElementSibling.style.display = "none";
        submitButton.disabled = false;
      }
      element.addEventListener(
        "blur",
        () => {
          this.validateAgeInput(element, submitButton);
        },
        false
      );
      return;
    }

    validateFormInput(element, pattern, submitButton) {
      if (!pattern.test(element.value)) {
        element.nextElementSibling.nextElementSibling.style.display = "block";
        element.nextElementSibling.nextElementSibling.style.border =
          "1px solid orangered";
        submitButton.disabled = true;
      } else {
        element.nextElementSibling.nextElementSibling.style.display = "none";
        submitButton.disabled = false;
      }
      element.addEventListener(
        "input",
        () => {
          this.validateFormInput(element, pattern, submitButton);
        },
        false
      );
      return;
    }

    getResult(response, modalBox, RegisterForm) {
      console.log("response => ", response);
      let ajaxFormContent = JSON.parse(response);
      let classType;
      console.log("ajaxFormContent => ", ajaxFormContent);
      if ("message" in ajaxFormContent) {
        RegisterForm.classList.remove("was-validated");
        RegisterForm.reset();
        classType = "badge badge-success";
        finalStep();
      } else {
        classType = "badge badge-danger";
      }

      let ajaxFormkeys = Object.keys(ajaxFormContent);
      var feedback = ajaxFormkeys.map(
        (content) => `<br/><p style="line-height:1.6em;" class="${classType}">
                          ${ajaxFormContent[content]}</p>`
      );

      var SectionParagraphs = document.createElement("div");
      SectionParagraphs.innerHTML = feedback;
      SectionParagraphs.innerHTML = SectionParagraphs.innerHTML.replace(
        />,/gi,
        ">"
      );
      modalBox.innerHTML = "";
      modalBox.appendChild(SectionParagraphs);
    }
    handleFormSubmit = () => {
      const { RegisterForm, submitSpinner, footballModal, getResult } = this;
      const form = RegisterForm;
      const formData = new FormData(form);

      if (form.checkValidity() === false) {
        form.classList.add("was-validated");
        // for (var pair of formData.entries()) {
        //   // console.log(pair[0] + " : " + pair[1]);
        // }
        alert("please go back and check all form inputs");
      } else {
        form.classList.add("was-validated");

        jQuery.ajax({
          url: "http://localhost/derrick/signup",
          type: "POST",
          data: {
            firstname: RegisterForm.firstname.value,
            lastname: RegisterForm.lastname.value,
            email: RegisterForm.email.value,
            telephone: RegisterForm.telephone.value,
            country: RegisterForm.country.value,
            address: RegisterForm.address.value,
            city: RegisterForm.city.value,
            telephone: RegisterForm.telephone.value,
            username: RegisterForm.username.value,
            password: RegisterForm.password.value,
            confirm: RegisterForm.confirm.value,
          },
          cache: false,
          success: function (response) {
            submitSpinner.style.display = "none";
            footballModal.style.display = "block";
            getResult(
              response,
              document.getElementById("my_modal-body"),
              RegisterForm
            );
          },
          error: function (request, status, error) {
            submitSpinner.style.display = "none";

            footballModal.style.display = "block";
            getResult(
              response,
              document.getElementById("my_modal-body"),
              RegisterForm
            );
          },
          complete: function () {
            // alert('message Sent');
          },
        });
      }
    };
  }

  //form validation
  const FormValidation = new RegisterValidation();
  console.log("FormValidation.registerForm => ", FormValidation.RegisterForm);
  // When the user clicks on <span> (x), close the modal
  FormValidation.modalSpan.onclick = function () {
    FormValidation.footballModal.style.display = "none";
  };

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function (event) {
    if (event.target == FormValidation.footballModal) {
      FormValidation.footballModal.style.display = "none";
    }
  };
  /*Form firstName input validation Listener*/
  FormValidation.firstName.addEventListener(
    "blur",
    function () {
      FormValidation.validateFormInput(
        FormValidation.firstName,
        FormValidation.firstNamePattern,
        document.getElementById("firstNext")
      );
    },
    false
  );
  /*Form lastName input validation Listener*/
  FormValidation.lastName.addEventListener(
    "blur",
    function () {
      FormValidation.validateFormInput(
        FormValidation.lastName,
        FormValidation.lastNamePattern,
        document.getElementById("firstNext")
      );
    },
    false
  );
  /*Form YourEmail input validation Listener*/
  FormValidation.YourEmail.addEventListener(
    "blur",
    function () {
      FormValidation.validateFormInput(
        FormValidation.YourEmail,
        FormValidation.YourEmailPattern,
        document.getElementById("firstNext")
      );
    },
    false
  );
  /*Form YourEmail input validation Listener*/
  FormValidation.YourEmail.addEventListener(
    "blur",
    function () {
      FormValidation.validateFormInput(
        FormValidation.YourEmail,
        FormValidation.YourEmailPattern,
        document.getElementById("firstNext")
      );
    },
    false
  );

  /*Form countryName input validation Listener*/
  FormValidation.countryName.addEventListener(
    "blur",
    function () {
      FormValidation.validateFormInput(
        FormValidation.countryName,
        FormValidation.countryNamePattern,
        document.getElementById("secondNext")
      );
    },
    false
  );
  /*Form cityName input validation Listener*/
  FormValidation.cityName.addEventListener(
    "blur",
    function () {
      FormValidation.validateFormInput(
        FormValidation.cityName,
        FormValidation.cityNamePattern,
        document.getElementById("secondNext")
      );
    },
    false
  );

  /*Form userName input validation Listener*/
  FormValidation.userName.addEventListener(
    "blur",
    function () {
      FormValidation.validateFormInput(
        FormValidation.userName,
        FormValidation.userNamePattern,
        document.getElementById("thirdNext")
      );
    },
    false
  );
  /*Form passwordAgain input validation Listener*/
  FormValidation.passwordAgain.addEventListener(
    "blur",
    function () {
      FormValidation.validatePasswordAgainInput(
        FormValidation.passwordAgain,
        document.getElementById("thirdNext")
      );
    },
    false
  );
  firstBtn.on("click", function (event) {
    event.preventDefault();
    var firstName = $("#first-step").find("input#firstName").val();
    var lastName = $("#first-step").find("input#lastName").val();
    var emailAdd = $("#first-step").find("input#emailAdd").val();
    // var dOb = $("#first-step").find("input#dOb").val();

    if (
      firstName.length === 0 ||
      lastName.length === 0 ||
      emailAdd.length === 0
      // ||
      // dOb.length === 0
      // parseInt(dOb) < 18
    ) {
    } else {
      nextStep();
    }
  });

  secondBtn.on("click", function (event) {
    event.preventDefault();
    var countryName = $("#second-step").find("input#countryName").val();
    var addressLine = $("#second-step").find("input#address-line").val();
    var cityName = $("#second-step").find("input#cityName").val();
    var mobileNumber = $("#second-step").find("input#mobileNumber").val();
    if (
      countryName.length === 0 ||
      addressLine.length === 0 ||
      cityName.length === 0 ||
      mobileNumber.length === 0
    ) {
    } else {
      secondStep();
    }
  });
  secondPrevBtn.on("click", function (event) {
    event.preventDefault();
    prevStep();
  });
  thirdBtn.on("click", function (event) {
    event.preventDefault();
    var userName = $("#third-step").find("input#userName").val();
    var passwordNo = $("#third-step").find("input#passwordNo").val();
    var passwordAgain = $("#third-step").find("input#passwordAgain").val();
    // var securityQuote = $("#third-step").find("input#securityQuote").val();

    if (
      userName.length === 0 ||
      passwordNo.length === 0 ||
      passwordAgain.length === 0
      //   ||
      //   securityQuote.length === 0
    ) {
    } else {
      if (passwordAgain !== passwordNo) {
        FormValidation.validatePasswordAgainInput(
          FormValidation.passwordAgain,
          document.getElementById("thirdNext")
        );
      } else {
        console.log("output");
        console.log(
          "FormValidation.handleFormSubmit => ",
          FormValidation.handleFormSubmit
        );
        // FormValidation.RegisterForm.submit();
        FormValidation.handleFormSubmit();
      }
    }
  });
  thirdPrevBtn.on("click", function (event) {
    event.preventDefault();
    secondPrev();
  });
  $(".single-form").each(function () {
    var inputed = false;
    var allValue = $(this).find("input").val();
    var buttonNext = $(this).find(".next");
    $(this)
      .find("input")
      .each(function () {
        $(this).focusin(function () {
          if ($(this).val().length === 0) {
            $(this).siblings("label").addClass("active");
          }
        });
        $(this).focusout(function () {
          if ($(this).val().length === 0) {
            $(this).siblings("label").removeClass("active");
          }
        });
      });
  });
});
