<?php

namespace App\Admin\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\Table;
use App\Models\EntityProperty;
use App\Models\EntityRelationship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

/**
* This route handle model props and relationship management
*/
class EntityController extends Controller
{
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function create() {
        $data['form_entity']['action'] = route('admin/system/entity');
        $data['form_entity']['method'] = 'POST';
        $data['entity'] = new Entity();
        $data['new_entity_property'] = new EntityProperty();
        $data['new_entity_relationship'] = new EntityRelationship();
        $data['new_entity_relationship_throught'] = new EntityRelationship();
        $data['tables'] = Table::with('columns')->get();

        return view('system/entity/form', $data);
    }

    public function store() {
        DB::transaction(function() {
            $entity = Entity::create($this->request->all());
            
            $model_file = $entity->generateModel($this->request->all());

            foreach ($this->request->post('properties') as $property) {
                $entity->properties()->create($property);
            }
        });
        
        dd($entity);
    }

    public function edit($entity_id) {
        $entity = Entity::findOrFail($entity_id);

        $data['form_entity']['action'] = route('admin/system/entity/update', ['entity_id' => $entity_id, '_method' => 'PUT']);
        $data['form_entity']['method'] = 'POST';
        $data['entity'] = $data['MODEL'] = $entity;
        $data['new_entity_property'] = new EntityProperty();

        return view('system/entity/form', $data);
    }

    public function update($entity_id) {
        $entity = Entity::findOrFail($entity_id);

        DB::transaction(function() use ($entity) {
            $migration_name = $entity->generateMigration($this->request->post('name'), $this->request->post('properties'));

            $entity->update($this->request->all());

            $entity->properties()->delete();
            foreach ($this->request->post('properties') as $property) {
                $entity->properties()->create($property);
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