function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("active");
}

function navigate(url) {
    window.location.href = url;
}

function logout() {
    alert("Anda telah logout.");
    window.location.href = "login.html";
}

document.addEventListener("DOMContentLoaded", () => {
    fetch("get_laporan.php")
        .then(res => res.json())
        .then(data => {
            const tbody = document.querySelector("#laporanTable tbody");
            tbody.innerHTML = "";

            data.forEach((laporan, index) => {
                const row = document.createElement("tr");
                row.innerHTML = `
          <td>${index + 1}</td>
          <td>${laporan.kategori}</td>
          <td>${laporan.jenis}</td>
          <td>${laporan.nama}</td>
          <td>${laporan.email}</td>
          <td>${laporan.hp}</td>
          <td>${laporan.wilayah}</td>
          <td>${laporan.isi_laporan}</td>
          <td><a href="files/${laporan.bukti}" target="_blank">Lihat</a></td>
          <td class="action-buttons">
            <i class="edit" onclick="editLaporan(${laporan.id})">✏️</i>
            <i class="delete" onclick="deleteLaporan(${laporan.id})">🗑️</i>
          </td>
        `;
                tbody.appendChild(row);
            });
        });
});

function editLaporan(id) {
    alert("Edit laporan ID: " + id);
    // implementasi edit sesuai kebutuhan
}

function deleteLaporan(id) {
    if (confirm("Yakin ingin menghapus laporan ini?")) {
        fetch(`delete_laporan.php?id=${id}`, { method: "GET" })
            .then(res => res.text())
            .then(msg => {
                alert(msg);
                location.reload();
            });
    }
}
