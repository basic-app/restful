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
        if ($this->isActionAllowed('create'))
        {
            return $this->createAction('BasicApp\RESTful\Actions\CreateAction', [
                'modelName' => $this->createModelName ?? $this->modelName
            ])->execute('create');
        }

        return $this->fail(lang('RESTful.notImplemented', [__FUNCTION__]), 501);
    }
    
}