var app = window.app;

app.notify = {
    confirm(msg) {
        return window.confirm(msg);
    }
};

async function view(template, data) {
  const http = window.http;
  
  let res = await http.post(window.app.base_url + '/template_builder', {
    template: template,
    data: data,
  });
  
  return res.data;
}

$(document).ready(async () => 
{
    const http = window.http;

    http.interceptors.response.use((res) => 
    {
        if (res.data._confirmation_required) 
        {
            let confirm = res.data._confirmation_required;
            if (app.notify.confirm(confirm.message)) {
                res.config.data = res.config.data || {};
                res.config.data[confirm.flag] = 1;
                return axios.request(res.config);
            } else {
                throw 'Action Aborted';
            }
        }
        
        return Promise.resolve(res);
    });
});

$(document).on('click', 'a[modal]', function(e) {
    e.preventDefault();//todo buggy
    $('#modal .modal-body').load(e.target.href);
    $('#modal').modal('show');
});

    $(document).on('change', '.field-select select', function() {
        let params = {
            field: $(this).val(),
            name: $(this).attr('prefix'),
        };
        http.get("/admin/field-config", {params}).then(res => {
            $(this).closest('.field-select-wrapper').find('.field-config').html(res.data);
        });
    });