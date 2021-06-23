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
            if (property_exists($this, 'updateModelName'))
            {
                $modelName = $this->editModelName ?? ($this->updateModelName ?? $this->modelName);
            }
            else
            {
                $modelName = $this->editModelName ?? $this->modelName;
            }

            return $this->createAction('BasicApp\RESTful\Actions\EditAction', [
                'modelName' => $modelName
            ])->execute('edit', $id);
        }

        $this->throwPageNotFoundException();
    }
    
}