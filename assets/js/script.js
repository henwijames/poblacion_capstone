const navLinks = document.getElementById("nav-links");

function onToggleMenu(e) {
  e.classList.toggle("fa-bars");
  e.classList.toggle("fa-times");

  if (navLinks.classList.contains("top-0")) {
    // If it's visible, hide it
    navLinks.classList.remove("top-0");
    navLinks.style.top = "-120%"; // Move back off-screen
  } else {
    // If it's hidden, show it
    navLinks.classList.add("top-0");
    navLinks.style.top = "0"; // Move into view
  }
}
