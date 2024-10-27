<?php

namespace App\Admin\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\EntityProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

/**
* This route handle model props and relationship management
*/
class EntityController extends Controller
{
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function create()
    {
        $data['form_entity']['action'] = route('admin/system/entity');
        $data['form_entity']['method'] = 'POST';
        $data['entity'] = new Entity();
        $data['new_entity_property'] = new EntityProperty();

        return view('system/entity/form', $data);
    }

    public function store()
    {
        $entity = Entity::create($this->request->all());

        $entity->properties()->createMany($this->request->post('properties'));
    }

    public function edit($entity_id)
    {
        $entity = Entity::findOrFail($entity_id);

        $data['form_entity']['action'] = route('admin/system/entity/update', ['entity_id' => $entity_id, '_method' => 'PUT']);
        $data['form_entity']['method'] = 'POST';
        $data['entity'] = $data['MODEL'] = $entity;
        $data['new_entity_property'] = new EntityProperty();

        return view('system/entity/form', $data);
    }

    public function update($entity_id)
    {
        $entity = Entity::findOrFail($entity_id);

        $migration_name = $entity->generateMigration($this->request->post('table'), $this->request->post('properties'));

        $entity->update($this->request->all());

        $entity->properties()->delete();
        $entity->properties()->createMany($this->request->post('properties'));

        Artisan::call('migrate');
    }
}
