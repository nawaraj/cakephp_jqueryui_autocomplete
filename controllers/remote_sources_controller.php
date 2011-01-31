<?php
class RemoteSourcesController extends AppController {
    var $name = 'RemoteSources';
    
    function get() {
        $this->layout = 'ajax';
        
        if (empty($this->params['form'])) return;
        $model = $this->params['form']['model'];
        $field = $this->params['form']['field'];
        $term = $this->params['form']['term'];
        
        if (!isset($this->{$model})) {
            // Module not loaded.. try to import and load model
            $this->{$model} = ClassRegistry::init($model);
        }
        
        $fields[] = "$model.$field AS label";
        $fields[] = "$model.$field AS value";
        $fields[] = "{$this->{$model}->primaryKey} AS id";
        
    
        $conditions[] = "$model.$field LIKE '%{$term}%'";
        $results = $this->{$model}->find('all', compact('conditions', 'fields'));
        //debug($results);
        $results = Set::extract($results, "{n}.{$model}");
        $this->set(compact('results'));
    }
    
}
