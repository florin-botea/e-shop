$(document).on('change', '.js_formLangControl', function() {
    let self = $(this);
    let form = self.closest('form');
    form.find('.lang').each((i, el) => {
        el = $(el);
        if (el.hasClass('lang-' + self.val())) {
            return el.fadeIn();
        }
        el.hide();
    });
});

$(document).ready(function() {
    
const List = (items) => ({
    items: items,
    add(item) {
        this.items.push(item);
    }
});

const AjaxList = (items, resource) => ({
    items: items,
    add(item) {
        this.items.push(item);
    },
    fetch(val) {
        $.get('/admin/autocomplete?resource='+resource+'&q='+val)
        .then(res => {
            res.forEach(item => this.items.push(item));
        });
    }
});

PetiteVue.createApp({
    $delimiters: ['${', '}'],
    List,
    AjaxList
}).mount('#content');

});