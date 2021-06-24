<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Traits;

trait UpdateTrait
{

    protected $updateModelName;

    public function update($id = null)
    {
        if (!$this->isActionAllowed('update'))
        {
            $this->throwPageNotFoundException();
        }

        return $this->createAction('BasicApp\RESTful\Actions\UpdateAction', [
            'modelName' => $this->updateModelName ?? $this->modelName
        ])->execute('update', $id);
    }
    
}