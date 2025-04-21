document.addEventListener("DOMContentLoaded", function () {
  const menuBtn = document.getElementById("menu-btn");
  const menu = document.getElementById("menu-site");
  const menuIcon = document.getElementById("menu-icon");

  menuBtn.addEventListener("click", function () {
    menu.classList.toggle("active");
    menuIcon.classList.toggle("active");
  });

  const links = menu.querySelectorAll("a");
  links.forEach(link => {
    link.addEventListener("click", () => {
      menu.classList.remove("active");
      menuIcon.classList.remove("active");
    });
  });
});
