document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('live-search-input');
    const resultsBox = document.getElementById('live-search-results');
    const popup = document.querySelector('.popup-search-box');
    const closeBtn = document.querySelector('.searchClose');

    let typingTimer = null;

    if (!input || !resultsBox) return;

    // 🔹 Reset results
    function resetResults() {
        resultsBox.innerHTML = '';
        resultsBox.style.display = 'none';
    }

    // 🔹 Input typing
    input.addEventListener('input', function () {
        const query = this.value.trim();
        clearTimeout(typingTimer);

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
                                <img src="/admin/images/products/${product.image}" />
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

    // 🔹 Focus = allow new search
    input.addEventListener('focus', function () {
        if (this.value.length < 2) {
            resetResults();
        }
    });

    // 🔹 ESC key = close popup + reset
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            popup?.classList.remove('show');
            resetResults();
            input.value = '';
        }
    });

    // 🔹 Close button
    closeBtn?.addEventListener('click', function () {
        resetResults();
        input.value = '';
    });

    // 🔹 Click outside results → hide dropdown
    document.addEventListener('click', function (e) {
        if (!resultsBox.contains(e.target) && e.target !== input) {
            resetResults();
        }
    });

});
