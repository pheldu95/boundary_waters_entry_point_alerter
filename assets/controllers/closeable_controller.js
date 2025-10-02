import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["sidebar", "toggleButton", "burgerIcon", "closeIcon"]
    
    connect() {
    // Set the width we want when open
    this.originalWidth = '411px';
    
    // Start closed (already set in HTML)
    this.isOpen = false;
    this.updateIcon();
}

    async close() {
        this.sidebarTarget.style.width = '0';
        this.sidebarTarget.style.padding = '0';
        this.sidebarTarget.style.borderWidth = '0';
        
        await this.#waitForAnimationEnd();
        
        this.isOpen = false;
        this.updateIcon();
    }

    open() {
        this.sidebarTarget.style.width = this.originalWidth;
        this.sidebarTarget.style.padding = '0 2rem';
        this.sidebarTarget.style.borderWidth = '';
        
        this.isOpen = true;
        this.updateIcon();
    }

    toggle() {
        if (this.isOpen) {
            this.close();
        } else {
            this.open();
        }
    }

    updateIcon() {
        if (this.isOpen) {
            // Show X, hide burger
            this.burgerIconTarget.classList.add('hidden');
            this.closeIconTarget.classList.remove('hidden');
        } else {
            // Show burger, hide X
            this.burgerIconTarget.classList.remove('hidden');
            this.closeIconTarget.classList.add('hidden');
        }
    }

    #waitForAnimationEnd() {
        return Promise.all(
            this.sidebarTarget.getAnimations().map((animation) => animation.finished),
        );
    }
}