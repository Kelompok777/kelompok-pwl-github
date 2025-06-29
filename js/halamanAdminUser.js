document.addEventListener('DOMContentLoaded', function () {
    fetchJumlahLaporan();
});

function fetchJumlahLaporan() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "halamanAdmin.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            const jumlah = response.laporan > 99 ? "99+" : response.laporan;
            document.getElementById('jumlahLaporan').innerText = jumlah;
        } else {
            document.getElementById('jumlahLaporan').innerText = "ERR";
        }
    };
    xhr.onerror = function () {
        document.getElementById('jumlahLaporan').innerText = "ERR";
    };
    xhr.send();
}
