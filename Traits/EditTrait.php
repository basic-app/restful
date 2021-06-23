<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Traits;

trait EditTrait
{

    protected $editModelName;

    public function edit($id = NULL)
    {
        if ($this->isActionAllowed('edit'))
        {
            return $this->createAction('BasicApp\RESTful\Actions\EditAction', [
                'modelName' => $this->editModelName ?? $this->modelName
            ])->execute('edit', $id);
        }

        return $this->fail(lang('RESTful.notImplemented', [__FUNCTION__]), 501);
    }
    
}