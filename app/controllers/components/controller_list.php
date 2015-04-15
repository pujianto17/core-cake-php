<?php
class ControllerListComponent extends Object {
    
    public function get() {
        $controllerClasses = Configure::listObjects('controller');
        App::import('Controller', $controllerClasses);

        foreach($controllerClasses as $controller) { 
            if ($controller != 'App') { 
                App::import('Controller', $controller);
                $className = $controller . 'Controller';
                $actions = get_class_methods($className);
                foreach($actions as $k => $v) {
                    if ($v{0} == '_') {
                        unset($actions[$k]);
                    }
                }
                $parentActions = get_class_methods('AppController');
                $controllers[$controller] = array_diff($actions, $parentActions);
            }
        }
		     
        return $controllers;  
    }
    
    /**
     * @param object $controller controller
     * @param array  $settings   settings
     */
    function initialize(&$controller, $settings = array()) {
        $this->controller =& $controller;
        App::import('Core', 'File');
        $this->folder = new Folder;
    }
    
    /**
     * List all controllers (including plugin controllers)
     *
     * @return array
     */
    function listControllers() {
        $controllerPaths = array();

        // app/controllers
        $this->folder->path = APP.'controllers'.DS;
        $controllers = $this->folder->read();
        foreach ($controllers['1'] AS $c) {
            $cName = Inflector::camelize(str_replace('_controller.php', '', $c));
            $controllerPaths[$cName] = APP.'controllers'.DS.$c;
        }

        // plugins/*/controllers/
        $this->folder->path = APP.'plugins'.DS;
        $plugins = $this->folder->read();
        foreach ($plugins['0'] AS $p) {
            if ($p != 'install') {
                $this->folder->path = APP.'plugins'.DS.$p.DS.'controllers'.DS;
                $pluginControllers = $this->folder->read();
                foreach ($pluginControllers['1'] AS $pc) {
                    $pcName = Inflector::camelize(str_replace('_controller.php', '', $pc));
                    $controllerPaths[$pcName] = APP.'plugins'.DS.$p.DS.'controllers'.DS.$pc;
                }
            }
        }

        return $controllerPaths;
    }
    
    /**
     * List actions of a particular Controller.
     *
     * @param string  $name Controller name (the name only, without having Controller at the end)
     * @param string  $path full path to the controller file including file extension
     * @param boolean $all  default is false. it true, private actions will be returned too.
     *
     * @return array
     */
    function listActions($name, $path) {
        // base methods
        if (strpos($path, 'app'.DS.'plugins')) {
            $plugin = $this->getPluginFromPath($path);
            $pacName = Inflector::camelize($plugin) . 'AppController'; // pac - PluginAppController
            $pacPath = APP.'plugins'.DS.$plugin.DS.$plugin.'_app_controller.php';
            App::import('Controller', $pacName, null, null, $pacPath);
            $baseMethods = get_class_methods($pacName);
        } else {
            $baseMethods = get_class_methods('AppController');
        }

        $controllerName = $name.'Controller';
        App::import('Controller', $controllerName, null, null, $path);
        $methods = get_class_methods($controllerName);

        $inMethods = array('index','add','edit','delete'); // not filter out
        // filter out methods
        foreach ($methods AS $k => $method) {
            if (strpos($method, '_', 0) === 0) {
                unset($methods[$k]);
                continue;
            }
            if (in_array($method, $baseMethods) && !in_array($method, $inMethods)) {
                unset($methods[$k]);
                continue;
            }
        }

        return $methods;
    }
    
    /**
     * Get plugin name from path
     *
     * @param string $path file path
     *
     * @return string
     */
    function getPluginFromPath($path) {
        $pathE = explode(DS, $path);
        $pluginsK = array_search('plugins', $pathE);
        $pluginNameK = $pluginsK + 1;
        $plugin = $pathE[$pluginNameK];

        return $plugin;
    }
    
    /**
     * Return true if $name is in /app/controllers folder
     * @param string $name controller's name
     * @return boolean
     */
    function isController($name) {
        $status = false;
        $this->folder->path = APP.'controllers'.DS;
        $controllers = $this->folder->find();
        
        foreach ( $controllers as $file ){
            $cname = Inflector::camelize(str_replace('_controller.php', '', $file));
            if ( $cname==$name ){
                $status = true;
            }
        }
        
        return $status;
    }
    
    /**
     * Return true if $name is in plugin folder
     * @param string $plugin plugin's name
     * @param string $name controller's name
     * @return boolean
     */
    function isPluginController($plugin, $name) {
        $status = false;
        $this->folder->path = APP.'plugins'.DS.$plugin.DS.'controllers'.DS;
        $pluginControllers = $this->folder->find();

        foreach ( $pluginControllers as $file ){
            $pcname = Inflector::camelize(str_replace('_controller.php', '', $file));
            if ( $pcname==$name ){
                $status = true;
            }
        }
        
        return $status;
    }

}

?>