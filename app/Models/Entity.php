<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class Entity extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'table_id',
    ];
    
    public function generateModel($data)
    {
        $className = Str::camel(Str::slug($data['code']));
        $className = 'Model' . $className . preg_replace('/[^\d]/', '', $this->updated_at);

        $table = Table::find($this->table_id);
        $table_columns = Schema::getColumnListing($table->name);
        
        $fillable = "'" . implode("', '", $table_columns) . "'";
        
        $select = [];
        $columns = $table->columns->keyBy('id');
        foreach ($data['properties'] as $property) {
            $push = $columns[$property['table_column_id']]['name'];
            if ($property['code'] != $push) {
                $push .= ' as ' . $property['code'];
            }
            
            $select[] = $push;
        }
        
        $select = "'" . implode("', '", $select) . "'";

        $content = <<<END
<?php

namespace App\_models;

use Illuminate\Database\Eloquent\Model;

class $className extends Model
{
    protected \$fillable = [
        $fillable
    ];
    
    public function newQuery() {
        return parent::newQuery()->select($select);
    }
}
END;
dd($content);
    }
}
