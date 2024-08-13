<?php

namespace Rezahmady\SettingOperation;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use Alert;

trait SettingOperation
{

    public $model;

    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupSettingRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/setting', [
            'as'        => $routeName.'.setting',
            'uses'      => $controller.'@setting',
            'operation' => 'setting',
        ]);

        Route::put($segment.'/setting/{id}', [
            'as'        => $routeName.'.save.setting',
            'uses'      => $controller.'@saveSetting',
            'operation' => 'setting',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupSettingDefaults()
    {
        $this->crud->allowAccess('setting');

        $this->crud->operation('setting', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
        });

        $this->crud->operation(['list'], function () {
            // add a button in the line stack
            $this->crud->addButton('top', 'setting', 'view', 'setting-operation::btn-setting', 'end');
        });

        $this->model = config('setting-operation.setting_model_class', \Rezahmady\SettingOperation\app\Models\SettingOperation::class);
    }   

    /**
     * Display the setting form.
     *
     *
     * @return Response
     */
    public function setting()
    {
        $this->crud->hasAccessOrFail('setting');

        $this->data['entry'] = $this->crud->model->getTable();
        $this->crud->setModel($this->model);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = trans('setting-operation::setting-operation.settings').' '.($this->crud->getTitle() ?? mb_ucfirst($this->crud->entity_name));

        $this->setupSettingOperation();

        return view('setting-operation::setting', $this->data);
    }

    /**
     * Restore a specific settings for the specified CRUD.
     *
     *
     * @param int $id
     * @param Request $request
     *
     * @return HTTP 302 redirct back to crud list
     */
    public function saveSetting(Request $request, $id)
    {        
        $fields = $request->except(['_token', '_method','http_referrer' ,'current_tab']);
        Cache::forget("settingOperation::$id");
       
        $this->crud->hasAccessOrFail('setting');

        $setting_model = $this->model;

        $setting = $setting_model::where('key', $id)->first();

        if($setting != null) {
            $setting->update([
                'fields' => json_encode($fields)
            ]);
        } else {
            $setting_model::create([
                'key' => $id,
                'fields' => json_encode($fields)
            ]);
        }

        Alert::success(trans("setting-operation::setting-operation.saved_successfully"))->flash();
        return redirect()->back();
    }

    /**
     * Define what happens when the Setting operation is loaded.
     * 
     * @see https://github.com/rezahmady/setting-operation
     * @return void
     */
    protected function setupSettingOperation() {
        // backpack Fields
    }
}
