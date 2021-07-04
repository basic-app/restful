<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Traits;

trait MassUpdateTrait
{

    protected $massUpdateModelName;

    protected $beforeMassUpdate = ['beforeMassUpdate'];

    protected function beforeMassUpdate(array $data) : array
    {
        return $data;
    }
    
    public function massUpdate(...$params)
    {
        if (!$this->isActionAllowed(__FUNCTION__, $error))
        {
            throw PageNotFoundException::forPageNotFound($error ?? lang('Page not found.'));
        }

        $action = $this->createAction('BasicApp\RESTful\Actions\MassUpdateAction', [
            'modelName' => $this->massUpdateModelName ?? $this->modelName,
            'beforeMassUpdate' => 'beforeMassUpdate'
        ]);

        if (!$this->beforeAction($action, $error))
        {
            $this->throwSecurityException($error ?? lang('Access denied.'));
        }

        $action->initialize(__FUNCTION__);

        return $action->execute(...$params);
    }

}