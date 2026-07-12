// ===== Dark Mode Toggle =====
const darkModeBtn = document.querySelector("#darkModeBtn");

darkModeBtn.addEventListener("click", function (e) {
  e.preventDefault();
  document.body.classList.toggle("dark");

  if (document.body.classList.contains("dark")) {
    darkModeBtn.textContent = "Switch to Light Mode";
  } else {
    darkModeBtn.textContent = "Toggle Dark Mode";
  }
});

// ===== Live Greeting (extra feature) =====
const visitorName = document.querySelector("#visitorName");
const greetingOutput = document.querySelector("#greetingOutput");

visitorName.addEventListener("input", function (e) {
  const name = e.target.value.trim();
  if (name !== "") {
    greetingOutput.textContent = `Hey there, ${name}! Thanks for stopping by.`;
  } else {
    greetingOutput.textContent = "";
  }
});

// ===== Click Counter =====
const incrementBtn = document.querySelector("#incrementBtn");
const resetBtn = document.querySelector("#resetBtn");
const clickTotal = document.querySelector("#clickTotal");

let clickCount = 0;

incrementBtn.addEventListener("click", function () {
  clickCount++;
  clickTotal.textContent = clickCount;
});

resetBtn.addEventListener("click", function () {
  clickCount = 0;
  clickTotal.textContent = clickCount;
});

// ===== Form Validation =====
const contactForm = document.querySelector("#contactForm");
const userName = document.querySelector("#userName");
const userEmail = document.querySelector("#userEmail");
const nameError = document.querySelector("#nameError");
const emailError = document.querySelector("#emailError");
const formSuccess = document.querySelector("#formSuccess");

contactForm.addEventListener("submit", function (e) {
  e.preventDefault();

  nameError.textContent = "";
  emailError.textContent = "";
  formSuccess.textContent = "";

  let isValid = true;

  if (userName.value.trim() === "") {
    nameError.textContent = "Name cannot be empty.";
    isValid = false;
  }

  if (!userEmail.value.includes("@")) {
    emailError.textContent = "Please enter a valid email address.";
    isValid = false;
  }

  if (isValid) {
    formSuccess.textContent = `Thanks, ${userName.value.trim()}! Your message was received.`;
    contactForm.reset();
  }
});
