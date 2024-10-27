<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Entity extends Model
{
    protected $fillable = [
        'name',
        'class',
        'table',
    ];

    public function properties()
    {
        return $this->hasMany(EntityProperty::class);
    }

    public function generateMigration($table, $properties)
    {
        $alter_table = false;
        $content = '';

        $old_table = $this->attributes['table'];

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

        $existing_properties = $this->properties->keyBy('id');

        $has_changes = false;
        foreach ($properties as $property) {
            $old = null;
            $changes['code'] = false;
            $changes['default'] = true;
            $changes['index'] = true;

            if ($property['id'] && $alter_table && $existing_properties[$property['id']]) {
                $old = $existing_properties[$property['id']];

                $changes['code'] = $old->code != $property['code'];
                $changes['default'] = $old->default != $property['default'];
                $changes['index'] = $old->index != ($property['index'] ?? false);

                if (empty(array_filter($changes))) {
                    continue;
                }

                $has_changes = true;

                if ($changes['code']) {
                    $content .= "\n            \$table->renameColumn('$old->code', '{$property['code']}');";
                } else {
                    $content .= "\n            \$table->{$property['type']}('{$property['code']}', {$property['length']})";
                }
            } else {
                $has_changes = true;

                $content .= "\n            \$table->{$property['type']}('{$property['code']}', {$property['length']})";
            }

            if ($changes['index'] && !empty($property['index'])) {
                $content .= '->index()';
            }

            if ($changes['default']) {
                $default = trim($property['default']);
                $content .= "->default('$default')";
            }

            $changes = array_filter($changes);
            if (count($changes) > 1 || ($changes && !$changes['code'])) {
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
