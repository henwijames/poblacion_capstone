function onToggleMenu(e) {
  let list = document.getElementById("menu");

  if (e.classList.contains("fa-bars")) {
    e.classList.replace("fa-bars", "fa-times");
    list.classList.add("top-[70px]", "opacity-100");
  } else {
    e.classList.replace("fa-times", "fa-bars");
    list.classList.remove("top-[70px]", "opacity-100");
  }
}
