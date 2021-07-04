<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Traits;

use CodeIgniter\Exceptions\PageNotFoundException;

trait UpdateTrait
{

    protected $updateModelName;

    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeUpdate(array $data) : array
    {
        return $data;
    }

    public function update($id = null, ...$params)
    {
        if (!$this->isActionAllowed(__FUNCTION__, $error))
        {
            throw PageNotFoundException::forPageNotFound($error ?? lang('Page not found.'));
        }

        $action = $this->createAction('BasicApp\RESTful\Actions\UpdateAction', [
            'modelName' => $this->updateModelName ?? $this->modelName,
            'beforeUpdate' => 'beforeUpdate',
            'id' => $id
        ]);

        $action->initialize(__FUNCTION__);

        if (!$this->beforeAction($action, $error))
        {
            $this->throwSecurityException($error ?? lang('Access denied.'));
        }

        return $action->execute(...$params);
    }
    
}