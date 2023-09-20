<?php

namespace LumenCart;

use Laravel\Lumen\Application as BaseApplication;
use Illuminate\Support\Facades\Validator;

class Application extends BaseApplication
{
    public function __construct($basePath = null)
    {
        $this->modelBindings();

        parent::__construct($basePath);
        
        $this->sessionBindings();
        $this->requestMacros();
    }
    
    private function modelBindings() 
    {
        // todo cachw
        foreach (get_dir_contents(__DIR__ .'/Models') as $path) {
            if (is_file($path) && strpos($path, '.php')) {
                $class = str_replace([__DIR__, '/', '.php'], ['', '\\', ''], $path);
                $class = '\LumenCart' . $class;
                $this->availableBindings[$class] = $class;
            }
        }
    }
    
    protected function registerUrlGeneratorBindings()
    {
        $this->singleton('url', function () {
            return new \PsrRouting\UrlGenerator($this);
        });
    }
    
    protected function sessionBindings()
    {
        $this->singleton(\Illuminate\Session\SessionManager::class, function () {
            return $this->loadComponent('session', \Illuminate\Session\SessionServiceProvider::class, 'session');
        });
        
        $this->singleton('session.store', function () {
            return $this->loadComponent('session', \Illuminate\Session\SessionServiceProvider::class, 'session.store');
        });
    }
    
    protected function requestMacros()
    {
        $this->request->macro('needsConfirmation', function(string $message = 'Are you sure?') {
            if (! $this->_confirm) {
                throw new Exceptions\ConfirmationRequired($message);
            }
        });        
        
        $this->request->macro('confirmationRequired', function(string $message, string $flag = '_confirm') {
            $data = $this->all();
            $data['_confirmation_required'] = [
                'message' => $message,
                'flag' => $flag
            ];
            
            return $data;
        });
        
        $this->request->macro('flagRequired', function(string $message, string $flag = '_flag') {
            $data = $this->all();
            $data['_flag_required'] = [
                'message' => $message,
                'flag' => $flag
            ];
            
            return $data;
        });
        
        $this->request->macro('paramRequired', function(string $message, string $flag = '_param') {
            $data = $this->all();
            $data['_flag_required'] = [
                'message' => $message,
                'flag' => $flag
            ];
            
            return $data;
        });
        
        $this->request->macro('validate', function ($rules, $messages = [], $customAttributes = []) 
        {
            $this->lastValidated = array_keys($rules);
        
            $validator = Validator::make(
                $this->all(), $rules, $messages, $customAttributes
            );
    
            if (0 && $this->isPrecognitive()) {
                $validator//->after(Precognition::afterValidationHook($request))
                    ->setRules(
                        $this->filterPrecognitiveRules($validator->getRulesWithoutPlaceholders())
                    );
            }
    
            return $validator->validate();
        });
        
        $this->request->macro('validated', function ($rules) {
            $this->validate($rules);
        
            return $this->only(array_keys($rules));
        });
    }
}