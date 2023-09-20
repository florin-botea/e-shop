class Crud 
{
    constructor(el, route) {
        this.el = el;
        this.el.data('crud', this);
        this.url = window.app.base_url + '/' + route.replace('/[\/\?& ]+$/', '');
        this.per_page = window.app.items_per_page;
    }
    
    init(fetch = false) {
        this.modal = this.el.find('.lm-crud-modal');
        $('body').append(this.modal.detach());        

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
  
    create() {
        let btn = this.el.find('.lm-crud-create');
        this.loading(btn, true);
        http.get(this.url + '/create')
        .then(res => {
            this.modal.find('.modal-body')
            .html(res.data);
            this.modal.modal('show');
            this.loading(btn, false);
        })
        .finally(() => {
            // $(this).loading(false);
            this.loading(btn, false);
        })        
    }
    
    edit(id) {
        let btn = this.el.find('tr[data-item-id="'+id+'"] .lm-crud-edit');
        this.loading(btn, true);
        http.get(this.url + '/' + id +'/edit')
        .then(res => {
            this.modal.find('.modal-body')
            .html(res.data);
            this.modal.modal('show');
            this.loading(btn, false);
        })
        .finally(() => {
            this.loading(btn, false);
            // $(this).loading(false);
        })        
    }
    
    delete(id) {
        let btn = this.el.find('tr[data-item-id="'+id+'"] .lm-crud-delete');
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
    
    save() {
        let btn = this.modal.find('.lm-crud-submit');
        this.loading(btn, true);
        let form = this.modal.find('form');
        let formData = new FormData(form[0]);
        let action = form.attr('action');
        let method = form.attr('method').toLowerCase();
        
        http[method](action, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(res => {
            this.fetch();
            this.modal.modal('hide');
        })
        .finally(() => {
            this.loading(btn, false);
        });
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
        this.modal.find('.lm-crud-submit')
        .off('click')
        .on('click', () => this.save());
        
        this.el.find('.lm-crud-create')
        .off('click.crud')
        .on('click.crud', () => this.create());

        this.el.find('.lm-crud-edit')
        .off('click')
        .on('click', (e) => this.edit($(e.target).closest('tr').attr('data-item-id')));
        
        this.el.find('.lm-crud-delete')
        .off('click')
        .on('click', (e) => this.delete($(e.target).closest('tr').attr('data-item-id')));
        
        this.el.trigger('crud.eventsAdded');
    }
    
    setupLoader() 
    {
        let table = this.shimmer.html('');
        for (let i=0;i<this.per_page;i++) {
            table.append('<tr><td><div class="bg-fetch"><span class="btn invisible">x</span></div></td></tr>');
        }
    }
}