<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Traits;

trait MassEditTrait
{

    protected $massEditModelName;

    protected $beforeMassEdit = ['beforeMassEdit'];

    protected function beforeMassEdit(array $data) : array
    {
        return $data;
    }

    public function massEdit(...$params)
    {
        if (!$this->isActionAllowed(__FUNCTION__, $error))
        {
            throw PageNotFoundException::forPageNotFound($error ?? lang('Page not found.'));
        }

        if (property_exists($this, 'massUpdateModelName'))
        {
            $modelName = $this->massEditModelName ?? ($this->massUpdateModelName ?? $this->modelName);
        }
        else
        {
            $modelName = $this->massEditModelName ?? $this->modelName;
        }

        $action = $this->createAction('BasicApp\RESTful\Actions\MassEditAction', [
            'modelName' => $modelName,
            'beforeMassEdit' => 'beforeMassEdit'
        ]);

        $action->initialize(__FUNCTION__);

        if (!$this->beforeAction($action, $error))
        {
            $this->throwSecurityException($error ?? lang('Access denied.'));
        }

        return $action->execute(...$params);
    }
    
}