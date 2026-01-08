document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('live-search-input');
    const resultsBox = document.getElementById('live-search-results');
    const popup = document.querySelector('.popup-search-box');
    const closeBtn = document.querySelector('.searchClose');

    let typingTimer = null;
    let activeIndex = -1;

    if (!input || !resultsBox) return;

    function resetResults() {
        resultsBox.innerHTML = '';
        resultsBox.style.display = 'none';
        activeIndex = -1;
    }

    function setActive(items) {
        items.forEach(item => item.classList.remove('active'));
        if (items[activeIndex]) {
            items[activeIndex].classList.add('active');
        }
    }

    // 🔹 Typing
    input.addEventListener('input', function () {
        const query = this.value.trim();
        clearTimeout(typingTimer);
        activeIndex = -1;

        if (query.length < 2) {
            resetResults();
            return;
        }

        typingTimer = setTimeout(() => {
            fetch(`/ajax/search-products?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {

                    if (!data.length) {
                        resultsBox.innerHTML =
                            '<div class="no-result">No products found</div>';
                        resultsBox.style.display = 'block';
                        return;
                    }

                    let html = '';
                    data.forEach(product => {
                        html += `
                            <a href="/product/${product.slug}" class="live-search-item">
                                <img src="/admin/images/products//${product.image}" />
                                <div>
                                    <strong>${product.name}</strong><br>
                                    <span>₹${product.price}</span>
                                </div>
                            </a>
                        `;
                    });

                    resultsBox.innerHTML = html;
                    resultsBox.style.display = 'block';
                });
        }, 300);
    });

    // 🔹 Keyboard navigation
    input.addEventListener('keydown', function (e) {
        const items = resultsBox.querySelectorAll('.live-search-item');
        if (!items.length) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            activeIndex = (activeIndex + 1) % items.length;
            setActive(items);
        }

        if (e.key === 'ArrowUp') {
            e.preventDefault();
            activeIndex = (activeIndex - 1 + items.length) % items.length;
            setActive(items);
        }

        if (e.key === 'Enter' && activeIndex >= 0) {
            e.preventDefault();
            window.location.href = items[activeIndex].href;
        }
    });

    // 🔹 ESC key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            popup?.classList.remove('show');
            input.value = '';
            resetResults();
        }
    });

    // 🔹 Close button
    closeBtn?.addEventListener('click', function () {
        input.value = '';
        resetResults();
    });

    // 🔹 Click outside
    document.addEventListener('click', function (e) {
        if (!resultsBox.contains(e.target) && e.target !== input) {
            resetResults();
        }
    });

});
