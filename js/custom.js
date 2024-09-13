// forms code

const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');
const btnPopup = document.querySelector('.btnLogin-popup');
const iconCLose = document.querySelector('.icon-close');

 // Wait until the DOM is fully loaded
 document.addEventListener('DOMContentLoaded', function () {
  // Select the profile and menu elements
  let profile = document.querySelector('.profile');
  let menu1 = document.querySelector('.menu1');

  // Check if both elements are found
  if (profile && menu1) {
      // Toggle the 'active' class on the menu when the profile is clicked
      profile.onclick = function () {
          menu1.classList.toggle('active');
      };
  } else {
      console.error("Profile or menu element not found!");
  }
});



registerLink.addEventListener('click', () => {
  wrapper.classList.add('active');
});

loginLink.addEventListener('click', () => {
  wrapper.classList.remove('active');
});

btnPopup.addEventListener('click', () => {
  wrapper.classList.add('active-popup');
});

iconCLose.addEventListener('click', () => {
  wrapper.classList.remove('active-popup');
});





  (function ($) {
  
  "use strict";

    // MENU
    $('.navbar-collapse a').on('click',function(){
      $(".navbar-collapse").collapse('hide');
    });
    
    // CUSTOM LINK
    $('.smoothscroll').click(function(){
      var el = $(this).attr('href');
      var elWrapped = $(el);
      var header_height = $('.navbar').height();
  
      scrollToDiv(elWrapped,header_height);
      return false;
  
      function scrollToDiv(element,navheight){
        var offset = element.offset();
        var offsetTop = offset.top;
        var totalScroll = offsetTop-0;
  
        $('body,html').animate({
        scrollTop: totalScroll
        }, 300);
      }
    });

    $('.owl-carousel').owlCarousel({
        center: true,
        loop: true,
        margin: 30,
        autoplay: true,
        responsiveClass: true,
        responsive:{
            0:{
                items: 2,
            },
            767:{
                items: 3,
            },
            1200:{
                items: 4,
            }
        }
    });
  
  })(window.jQuery);


  // filter code


  // Filtering by category
const filterButtons = document.querySelectorAll('.filter-button');
const items = document.querySelectorAll('.itemvid');

filterButtons.forEach((button) => {
    button.addEventListener('click', () => {
        const selectedCategory = button.dataset.category;

        items.forEach((item) => {
            if (selectedCategory === 'all') {
                item.classList.remove('hide');
                item.style.display = 'block';
            } else if (item.dataset.category === selectedCategory) {
                item.classList.remove('hide');
                item.style.display = 'block';
            } else {
                item.classList.add('hide');
                item.style.display = 'none';
            }
        });
    });
});

// Search functionality
const searchBar = document.getElementById("searchBar");
const listItems = document.querySelectorAll(".video-fil");

searchBar.addEventListener('keyup', function() {
    const searchValue = searchBar.value.toLowerCase();

    listItems.forEach((item) => {
        if (item.innerHTML.toLowerCase().includes(searchValue)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});
//search functionality ends here

// top header


  
// end

