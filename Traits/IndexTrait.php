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

    protected $sortLabels = [];

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

        $this->_actions[__FUNCTION__] = $this->createAction('BasicApp\RESTful\Actions\IndexAction', [
            'modelName' => $this->indexModelName ?? $this->modelName,
            'searchModelName' => $this->searchModelName,
            'sortLabels' => $this->sortLabels,
            'parentKey' => $this->parentKey,
            'parentModelName' => $this->parentModelName,
            'beforeIndex' => 'beforeIndex'
        ]);

        if (!$this->beforeAction(__FUNCTION__, $error))
        {
            $this->throwSecurityException($error ?? lang('Access denied.'));
        }

        return ($this->_actions[__FUNCTION__])->execute(...$params);
    }
    
}