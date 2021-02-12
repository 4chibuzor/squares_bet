function DerrickInsertAfter(newNode, referenceNode) {
  referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}

window.addEventListener("DOMContentLoaded", function () {
  var derrickRegister = {
    createElement(tag, content, attributes) {
      let element = document.createElement(tag);
      for (const key in attributes) {
        element.setAttribute(key, attributes[key]);
      }
      element.textContent = content;
      return element;
    },
  };
  let derrickModalStyle = derrickRegister.createElement("link", null, {
    href: "/derrick/assets/css/modal.css",
  });
  let registerStyle = derrickRegister.createElement("link", null, {
    href: "/derrick/assets/css/register-page-responsive.css",
  });
  let registerScript = derrickRegister.createElement("script", null, {
    src: "/derrick/assets/js/step-signup.js",
  });
  document.head.appendChild(registerStyle);
  document.body.appendChild(registerScript);
  //insert the modal style and registerpage responsive style
  DerrickInsertAfter(derrickModalStyle, registerStyle);
});
