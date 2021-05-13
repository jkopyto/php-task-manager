const toast = (message, type) => {
    const toastsContainer = document.querySelector(".toasts-container")

	if(!toastsContainer) {
		throw new Error("Missing container")
	}

	const toastEl = document.createElement("div")
    toastEl.classList.add("toast", `toast--${type}`)

	const toastWrap = document.createElement("div")
	toastWrap.classList.add("toast--wrap")
    toastWrap.innerHTML = message
	
	toastEl.appendChild(toastWrap)
	toastsContainer.appendChild(toastEl)
	
	const tl = gsap.timeline()

	tl.to(toastEl, {
		autoAlpha: 1,
		y: 0,
		ease: "power4.out",
		duration: .4,
	})

	tl.to(toastEl, {
		height: 0,
		marginBottom: 0,
		autoAlpha: 0,
		duration: .5,
		delay: 2,
		ease: "power4.out",
		onComplete: () => {
			toastEl.parentNode.removeChild(toastEl)
		}
	})
}

 
const displayToast = function(messageToDisplay, type = "success") {
    toast(messageToDisplay, type)
}
