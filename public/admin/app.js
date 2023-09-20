var app = window.app;

app.notify = {
    confirm(msg) {
        return window.confirm(msg);
    }
};

$(document).ready(() => 
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