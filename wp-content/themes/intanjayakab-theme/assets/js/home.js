document.addEventListener('DOMContentLoaded', function () {
  var btn = document.querySelector('.classic-btn[data-toggle="more-services"]');
  var more = document.getElementById('more-services');
  if (!btn || !more) return;
  btn.addEventListener('click', function (e) {
    e.preventDefault();
    var open = more.classList.toggle('is-open');
    if (open) {
      more.style.display = 'flex';
      more.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
      more.style.display = 'none';
    }
  });
});
