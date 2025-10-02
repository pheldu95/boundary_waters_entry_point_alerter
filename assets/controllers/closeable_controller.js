import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["sidebar", "toggleButton"]
    static classes = ["open"]
    
    connect() {
        //Store the initial width
        this.originalWidth = this.sidebarTarget.offsetWidth + 'px';
        this.sidebarTarget.style.width = this.originalWidth;
        this.isOpen = true;
    }

    async close() {
        this.sidebarTarget.style.width = '0';
        this.sidebarTarget.style.padding = '0';
        this.sidebarTarget.style.borderWidth = '0';
        
        await this.#waitForAnimationEnd();
        
        //Show and animate the burger button
        if (this.hasToggleButtonTarget) {
            this.toggleButtonTarget.classList.remove('hidden');
            this.isOpen = false;
        }
    }

    open() {
        this.sidebarTarget.style.width = this.originalWidth;
        this.sidebarTarget.style.padding = '';
        this.sidebarTarget.style.borderWidth = '';
        
        //Hide the burger button
        if (this.hasToggleButtonTarget) {
            this.toggleButtonTarget.classList.add('hidden');
            this.isOpen = true;
        }
    }

    toggle() {
        if (this.isOpen) {
            this.close();
        } else {
            this.open();
        }
    }

    #waitForAnimationEnd() {
        return Promise.all(
            this.sidebarTarget.getAnimations().map((animation) => animation.finished),
        );
    }
}