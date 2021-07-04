<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Traits;

use CodeIgniter\Exceptions\PageNotFoundException;

trait DeleteTrait
{

    protected $deleteModelName;

    protected $beforeDelete = ['beforeDelete'];

    protected function beforeDelete(array $data) : array
    {
        return $data;
    }

    public function delete($id = null, ...$params)
    {
        if (!$this->isActionAllowed(__FUNCTION__, $error))
        {
            throw PageNotFoundException::forPageNotFound($error ?? lang('Page not found.'));
        }

        $action = $this->createAction('BasicApp\RESTful\Actions\DeleteAction', [
            'modelName' => $this->deleteModelName ?? $this->modelName,
            'beforeDelete' => 'beforeDelete',
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