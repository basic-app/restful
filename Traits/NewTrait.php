<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Traits;

use CodeIgniter\Exceptions\PageNotFoundException;

trait NewTrait
{

    protected $newModelName;

    protected $beforeNew = ['beforeNew'];

    protected function beforeNew(array $data) : array
    {
        return $data;
    }

    public function new(...$params)
    {
        if (!$this->isActionAllowed(__FUNCTION__, $error))
        {
            throw PageNotFoundException::forPageNotFound($error ?? lang('Page not found.'));
        }

        if (property_exists($this, 'createModelName'))
        {
            $modelName = $this->newModelName ?? ($this->createModelName ?? $this->modelName);
        }
        else
        {
            $modelName = $this->newModelName ?? $this->modelName;
        }

        $this->_actions[__FUNCTION__] = $this->createAction('BasicApp\RESTful\Actions\NewAction', [
            'modelName' => $modelName,
            'parentModelName' => $this->parentModelName,
            'beforeNew' => 'beforeNew'
        ]);

        if (!$this->beforeAction(__FUNCTION__, $error))
        {
            $this->throwSecurityException($error ?? lang('Access denied.'));
        }

        return ($this->_actions[__FUNCTION__])->execute(...$params);
    }
    
}