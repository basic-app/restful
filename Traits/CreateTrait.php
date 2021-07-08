<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Traits;

use CodeIgniter\Exceptions\PageNotFoundException;

trait CreateTrait
{

    protected $createModelName;

    protected $beforeCreate = ['beforeCreate'];

    protected function beforeCreate(array $data) : array
    {
        return $data;
    }

    public function create(...$params)
    {        
        if (!$this->isActionAllowed(__FUNCTION__, $error))
        {
            throw PageNotFoundException::forPageNotFound($error ?? lang('Page not found.'));
        }

        $this->_actions[__FUNCTION__] = $this->createAction('BasicApp\RESTful\Actions\CreateAction', [
            'modelName' => $this->createModelName ?? $this->modelName,
            'parentModelName' => $this->parentModelName,
            'parentKey' => $this->parentKey,
            'beforeCreate' => 'beforeCreate'
        ]);

        if (!$this->beforeAction(__FUNCTION__, $error))
        {
            $this->throwSecurityException($error ?? lang('Access denied.'));
        }

        return ($this->_actions[__FUNCTION__])->execute(...$params);
    }
    
}