import {isTarget} from "../functions/dom";

export class ConfirmBtn {
    /**
     * @param {HTMLLinkElement|HTMLButtonElement} el
     */
    constructor(el) {
        this.button = el
        this.message = this.button.dataset.confirm
        this.clickCount = 0
        this.textContainer = this.button.querySelector("[data-confirm-replace]")
        this.orgiginalText = this.textContainer.textContent
        this.button.addEventListener("click", this.handleClick)
    }


    handleClick = (e) => {
        if(this.clickCount === 0) {
            e.preventDefault()
            this.button.classList.add("confirm")
            this.textContainer.textContent = this.message
            this.clickCount++
            document.addEventListener("click", this.handleDocClick)
        }
    }

    reset() {
        this.textContainer.textContent = this.orgiginalText
        this.button.classList.remove("confirm")
        this.clickCount = 0
    }

    handleDocClick = (e) => {
        if(!isTarget(e, this.button)) {
            this.reset()
            document.removeEventListener("click", this.handleDocClick)
        }
    }





}
