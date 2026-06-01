let c = 0;

function show(n) {
    const s = document.querySelectorAll('.slide');
    if (!s.length) return;
    s[c].classList.remove('active');
    c = (n + s.length) % s.length;
    s[c].classList.add('active');
}

function nextSlide() { show(c + 1); }
function prevSlide() { show(c - 1); }

setInterval(nextSlide, 3000);