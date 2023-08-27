class Crud 
{
    constructor(el, url) {
        this.el = el;
        this.url = url.replace('/[\/\?& ]+$/', '');
    }
    
    init() {
        http.get(this.url)
        .then(res => {
            this.el.html(res.data);
            this.attachEventListeners();
        })
        .finally(() => {
            // $(this).loading(false);
        })
    }
    
    attachEventListeners()
    {
        this.el.find('[_role="lm-crud-submit"]').on('click', () => {
            this.el.find('[_role="lm-crud-modal"] form').submit();
        })
        
        this.el.find('[_role="lm-crud-create"]').on('click', () => {
            // $(this).loading();
            http.get(this.url + '/create')
            .then(res => {
                this.el.find('[_role="lm-crud-modal"] .modal-body')
                .html(res.data);
                this.el.find('[_role="lm-crud-modal"]').modal('show');
            })
            .finally(() => {
                // $(this).loading(false);
            })
        });
    }
    
    index() {
        this.el.load(this.url);
    }
}

(function ( $ ) {
    if ($.fn.crud) {
        return;
    }
    
    $.fn.crud = function(url) {
        let crud = new Crud(this, url);
        crud.init();
        return this;
    };
}( jQuery ));

$(document).on('__submit', '.modal-body form', function(event) {alert(2)
    event.preventDefault();
    let formData = new FormData(this);
    let action = $(this).attr('action');
    let method = $(this).attr('method').toLowerCase();
    
    http[method](action, formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    });
});