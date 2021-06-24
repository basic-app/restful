<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Traits;

trait CreateTrait
{

    protected $createModelName;

    public function create()
    {
        if (!$this->isActionAllowed('create'))
        {
            $this->throwPageNotFoundException();   
        }
        
        return $this->createAction('BasicApp\RESTful\Actions\CreateAction', [
            'modelName' => $this->createModelName ?? $this->modelName,
            'parentModelName' => $this->parentModelName
        ])->execute('create');
    }
    
}