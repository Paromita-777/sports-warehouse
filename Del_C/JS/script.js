
// function to change colour of current price to grey if old price is not present
document.addEventListener("DOMContentLoaded", function () {

  /* Change the color of the current price text to grey if there is no old price displayed
  This improves UI clarity by visually distinguishing products without a discount*/
  
  document.querySelectorAll(".product-price").forEach(priceContainer => {
    const currentPrice = priceContainer.querySelector(".current-price");
    const oldPriceSpan = priceContainer.querySelector(".old-price span");

    if (!oldPriceSpan || oldPriceSpan.textContent.trim() === "") {
      currentPrice.style.color = "var(--grey)"; 
    }
  });

});

// hamburger menu toggling 
const toggleBtn = document.querySelector('.toggle-btn');
const toggleBtnIcon = document.querySelector('.toggle-btn i');
const dropDownMenu = document.querySelector('.drop-down-menu');
const menuLabel= document.querySelector('#menu-label');

toggleBtn.onclick = function(){
  dropDownMenu.classList.toggle('open');
  const isOpen = dropDownMenu.classList.contains('open')
  toggleBtnIcon.className = isOpen
  ?"fa-solid fa-xmark"
  :"fa-solid fa-bars";

  // show or hide menu label
  menuLabel.style.display = isOpen? 'none': 'inline';
}

