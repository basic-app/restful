<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Traits;

use CodeIgniter\Exceptions\PageNotFoundException;

trait IndexTrait
{

    protected $indexModelName;

    protected $beforeIndex = ['beforeIndex'];

    protected function beforeIndex(array $data) : array
    {
        return $data;
    }

    public function index(...$params)
    {
        if (!$this->isActionAllowed(__FUNCTION__, $error))
        {
            throw PageNotFoundException::forPageNotFound($error ?? lang('Page not found.'));
        }

        $action = $this->createAction('BasicApp\RESTful\Actions\IndexAction', [
            'modelName' => $this->indexModelName ?? $this->modelName,
            'searchModelName' => $this->searchModelName,
            'parentModelName' => $this->parentModelName,
            'beforeIndex' => 'beforeIndex'
        ]);

        if (!$this->beforeAction($action, $error))
        {
            $this->throwSecurityException($error ?? lang('Access denied.'));
        }

        $action->initialize(__FUNCTION__);

        return $action->execute(...$params);
    }
    
}