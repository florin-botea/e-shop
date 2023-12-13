document.addEventListener('alpine:init', () => {
    Alpine.data('list', (items = []) => ({
        items: items,
    }));
});