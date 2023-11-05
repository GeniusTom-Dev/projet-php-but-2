let registerInput = document.querySelector("#mainPasswordInput")
let passwordStrengthText = document.querySelector("#passwordStrengthText")
let ticks = document.querySelectorAll(".tick")

registerInput.addEventListener("input", () => {
    let password = registerInput.value
    let passwordStrength = zxcvbn(password);
    let colorList = ["bg-transparent", "bg-red-400", "bg-orange-400", "bg-yellow-400", "bg-green-400"]
    console.log(password,passwordStrength.score)

    for (let i = 0; i < ticks.length; i++) {
        for (let j = 0; j < colorList.length; j++) {
            ticks[i].classList.remove(colorList[j])
        }
    }

    passwordStrengthText.textContent = "Complexitée du mot de passe :"


    switch (passwordStrength.score) {
        case 1:
            ticks[0].classList.add(colorList[passwordStrength.score])
            passwordStrengthText.textContent = "Complexitée du mot de passe : Faible"
            break;
        case 2:
            passwordStrengthText.textContent = "Complexitée du mot de passe : Moyen"
            ticks[0].classList.add(colorList[passwordStrength.score])
            ticks[1].classList.add(colorList[passwordStrength.score])
            break;
        case 3:
            passwordStrengthText.textContent = "Complexitée du mot de passe : Convenable"
            ticks[0].classList.add(colorList[passwordStrength.score])
            ticks[1].classList.add(colorList[passwordStrength.score])
            ticks[2].classList.add(colorList[passwordStrength.score])
            break;
        case 4:
            passwordStrengthText.textContent = "Complexitée du mot de passe : Fort"
            ticks[0].classList.add(colorList[passwordStrength.score])
            ticks[1].classList.add(colorList[passwordStrength.score])
            ticks[2].classList.add(colorList[passwordStrength.score])
            ticks[3].classList.add(colorList[passwordStrength.score])
            break;
    }
})