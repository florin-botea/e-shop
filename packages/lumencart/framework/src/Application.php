<?php

namespace LumenCart;

use Laravel\Lumen\Application as BaseApplication;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Application extends BaseApplication
{
    protected $extends = [
        'model' => []
    ];
    
    public function __construct($basePath = null) {
        parent::__construct($basePath);

        $this->sessionBindings();
        $this->requestMacros();
    }

    protected function registerUrlGeneratorBindings() {
        $this->singleton('url', function () {
            return new \PsrRouting\UrlGenerator($this);
        });
    }

    protected function sessionBindings() {
        $this->configure('sessiom');
        
        $this->singleton(\Illuminate\Session\SessionManager::class, function () {
            return $this->loadComponent('session', \Illuminate\Session\SessionServiceProvider::class, 'session');
        });

        $this->singleton('session.store', function () {
            return $this->loadComponent('session', \Illuminate\Session\SessionServiceProvider::class, 'session.store');
        });
        //dd($this->request);
        //try {
        //$this->request->setLaravelSession(app('session'));} catch(\Exception $e) {dd($e);}
    }

    protected function requestMacros() {
        $this->request->macro('needsConfirmation', function(string $message = 'Are you sure?') {
            if (! $this->_confirm) {
                throw new Exceptions\ConfirmationRequired($message);
            }
        });

        $this->request->macro('confirmationRequired',
            function(string $message, string $flag = '_confirm') {
                $data = $this->all();
                $data['_confirmation_required'] = [
                    'message' => $message,
                    'flag' => $flag
                ];

                return $data;
            });

        $this->request->macro('flagRequired',
            function(string $message, string $flag = '_flag') {
                $data = $this->all();
                $data['_flag_required'] = [
                    'message' => $message,
                    'flag' => $flag
                ];

                return $data;
            });

        $this->request->macro('paramRequired',
            function(string $message, string $flag = '_param') {
                $data = $this->all();
                $data['_flag_required'] = [
                    'message' => $message,
                    'flag' => $flag
                ];

                return $data;
            });

        $this->request->macro('validate',
            function ($rules, $messages = [], $customAttributes = []) {
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

        $this->request->macro('validated',
            function ($rules) {
                $this->validate($rules);

                return $this->only(array_keys($rules));
            });
    }

    /**
    * @override
    */
    public function getConfigurationPath($name = null) {
        if (! $name) {
            $appConfigDir = $this->basePath('config').'/';

            if (file_exists($appConfigDir)) {
                return $appConfigDir;
            } elseif (file_exists($path = __DIR__.'/../config/')) {
                return $path;
            }
        } else {
            $appConfigPath = $this->basePath('config').'/'.$name.'.php';

            if (file_exists($appConfigPath)) {
                return $appConfigPath;
            } elseif (file_exists($path = __DIR__.'/../config/'.$name.'.php')) {
                return $path;
            }
        }
    }
    
    public function make($abstract, array $parameters = [])
    {
        if (! strpos($abstract, '::')) {
            return parent::make($abstract, $parameters);
        }
        
        [$type, $name] = explode('::', $abstract);
        
        return $this->{'resolve' . ucfirst($type)}($name, $parameters);
    }
    
    private function resolveModel($name, $parameters)
    {
        $class = implode('\\', array_map(fn($s) => ucfirst(Str::camel($s)), explode('/', $name)));
        $class = 'App\\Models\\' . $class;
        
        $concrete = new $class($parameters);
        foreach ($this->extends['model'] as $extend) {
            $concrete = $extend($concrete);
        }
        
        return $concrete;
    }

    public function model($name) {
        return new AbstractModel($name);
    }
}