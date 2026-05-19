
'use strict';

// sidebar submenu collapsible js
document.querySelectorAll(".sidebar-menu .dropdown").forEach(function (dropdown) {
  dropdown.addEventListener("click", function () {
    var item = this;

    // Close all sibling dropdowns
    item.parentNode.querySelectorAll(".dropdown").forEach(function (sibling) {
      if (sibling !== item) {
        sibling.querySelector(".sidebar-submenu").style.display = 'none';
        sibling.classList.remove("dropdown-open");
        sibling.classList.remove("open");
      }
    });

    // Toggle the current dropdown
    var submenu = item.querySelector(".sidebar-submenu");
    var isOpen = item.classList.contains("open") || item.classList.contains("dropdown-open");
    
    if (isOpen) {
      submenu.style.display = 'none';
      item.classList.remove("dropdown-open", "open");
    } else {
      submenu.style.display = 'block';
      item.classList.add("dropdown-open", "open");
    }
  });
});

// Toggle sidebar visibility and active class
const sidebarToggle = document.querySelector(".sidebar-toggle");
if(sidebarToggle) {
  sidebarToggle.addEventListener("click", function() {
    this.classList.toggle("active");
    document.querySelector(".sidebar").classList.toggle("active");
    document.querySelector(".dashboard-main").classList.toggle("active");
  });
}

// Open sidebar in mobile view and add overlay
const sidebarMobileToggle = document.querySelector(".sidebar-mobile-toggle");
if(sidebarMobileToggle) {
  sidebarMobileToggle.addEventListener("click", function() {
    document.querySelector(".sidebar").classList.add("sidebar-open");
    document.body.classList.add("overlay-active");
  });
}

// Close sidebar and remove overlay
const sidebarColseBtn = document.querySelector(".sidebar-close-btn");
if(sidebarColseBtn){
  sidebarColseBtn.addEventListener("click", function() {
    document.querySelector(".sidebar").classList.remove("sidebar-open");
    document.body.classList.remove("overlay-active");
  });
}

//to keep the current page active
document.addEventListener("DOMContentLoaded", function () {
  var nk = window.location.href;
  var links = document.querySelectorAll("ul#sidebar-menu a");

  links.forEach(function (link) {
    if (link.href === nk) {
      link.classList.add("active-page"); // anchor
      var parent = link.parentElement;
      parent.classList.add("active-page"); // li

      // Traverse up the DOM tree and add classes to parent elements
      while (parent && parent.tagName !== "BODY") {
        if (parent.tagName === "LI") {
          parent.classList.add("show");
          parent.classList.add("open");
        }
        parent = parent.parentElement;
      }
    }
  });
});




// // On page load or when changing themes, best to add inline in `head` to avoid FOUC
// if (localStorage.getItem('color-theme') === 'light' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: light)').matches)) {
//   document.documentElement.classList.add('light');
// } else {
//   document.documentElement.classList.remove('light')
// }

// // light dark version js
// var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
// var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

// // Change the icons inside the button based on previous settings
// if(themeToggleDarkIcon || themeToggleLightIcon){
//     if (localStorage.getItem('color-theme') === 'light' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: light)').matches)) {
//       themeToggleLightIcon.classList.remove('hidden');
//   } else {
//       themeToggleDarkIcon.classList.remove('hidden');
//   }
// }

// var themeToggleBtn = document.getElementById('theme-toggle');

// if(themeToggleDarkIcon || themeToggleLightIcon || themeToggleBtn){
//   themeToggleBtn.addEventListener('click', function() {

//     // toggle icons inside button
//     themeToggleDarkIcon.classList.toggle('hidden');
//     themeToggleLightIcon.classList.toggle('hidden');

//     // if set via local storage previously
//     if (localStorage.getItem('color-theme')) {
//         if (localStorage.getItem('color-theme') === 'light') {
//             document.documentElement.classList.add('light');
//             localStorage.setItem('color-theme', 'light');
//         } else {
//             document.documentElement.classList.remove('light');
//             localStorage.setItem('color-theme', 'light');
//         }

//     // if NOT set via local storage previously
//     } else {
//         if (document.documentElement.classList.contains('light')) {
//             document.documentElement.classList.remove('light');
//             localStorage.setItem('color-theme', 'light');
//         } else {
// }
// });
// }
// }

// Universal Popup Scroll Locker
function initPopupScrollLocker() {
  const checkPopups = () => {
    const popups = document.querySelectorAll('.popup');
    const hasOpenPopup = Array.from(popups).some(popup => {
      return !popup.classList.contains('hidden') && (popup.style.display !== 'none');
    });
    
    const currentlyActive = document.body.classList.contains('popup-active');
    if (hasOpenPopup !== currentlyActive) {
      if (hasOpenPopup) {
        document.body.classList.add('popup-active');
        document.documentElement.classList.add('popup-active');
      } else {
        document.body.classList.remove('popup-active');
        document.documentElement.classList.remove('popup-active');
      }
    }
  };

  if (window.popupObserver) {
    window.popupObserver.disconnect();
  }

  const observer = new MutationObserver((mutations) => {
    let shouldCheck = false;
    for (let mutation of mutations) {
      if (mutation.type === 'childList') {
        shouldCheck = true;
        break;
      }
      if (mutation.type === 'attributes' && mutation.target !== document.body) {
        shouldCheck = true;
        break;
      }
    }
    if (shouldCheck) {
      checkPopups();
    }
  });

  observer.observe(document.body, {
    childList: true,
    subtree: true,
    attributes: true,
    attributeFilter: ['class', 'style']
  });

  window.popupObserver = observer;

  // Run initial check
  checkPopups();
}

document.addEventListener('DOMContentLoaded', initPopupScrollLocker);
document.addEventListener('livewire:navigated', initPopupScrollLocker);