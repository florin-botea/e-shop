<!DOCTYPE html>
<html :dir="$direction" :lang="$lang">
<head>
<script>
window.app = {!! json_encode($WINDOW_VARS) !!}
</script>
<meta charset="UTF-8" />
<title>{{ $title }}</title>
<base :href="$base" />
<meta p-if="$description" name="description" :content="$description" />
<meta p-if="$keywords" name="keywords" :content="$keywords" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
	<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<link href="/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<script src="/javascript/jquery/datetimepicker/moment/moment.min.js" type="text/javascript"></script>
<script src="/javascript/jquery/datetimepicker/moment/moment-with-locales.min.js" type="text/javascript"></script>
<script src="/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
<link type="text/css" href="/stylesheet/stylesheet.css" rel="stylesheet" media="screen" />
<link type="text/css" href="/stylesheet/app.css" rel="stylesheet" media="screen" />
<!-- script src="view/javascript/common.js" type="text/javascript"></script -->
<script src="/javascript/app.js" type="text/javascript"></script>
<script src="https://unpkg.com/petite-vue@0.4.1/dist/petite-vue.iife.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
<link href="/admin/app.css" type="text/css" rel="stylesheet" media="screen" />
<link href="/admin/crud.css" type="text/css" rel="stylesheet" media="screen" />
<script src="/admin/crud.js" type="text/javascript"></script>
<script src="/admin/index.js" type="text/javascript"></script>
<script src="/admin/alpine.js" type="text/javascript"></script>
<script src="/admin/app.js" type="text/javascript"></script>
<script src="//unpkg.com/alpinejs" defer></script>
<script>
window.http = axios;
window.http.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
</script>
</head>
<body>
    
<div id="container">
    <tpl is="partials/header"></tpl>
    <tpl is="partials/column-left"></tpl>
    <slot></slot>
</div>
</body>
</html>