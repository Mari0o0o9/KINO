function rotacja() {
    const logo = document.getElementById("logo")
    const zdjecie = document.getElementById("kino")
    logo.onmouseenter = function () {
        zdjecie.style = "animation: rotacja1; animation-duration: 1s; animation-fill-mode: forwards;"
    }
    logo.onmouseleave = function () {
        zdjecie.style = "animation: rotacja2; animation-duration: 1s; animation-fill-mode: forwards;"
    }
}
rotacja()