const cards = document.querySelectorAll(".displayed_cards");
const descs = document.querySelectorAll(".hide-desc");

document.addEventListener("DOMContentLoaded", () =>{
    cards.forEach(card => card.addEventListener(
        "click",
        (e) => {
            let src = e.target.getAttribute("data-card")
            e.target.classList.add("shown_card")
            setTimeout(() => {
                e.target.src = src
            }, 450)
            setTimeout(() => {
                    descs.forEach(item => 
                    {
                        if(item.getAttribute("data-card") == src){
                            item.classList.remove("hide-desc")
                        }
                    }
                    )
            }, 1000)
        }
    ))
})