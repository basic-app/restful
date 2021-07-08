<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Traits;

use CodeIgniter\Exceptions\PageNotFoundException;

trait EditTrait
{

    protected $editModelName;

    protected $beforeEdit = ['beforeEdit'];

    protected function beforeEdit(array $data) : array
    {
        return $data;
    }

    public function edit($id = NULL, ...$params)
    {
        if (!$this->isActionAllowed(__FUNCTION__, $error))
        {
            throw PageNotFoundException::forPageNotFound($error ?? lang('Page not found.'));
        }

        if (property_exists($this, 'updateModelName'))
        {
            $modelName = $this->editModelName ?? ($this->updateModelName ?? $this->modelName);
        }
        else
        {
            $modelName = $this->editModelName ?? $this->modelName;
        }

        $this->_actions[__FUNCTION__] = $this->createAction('BasicApp\RESTful\Actions\EditAction',[
            'modelName' => $modelName,
            'beforeEdit' => 'beforeEdit',
            'id' => $id
        ]);

        if (!$this->beforeAction(__FUNCTION__, $error))
        {
            $this->throwSecurityException($error ?? lang('Access denied.'));
        }

        return ($this->_actions[__FUNCTION__])->execute(...$params);
    }
    
}