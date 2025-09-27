// quick-menu.js
const quickMenuBtn = document.getElementById('quickMenuBtn');
const quickMenu = document.getElementById('quickMenu');

quickMenuBtn.addEventListener('click', () => {
  const isActive = quickMenu.classList.toggle('active'); // toggle menu visibility
  quickMenuBtn.setAttribute('aria-expanded', isActive); // accessibility
  quickMenu.setAttribute('aria-hidden', !isActive);
});


