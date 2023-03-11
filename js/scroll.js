let myTop = document.getElementById('myTop')
let myIntro = document.getElementById('myIntro')

// Change style of top container on scroll
window.onscroll = function() {
  if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
      myTop.classList.add("w3-card-4", "w3-animate-opacity");
      myIntro.classList.add("w3-show-inline-block");
  }else{
          myIntro.classList.remove("w3-show-inline-block");
          myTop.classList.remove("w3-card-4", "w3-animate-opacity");
        }
 }