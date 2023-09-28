let card = document.querySelector(".card");
let defaultPosX = null;
let isDraggable = false;

card.addEventListener("mousedown", (e) => {
    isDraggable = true
    defaultPosX = e.clientX
})
document.addEventListener("mouseup", (e) => {
    if(isDraggable){
        isDraggable = false
        defaultPosX = null
        card.style.left = "50%"
        card.style.rotate = "0deg"
    }
    console.log(isDraggable)
})

// card.addEventListener("mouseleave", () => {
//     defaultPosX = null;
//     isDraggable = false;
//     card.style.left = "50%"
//     card.style.rotate = "0deg"
// })

document.addEventListener("mousemove", (e) => {
    if(isDraggable === false) return;

    let movePos = e.clientX - defaultPosX
    card.style.left = "calc(50% + " + movePos + "px)"
    card.style.rotate = movePos / 10 + "deg"


})



