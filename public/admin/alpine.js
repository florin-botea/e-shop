document.addEventListener('alpine:init', () => 
{
    Alpine.data('crud', (resource, params) => ({
        resource: resource,
        params: params,
        
        modal: null,
        fetching: true,
        saving: false,
        creating: false,
        editing: false,
        
        init(el) {
            let url = this.$store.global.base_url;
            axios.get(url + '/' + this.resource, this.params)
            .then(res => {
                $(this.$el).append(res.data);
                this.fetching = false;
                // put modal in root to not pass fields on parent form data
                this.modal = $(this.$el).find('.crud-modal');
                $('body').append(this.modal.detach());
            });
        },
        edit(id) {
            this.modal.modal('show');
        }
    }));
})