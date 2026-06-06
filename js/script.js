document.addEventListener("DOMContentLoaded", function () {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible");
            }
        });
    }, {
        threshold: 0.1 // Adjusts how much of the element must be visible to trigger
    });

    const quoteElements = document.querySelectorAll('.quote, .quote-source');
    quoteElements.forEach(el => observer.observe(el));
});

document.addEventListener("DOMContentLoaded", function () {
    const fadeUpElements = document.querySelectorAll(".fade-up");

    function handleScroll() {
        fadeUpElements.forEach(el => {
            const rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight - 100) {
                el.classList.add("visible");
            }
        });
    }

    window.addEventListener("scroll", handleScroll);
    handleScroll();
});
