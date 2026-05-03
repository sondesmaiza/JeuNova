document.addEventListener('DOMContentLoaded', function() {
    // Animation des compteurs
    const counters = document.querySelectorAll('.counter-value');
    const speed = 150;
    
    const animateCounter = (counter) => {
        const target = +counter.getAttribute('data-target');
        let count = 0;
        const updateCounter = () => {
            const increment = target / speed;
            if(count < target) {
                count = Math.ceil(count + increment);
                if(count > target) count = target;
                counter.innerText = count;
                setTimeout(updateCounter, 20);
            } else {
                counter.innerText = target;
            }
        };
        updateCounter();
    };
    
    const observerCounters = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                animateCounter(entry.target);
                observerCounters.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });
    
    counters.forEach(counter => observerCounters.observe(counter));
    
    // Animation d'apparition "fade-up"
    const fadeElements = document.querySelectorAll('.fade-up');
    const fadeObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                entry.target.classList.add('appeared');
                fadeObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    fadeElements.forEach(el => fadeObserver.observe(el));
    
    // Validation formulaire contact
    const contactForm = document.getElementById('contactForm');
    if(contactForm) {
        contactForm.addEventListener('submit', function(e) {
            let valid = true;
            const inputs = this.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                if(!input.value.trim()) {
                    input.classList.add('is-invalid');
                    valid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            const email = document.querySelector('input[name="email"]');
            if(email && email.value && !email.value.includes('@')) {
                email.classList.add('is-invalid');
                valid = false;
            }
            if(!valid) {
                e.preventDefault();
                alert('Veuillez remplir tous les champs correctement.');
            }
        });
    }
});