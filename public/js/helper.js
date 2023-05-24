const displaySnackbar = (message, type) => {
    const currentPaddingBottom = ($(window).width() < 640) ? "6rem" : "0.75rem"
    const snackbar = document.querySelector(".snackbar")
    let symbol

    switch (type) {
    case "error":
        symbol = "cancel"
        snackbar.classList.add("animate-shake")
        break
    case "success":
        symbol = "check_circle"
        break
    case "warning":
        symbol = "error"
        break
    }

    snackbar.querySelector("div").className = ""
    snackbar.querySelector("div").classList.add(type)
    //snackbar.querySelector('.material-symbols-outlined').innerHTML = symbol
    snackbar.querySelector(".text").innerHTML = message
    snackbar.style.display = "flex"

    $(snackbar).animate({
        opacity: 1,
        paddingBottom: currentPaddingBottom
    }, 300, () => {
        $(snackbar).delay(3000).animate({
            opacity: 0,
            paddingBottom: 0
        }, 300, () => {
            snackbar.style.display = "none"
            snackbar.classList.remove("animate-shake")
        })
    })
}

const formatDateISO = (date) => {
    date = date.split("/")

    return `${date[2]}-${date[1]}-${date[0]}`
}

const formatDateTimeISO = (date) => {
    let hour
    date = date.split(" ")
    hour = date[1]
    date = date[0]
    date = date.split("/")

    return `${date[2]}-${date[1]}-${date[0]} ${hour}`
}

const formatNumberISO = (number) => {
    if (!number) return 0

    number = number.replace("R$ ", "")
    return parseFloat((number.replace(".", "")).replace(",", "."))
}

const extractOnlyNumbers = (number) => {
    if (!number) return ""

    number = number.match(/\d/g)
    return number.join("")
}

const formatarParaReais = (numero) => {
    let parteInteira = parseInt(numero).toLocaleString("pt-BR")
    let parteDecimal = (numero % 1).toFixed(2).substring(2)

    return `R$ ${parteInteira},${parteDecimal}`
}
