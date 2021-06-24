<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Traits;

trait NewTrait
{

    protected $newModelName;

    public function new()
    {
        if (!$this->isActionAllowed('new'))
        {
            $this->throwPageNotFoundException();
        }

        if (property_exists($this, 'createModelName'))
        {
            $modelName = $this->newModelName ?? ($this->createModelName ?? $this->modelName);
        }
        else
        {
            $modelName = $this->newModelName ?? $this->modelName;
        }

        return $this->createAction('BasicApp\RESTful\Actions\NewAction', [
            'modelName' => $modelName,
            'parentModelName' => $this->parentModelName
        ])->execute('new');
    }
    
}