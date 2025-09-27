
// Apply right-click + image protection globally
document.addEventListener("DOMContentLoaded", () => {
  document.addEventListener("contextmenu", event => event.preventDefault());

  document.querySelectorAll("img").forEach(img => {
    img.addEventListener("dragstart", e => e.preventDefault());
    img.addEventListener("touchstart", e => e.preventDefault(), { passive: false });
  });
});


