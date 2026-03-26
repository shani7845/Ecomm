document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('live-search-input');
    const resultsBox = document.getElementById('live-search-results');
    const popup = document.querySelector('.popup-search-box');
    const closeBtn = document.querySelector('.searchClose');
    const toggler = document.querySelector('.searchBoxToggler');

    let typingTimer = null;
    let activeIndex = -1;

    if (!input || !resultsBox) return;

    // 🔹 Open popup
    toggler?.addEventListener('click', () => {
        popup.classList.add('show');
        input.focus();
    });

    // 🔹 Close popup
    closeBtn?.addEventListener('click', () => {
        popup.classList.remove('show');
        input.value = '';
        resetResults();
    });

    function resetResults() {
        resultsBox.innerHTML = '';
        resultsBox.style.display = 'none';
        activeIndex = -1;
    }

    function setActive(items) {
        items.forEach(i => i.classList.remove('active'));
        if (items[activeIndex]) {
            items[activeIndex].classList.add('active');
        }
    }

    // 🔍 LIVE SEARCH
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

                        const vegBadge = product.is_veg
                            ? '<span class="veg-badge">VEG</span>'
                            : '<span class="nonveg-badge">NON-VEG</span>';

                        html += `
                            <a href="/product/${product.slug}" class="live-search-item">
                                <img src="/storage/${product.image}">
                                <div class="live-search-info">
                                    <div class="title-row">
                                        <strong>${product.name}</strong>
                                        ${vegBadge}
                                    </div>
                                    <div class="meta">
                                        ₹${product.price} • ${product.category?.name ?? ''}
                                    </div>
                                </div>
                            </a>
                        `;
                    });

                    resultsBox.innerHTML = html;
                    resultsBox.style.display = 'block';
                });

        }, 300);
    });

});
