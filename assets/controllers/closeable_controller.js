import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["sidebar", "toggleButton"]
    
    connect() {
        // Store the initial width
        this.originalWidth = this.sidebarTarget.offsetWidth + 'px';
        this.sidebarTarget.style.width = this.originalWidth;
    }

    async close() {
        this.sidebarTarget.style.width = '0';
        this.sidebarTarget.style.padding = '0';
        this.sidebarTarget.style.borderWidth = '0';
        
        await this.#waitForAnimationEnd();
        
        // Show the burger button
        if (this.hasToggleButtonTarget) {
            this.toggleButtonTarget.classList.remove('hidden');
        }
    }

    open() {
        this.sidebarTarget.style.width = this.originalWidth;
        this.sidebarTarget.style.padding = '';
        this.sidebarTarget.style.borderWidth = '';
        
        // Hide the burger button
        if (this.hasToggleButtonTarget) {
            this.toggleButtonTarget.classList.add('hidden');
        }
    }

    #waitForAnimationEnd() {
        return Promise.all(
            this.sidebarTarget.getAnimations().map((animation) => animation.finished),
        );
    }
}