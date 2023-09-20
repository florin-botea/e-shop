class Crud 
{
    constructor(el, url) {
        this.el = el;
        this.url = url.replace('/[\/\?& ]+$/', '');
    }
    
    init(fetch = false) {
        this.modal = this.el.find('[_role="lm-crud-modal"]');
        $('body').append(this.modal.detach());        
        this.el.find('.lm-crud-submit').off('click.lm-crud').on('click.lm-crud', () => {
            this.save();
        })
        
        fetch && this.fetch();
        this.attachEventListeners();
    }
    
    fetch() {
        this.el.addClass('fetching');
        
        http.get(this.url)
        .then(res => {
            let $res = $('<div/>').append($(res.data));
            let $wrapper = this.el.find('.table-wrapper');
            $wrapper.html($res.find('.table-wrapper').html());
            this.attachEventListeners();
        })
        .finally(() => {
            this.el.removeClass('fetching');
        })
    }    
  
    create() {
        let btn = this.el.find('[_role="lm-crud-create"]');
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
        let btn = this.el.find('tr[data-item-id="'+id+'"] [_role="lm-crud-edit"]');
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
        let btn = this.el.find('tr[data-item-id="'+id+'"] [_role="lm-crud-delete"]');
        this.loading(btn, true);
        http.delete(this.url + '/' + id)
        .then(res => {
            this.index();
        })
        .finally(() => {
            this.loading(btn, false);
            // $(this).loading(false);
        })        
    }
    
    save() {
        let btn = this.modal.find('[_role="lm-crud-submit"]');
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
            this.index();
            this.modal.modal('hide');
        })
        .finally(() => {
            this.loading(btn, false);
        });
    }
    
    loading(el, state = true)
    {
        if (el.prop('nodeName') == 'BUTTON') {
            if (state) {
                el.addClass('loading');
            } else {
                el.removeClass('loading');
            }
        }        
    }
    
    attachEventListeners()
    {
        this.el.find('[_role="lm-crud-create"]').on('click', () => {
            this.create();
        });
        
        this.el.find('[_role="lm-crud-edit"]').on('click', (e) => {
            this.edit($(e.target).closest('tr').attr('data-item-id'));
        });
        
        this.el.find('[_role="lm-crud-delete"]').on('click', (e) => {
            this.delete($(e.target).closest('tr').attr('data-item-id'));
        });
    }
}