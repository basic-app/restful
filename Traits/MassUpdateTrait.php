<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Traits;

trait MassUpdateTrait
{

    protected $massUpdateModelName;
    
    public function massUpdate()
    {
        if ($this->isActionAllowed('massUpdate'))
        {
            return $this->createAction('BasicApp\RESTful\Actions\MassUpdateAction', [
                'modelName' => $this->massUpdateModelName
            ])->execute('massUpdate');
        }

        return $this->fail(lang('RESTful.notImplemented', ['massUpdate']), 501);
    }

}