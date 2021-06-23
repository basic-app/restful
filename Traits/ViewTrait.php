<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Traits;

trait ViewTrait
{

    protected $viewModelName;

    public function view()
    {
        if ($this->isActionAllowed('view'))
        {
            return $this->createAction('BasicApp\RESTful\Actions\ViewAction', [
                'modelName' => $this->viewModelName ?? $this->modelName
            ])->execute('view');
        }

        return $this->fail(lang('RESTful.notImplemented', [__FUNCTION__]), 501);
    }
    
}