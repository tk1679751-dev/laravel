import './bootstrap';

import Alpine from 'alpinejs';

// Dark mode Alpine component
window.darkMode = function() {
    return {
        isDark: false,
        
        init() {
            // Check current DOM state first
            this.isDark = document.documentElement.classList.contains('dark');
            
            // If no class is set, check for saved preference or system preference
            if (!this.isDark) {
                const savedMode = localStorage.getItem('darkMode');
                const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                
                this.isDark = savedMode === 'true' || (savedMode === null && systemPrefersDark);
            }
            
            this.updateDOM();
        },
        
        toggle() {
            this.isDark = !this.isDark;
            this.updateDOM();
            localStorage.setItem('darkMode', this.isDark);
        },
        
        updateDOM() {
            if (this.isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    }
}

window.Alpine = Alpine;

Alpine.start();
