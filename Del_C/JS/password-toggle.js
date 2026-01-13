//  Toggle input type between 'password' and 'text'
document.querySelectorAll(".toggle-password").forEach(icon => {

    icon.addEventListener("click", () => {
      // Get the ID of the associated password input from the icon's data-target attribute
      const inputId = icon.dataset.target;

      // Use that ID to select the corresponding input element
      const passwordInput = document.getElementById(inputId);

      // Toggle input type between 'password' and 'text'
      if (passwordInput.type === "password") {
        passwordInput.type = "text"; // Show the password
        icon.classList.remove("fa-eye"); // Swap eye icon
        icon.classList.add("fa-eye-slash");
      } else {
        passwordInput.type = "password"; // Hide the password
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    });
  });