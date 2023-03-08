/**
 * Transform une chaîne en élément DOM
 * @param {string} str
 * @return {DocumentFragment}
 */
export function strToDom(str) {
    return document.createRange().createContextualFragment(str).firstChild;
}


/**
 * @param e
 * @param {HTMLElement} target
 * @returns {*}
 */
export const isTarget = (e, target) => {
    return e.composedPath().includes(target)
}