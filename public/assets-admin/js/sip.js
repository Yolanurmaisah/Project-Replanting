// Buka/tutup sidebar pada layar kecil
(function () {
    var side = document.getElementById('side');
    var tombol = document.getElementById('tgl');
    var main = document.querySelector('.main');
    if (!side || !tombol) return;

    tombol.addEventListener('click', function () {
        side.classList.toggle('open');
    });

    if (main) {
        main.addEventListener('click', function (e) {
            if (tombol.contains(e.target)) return;
            side.classList.remove('open');
        });
    }
})();
