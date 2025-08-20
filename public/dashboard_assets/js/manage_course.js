$(document).ready(function() {
    // Elements
    const searchInput = document.getElementById('searchInput');
    const contentContainer = document.getElementById('content-container');
    const paginationContainer = document.getElementById('pagination');
    let searchTimeout = null;

    // Function to load content via AJAX
    function loadContent(url) {
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.getElementById('content-container');
                const newPagination = doc.getElementById('pagination');

                if (newContent && newPagination) {
                    contentContainer.innerHTML = newContent.innerHTML;
                    paginationContainer.innerHTML = newPagination.innerHTML;
                    window.history.pushState({ content: newContent.innerHTML, pagination: newPagination.innerHTML }, '', url);
                } else {
                    throw new Error('Invalid response structure');
                }
            });
    }

    // Perform search
    function performSearch(query) {
        const url = new URL(window.location.href);
        if (query) {
            url.searchParams.set('search', query);
        } else {
            url.searchParams.delete('search');
        }
        url.searchParams.delete('page');
        loadContent(url.toString());
    }

    // Debounced Search
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const query = searchInput.value.trim();
            if (query.length >= 2 || query.length === 0) {
                performSearch(query);
            }
        }, 500);
    });

    // Handle pagination clicks via AJAX
    $(document).on('click', '#pagination a', function(e) {
        e.preventDefault();
        loadContent(this.href);
    });

    // Handle browser back/forward navigation
    window.addEventListener('popstate', function(event) {
        if (event.state && event.state.content && event.state.pagination) {
            contentContainer.innerHTML = event.state.content;
            paginationContainer.innerHTML = event.state.pagination;
        } else {
            loadContent(window.location.href);
        }
    });
});
