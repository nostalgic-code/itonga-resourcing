// Filter Function
const sortBtns = document.querySelectorAll(".job-id > *");
const sortItems = document.querySelectorAll(".jobs-container > *");

sortBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    sortBtns.forEach((btn) => btn.classList.remove("active"));
    btn.classList.add("active");

    const targetData = btn.getAttribute("data-target");

    sortItems.forEach((item) => {
      item.classList.add("delete");
      if (
        item.getAttribute("data-item") === targetData ||
        targetData === "all"
      ) {
        item.classList.remove("delete");
      }
    });
  });
});

// Contact

// document
//   .getElementById("contact-form")
//   .addEventListener("submit", function (event) {
//     event.preventDefault();
//     var form = event.target;
//     var formData = new FormData(form);

//     var xhr = new XMLHttpRequest();
//     xhr.open("POST", form.action, true);
//     xhr.onreadystatechange = function () {
//       if (xhr.readyState === XMLHttpRequest.DONE) {
//         if (xhr.status === 200) {
//           form.reset();
//           document.getElementById("status").innerHTML =
//             "Message sent successfully!";
//         } else {
//           document.getElementById("status").innerHTML =
//             "Oops! Something went wrong.";
//         }
//       }
//     };
//     xhr.send(formData);
//   });
