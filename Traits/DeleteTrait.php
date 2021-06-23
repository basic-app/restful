<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Traits;

trait DeleteTrait
{

    protected $deleteModelName;

    public function delete($id = null)
    {
        if ($this->isActionAllowed('delete'))
        {
            return $this->createAction('BasicApp\RESTful\Actions\DeleteAction', [
                'modelName' => $this->deleteModelName ?? $this->modelName
            ])->execute('delete', $id);
        }

        $this->throwPageNotFoundException();
    }
    
}