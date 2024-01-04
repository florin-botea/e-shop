<div class="table-responsive" p-bind="$this->context->all()">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <slot name="heading">
                    <th p-foreach="$heading as $h">{{ $h }}</th>
                </slot>
            </tr>
        </thead>
        <tbody>
            <slot></slot>
        </tbody>
        <tfoot>
            <tr><slot name="footer"></slot></tr>
        </tfoot>
    </table>
</div>
<?php return new class {
    public function data($data) {
        return $data;
    }
};