<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Traits;

use CodeIgniter\Exceptions\PageNotFoundException;

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

        $this->_actions[__FUNCTION__] = $this->createAction('BasicApp\RESTful\Actions\MassUpdateAction', [
            'modelName' => $this->massUpdateModelName ?? $this->modelName,
            'beforeMassUpdate' => 'beforeMassUpdate'
        ]);

        if (!$this->beforeAction(__FUNCTION__, $error))
        {
            $this->throwSecurityException($error ?? lang('Access denied.'));
        }

        return ($this->_actions[__FUNCTION__])->execute(...$params);
    }

}