var siedzenia = document.querySelectorAll(".miejsca");

siedzenia.forEach((div)=> {
    if(!div.classList.contains('disabled')) {
        div.addEventListener("click", ()=> {
            zmienKolor(div);
        });
    }
});



const wybraneMiejsca = [];
function zmienKolor(element) {
    const rzad = parseInt(element.getAttribute("data-rzad"), 10);
    const miejsce = parseInt(element.getAttribute("data-miejsce"), 10);
    const miejsceId = (rzad - 1) * 10 + miejsce;

    if (element.getAttribute("data-check") == 0) {
        element.setAttribute("data-check", 1);
        element.style.backgroundColor = "rgba(175,15,140,1)";
        element.textContent = miejsceId;

        wybraneMiejsca.push(miejsceId);
    } else {
        element.setAttribute("data-check", 0);
        element.style.backgroundColor = "rgba(59, 253, 220, 1)";
        element.textContent = "";

        const indexToRemove = wybraneMiejsca.indexOf(miejsceId);
        if (indexToRemove !== -1) {
            wybraneMiejsca.splice(indexToRemove, 1);
        }
    }

    const wybraneMiejscaValues = wybraneMiejsca.join(',');
    document.getElementById('wybraneMiejsca').value = wybraneMiejscaValues;
}







