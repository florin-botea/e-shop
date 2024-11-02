<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Table extends Model
{
    protected $fillable = [
        'name',
        'description',
        'index'
    ];
    
    protected $casts = [
        'index' => 'array'
    ];
    
    public function columns()
    {
        return $this->hasMany(TableColumn::class);
    }
    
    public function generateMigration($table, $columns)
    {
        $alter_table = false;
        $content = '';

        $old_table = $this->attributes['name'];

        if (!Schema::hasTable($old_table)) {
            if ($old_table != $table) {
                $old_table = $table;
            }

            $content .= "        Schema::create('{$old_table}', function (Blueprint \$table) {";
        }
        else {
            $alter_table = true;

            if ($old_table != $table) {
                $old_table = $table;
                $content .= "        Schema::rename('$old_table', '$table');\n\n";
            }

            $content .= "        Schema::table('{$old_table}', function (Blueprint \$table) {";
        }

        $existing_columns = $this->columns->keyBy('id');

        $has_changes = false;
        foreach ($columns as $column) {
            $old = null;
            $changes['name'] = false;
            $changes['default'] = true;
            $changes['index'] = true;

            if ($column['id'] && $alter_table && isset($existing_columns[$column['id']])) {
                $old = $existing_columns[$column['id']];

                $changes['name'] = $old->name != $column['name'];
                $changes['default'] = $old->default != $column['default'];
                $changes['index'] = $old->index != ($column['index'] ?? false);

                if (empty(array_filter($changes))) {
                    continue;
                }

                $has_changes = true;

                if ($changes['name']) {
                    $content .= "\n            \$table->renameColumn('$old->name', '{$column['name']}');";
                } else {
                    $content .= "\n            \$table->{$column['type']}('{$column['name']}', {$column['length']})";
                }
            } else {
                $has_changes = true;

                $content .= "\n            \$table->{$column['type']}('{$column['name']}', {$column['length']})";
            }

            if ($changes['index'] && !empty($column['index'])) {
                $content .= '->index()';
            }

            if ($changes['default']) {
                $default = trim($column['default']);
                $content .= "->default('$default')";
            }

            $changes = array_filter($changes);
            if (count($changes) > 1 || ($changes && !$changes['name'])) {
                $content .= '->change()';
            }

            $content .= ';';
        }

        if (!$has_changes) {
            return null;
        }

        $content .= "\n        });";

        $content = <<<END
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
$content
    }
};
END;

        if ($alter_table) {
            $migration_name = "alter_{$old_table}_table_" . uniqid();
        } else {
            $migration_name = "create_{$table}_table_" . uniqid();
        }

        $dir_migrations = base_path('database/migrations');
        $file = "{$dir_migrations}/{$migration_name}.php";

        file_put_contents($file, $content);

        return $file;
    }
}
