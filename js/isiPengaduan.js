function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("active");
}

function navigateTo(url) {
    window.location.href = url;
}

function logout() {
    alert("Anda telah logout.");
    window.location.href = "login.html";
}
