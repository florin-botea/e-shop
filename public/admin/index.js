class Index 
{
    constructor(el, route) {
        this.el = el;
        this.el.data('index', this);
        this.url = window.app.base_url + '/' + route.replace('/[\/\?& ]+$/', '');
        this.per_page = window.app.items_per_page;
    }
    
    init(fetch = false) {
        this.shimmer = this.el.find('.lm-table-loading');
        this.setupLoader();
        
        if (fetch) {
            this.fetch();
        } else {
            this.attachEventListeners();
        }
    }
    
    fetch() {
        this.loading(this.shimmer, true);
        
        http.get(this.url)
        .then(res => {
            let $res = $('<div/>').append($(res.data));
            let $wrapper = this.el.find('.table-wrapper');
            $wrapper.html($res.find('.table-wrapper').html());
            this.attachEventListeners();
            this.loading(this.shimmer, false);
        })
        .finally(() => {
        })
    }    
  
    delete(id) {
        let btn = this.el.find('tr[data-item-id="'+id+'"] .lm-index-delete');
        this.loading(btn, true);
        http.delete(this.url + '/' + id)
        .then(res => {
            this.fetch();
        })
        .finally(() => {
            this.loading(btn, false);
            // $(this).loading(false);
        })        
    }
    
    loading(el, state = true)
    {
        if (state) {
            el.addClass('loading');
        } else {
            el.removeClass('loading');
        }
    }
    
    attachEventListeners()
    {
        this.el.find('.lm-index-delete')
        .off('click')
        .on('click', (e) => this.delete($(e.target).closest('tr').attr('data-item-id')));
        
        this.el.trigger('index.eventsAdded');
    }
    
    setupLoader() 
    {
        let table = this.shimmer.html('');
        for (let i=0;i<this.per_page;i++) {
            table.append('<tr><td><div class="bg-fetch"><span class="btn invisible">x</span></div></td></tr>');
        }
    }
}