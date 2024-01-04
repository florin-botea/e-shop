<tpl p-if="request()->ajax()">
    {% return $this->renderSlots('default', []) %}
</tpl>

<tpl extends="layouts/app">
  <div id="content" slot="default">
    <div class="page-header" onclick="this.add">
      <div class="container-fluid">
        <div class="pull-right">
          <slot name="action"></slot>
        </div>
        <slot name="title"><h1>{{ $title }}</h1></slot>
        <x-breadcrumbs :items="$breadcrumbs"></x-breadcrumbs>
      </div>
    </div>
    <div class="container-fluid">
      <x-alert p-if="$error" type="danger">{{ $error }}</x-alert>
      <slot></slot>
    </div>
  </div>
  <tpl slot="scripts">
      <slot name="scripts"></slot>
  </tpl>
</tpl>