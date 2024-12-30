<?php

namespace App\Admin\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Table;
use App\Models\TableColumn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

/**
* This route handle model props and relationship management
*/
class TableController extends Controller
{
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function create() {
        $data['form_table']['action'] = route('admin/system/table');
        $data['form_table']['method'] = 'POST';
        $data['table'] = new Table();
        $data['new_table_column'] = new TableColumn();

        return view('system/table/form', $data);
    }

    public function store() {
        $table = Table::create($this->request->all());

        DB::transaction(function() use ($table) {
            $migration_name = $table->generateMigration($this->request->post('name'), $this->request->post('columns'));

            foreach ($this->request->post('columns') as $column) {
                $table->columns()->create($column);
            }

            try {
                Artisan::call('migrate');
            } catch (\Exception $e) {
                @unlink($migration_name);
                throw $e;
            }
        });
    }

    public function edit($table_id) {
        $table = Table::findOrFail($table_id);

        $data['form_table']['action'] = route('admin/system/table/update', ['table_id' => $table_id, '_method' => 'PUT']);
        $data['form_table']['method'] = 'POST';
        $data['table'] = $data['MODEL'] = $table;
        $data['new_table_column'] = new TableColumn();

        return view('system/table/form', $data);
    }

    public function update($table_id) {
        $table = Table::findOrFail($table_id);

        DB::transaction(function() use ($table) {
            $migration_name = $table->generateMigration($this->request->post('name'), $this->request->post('columns'));

            $table->update($this->request->all());

            $table->columns()->delete();
            foreach ($this->request->post('columns') as $column) {
                $table->columns()->create($column);
            }

            try {
                Artisan::call('migrate');
            } catch (\Exception $e) {
                @unlink($migration_name);
                throw $e;
            }
        });
    }
}