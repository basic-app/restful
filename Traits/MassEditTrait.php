<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Traits;

trait MassEditTrait
{

    protected $massEditModelName;

    public function massEdit()
    {
        if ($this->isActionAllowed('massEdit'))
        {
            return $this->createAction('BasicApp\RESTful\Actions\MassEditAction', [
                'modelName' => $this->massEditModelName
            ])->execute('massEdit');
        }

        return $this->fail(lang('RESTful.notImplemented', ['massEdit']), 501);
    }
    
}