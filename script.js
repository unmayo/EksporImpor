// Toggle menu active
const navbarNav = document.querySelector(".navbar-nav");
document.querySelector("#menu-menu").onclick = () => {
  navbarNav.classList.toggle("active");
};

//Out from nav
const menu = document.querySelector("#menu-menu");

document.addEventListener("click", function (e) {
  if (!menu.contains(e.target) && !navbarNav.contains(e.target)) {
    navbarNav.classList.remove("active");
  }
});
