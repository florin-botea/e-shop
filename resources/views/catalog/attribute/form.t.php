<tpl extends="layouts/page" title="Stores Form">
  <tpl slot="action">

  </tpl>
  <tpl slot="default">
    <form :action="$attribute_form_url" method="post">
      {!! block('attribute.form', $attribute) !!}
      <button>aa</button>
    </form>
  </tpl>
</tpl>