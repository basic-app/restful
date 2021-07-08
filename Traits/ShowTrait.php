<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Traits;

use CodeIgniter\Exceptions\PageNotFoundException;

trait ShowTrait
{

    protected $showModelName;

    protected $beforeShow = ['beforeShow'];

    protected function beforeShow(array $data) : array
    {
        return $data;        
    }

    public function show($id = null, ...$params)
    {
        if (!$this->isActionAllowed(__FUNCTION__, $error))
        {
            throw PageNotFoundException::forPageNotFound($error ?? lang('Page not found.'));
        }

        $this->_actions[__FUNCTION__] = $this->createAction('BasicApp\RESTful\Actions\ShowAction', [
            'modelName' => $this->showModelName ?? $this->modelName,
            'beforeShow' => 'beforeShow',
            'id' => $id
        ]);

        if (!$this->beforeAction(__FUNCTION__, $error))
        {
            $this->throwSecurityException($error ?? lang('Access denied.'));
        }        

        return ($this->_actions[__FUNCTION__])->execute(...$params);
    }
    
}