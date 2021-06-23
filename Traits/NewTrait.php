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
        if ($this->isActionAllowed('new'))
        {
            return $this->createAction('BasicApp\RESTful\Actions\NewAction', [
                'modelName' => $this->newModelName ?? $this->modelName
            ])->execute('new');
        }

        return $this->fail(lang('RESTful.notImplemented', [__FUNCTION__]), 501);
    }
    
}