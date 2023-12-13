class Crud 
{
    constructor(el, url) {
        this.el = el;
        this.el.data('crud', this);
        this.url = url;
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
        .catch(error => alert(JSON.stringify(error.response.data, null, 2)))
        .finally(() => {
        })
    }    
  
    create() {
        let btn = this.el.find('.lm-crud-create');
        this.loading(btn, true);
        let temp = this.url.split('?');
        let url = temp[0] + '/create' + (temp[1] ? '?' + temp[1] : '');
        http.get(url)
        .then(res => {
            this.modal.find('.modal-body')
            .html(res.data);
            this.modal.modal('show');
            this.loading(btn, false);
        })
                .catch(error => alert(JSON.stringify(error.response.data, null, 2)))

        .finally(() => {
            // $(this).loading(false);
            this.loading(btn, false);
        })        
    }
    
    edit(id) {
        let btn = this.el.find('tr[data-item-id="'+id+'"] .lm-crud-edit');
        this.loading(btn, true);
        let temp = this.url.split('?');
        let url = temp[0] + '/' + id +'/edit' + (temp[1] ? '?' + temp[1] : '');
        http.get(url)
        .then(res => {
            this.modal.find('.modal-body')
            .html(res.data);
            this.modal.modal('show');
            this.loading(btn, false);
        })
                .catch(error => alert(JSON.stringify(error.response.data, null, 2)))

        .finally(() => {
            this.loading(btn, false);
            // $(this).loading(false);
        })        
    }
    
    delete(id) {
        let btn = this.el.find('tr[data-item-id="'+id+'"] .lm-crud-delete');
        this.loading(btn, true);
        let temp = this.url.split('?');
        let url = temp[0] + '/' + id + (temp[1] ? '?' + temp[1] : '');
        http.delete(url)
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
        form.find('.form-group .text-error').remove();
        
        http[method](action, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(res => {
            this.fetch();
            this.modal.modal('hide');
        })
        .catch(error => {
            if ((error.response.status || 0) == 423) {
                Object.keys(error.response.data).forEach(name => {
                    let msg = error.response.data[name][0];
                    form.find(`[name="${name}"]`).after(`<div class="text-error text-danger">${msg}</div>`);
                });
            } else {
alert(JSON.stringify(error.response.data, null, 2))

            }
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