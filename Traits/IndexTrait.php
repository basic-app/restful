<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Traits;

trait IndexTrait
{

    protected $indexModelName;

    public function index()
    {
        if ($this->isActionAllowed('index'))
        {
            return $this->createAction('BasicApp\RESTful\Actions\IndexAction', [
                'modelName' => $this->indexModelName ?? $this->modelName
            ])->execute('index');
        }

        return $this->fail(lang('RESTful.notImplemented', [__FUNCTION__]), 501);
    }
    
}