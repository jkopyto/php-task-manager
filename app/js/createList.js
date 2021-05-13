const createListFunc = () => {
    const container = document.querySelector(".list-container")

    if(container) {
        const advantages = ["Nie zapomnisz niczego", "Regularność i systematyczność", "Więcej wolnego czasu", "Konsekwencja w realizacji celów"]

        const arrayOfListItems = advantages.map(adv => {
            const el = document.createElement("li")
            el.innerHTML = adv
            return el
        })
        const unorderedListContainer = document.createElement("ul")

        let i = 0

        while(i < arrayOfListItems.length) {
            unorderedListContainer.appendChild(arrayOfListItems[i])
            i++
        }
        
        container.appendChild(unorderedListContainer)
    } else {
        throw new Error("Missing list container")
    }

    this.removeEventListener("load", createListFunc)
}

window.addEventListener("load", createListFunc)