import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        // Store the initial width
        this.originalWidth = this.element.offsetWidth + 'px';
        this.element.style.width = this.originalWidth;
    }

    async close () {
        this.element.style.width = '0'; //first set width to 0 to trigger transition

        await this.#waitForAnimationEnd(); //wait for the animation to finish
        this.element.remove(); //then remove the element entirely
    }

    #waitForAnimationEnd() {
        return Promise.all(
            this.element.getAnimations().map((animation) => animation.finished),
        );
    }
}