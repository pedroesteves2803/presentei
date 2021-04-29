const abrirLogin = document.querySelector("#abrir")
const modal = document.querySelector("#modal")
const fecharLogin = document.querySelector("#fechar")

abrirLogin.addEventListener("click", () =>{
    modal.classList.romove("hide")
})

fecharLogin.addEventListener("click", () =>{
    modal.classList.add("hide")
})