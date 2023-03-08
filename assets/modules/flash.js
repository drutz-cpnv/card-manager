import {strToDom} from "../functions/dom";

export default class Flash {

    /**
     * @param {HTMLDivElement|object} element
     */
    constructor(element) {
        if(typeof element === "object" && element.classList === undefined){
            console.log("Ceci n'est pas une div")
            return
        }
        else {
            this.flash = element
            this.data = {
                content: this.flash.dataset.content,
                title: this.flash.dataset.title === '' ? null : this.flash.dataset.title,
                duration: this.flash.dataset.duration === '' ? 5000 : parseInt(this.flash.dataset.duration, 10),
            }
        }

        this.init()
    }

    createElement() {
        return strToDom(`<div class="flash" id="${flash.id}" data-flash data-title="${ flash.title ?? "" }" data-content="${ flash.content }" data-duration="${ flash.duration ?? "" }">
                    <span>${ flash.content }</span>
                </div>`)
    }

    init() {
        let timeout = setTimeout(this.close, this.data.duration)
        this.flash.addEventListener("mouseenter", (e) => {
            clearTimeout(timeout)
        })
        this.flash.addEventListener("mouseleave", (e) => {
            timeout = setTimeout(this.close, this.data.duration)
        })
    }

    close = () => {
        this.flash.style.transform = "translateY(-300px)"
        this.flash.style.transitionDuration = ".3s"

        setTimeout(() => {
            this.flash.remove()
        }, 400)
    }

}