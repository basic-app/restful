<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Traits;

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

        $action = $this->createAction('BasicApp\RESTful\Actions\ShowAction', [
            'modelName' => $this->showModelName ?? $this->modelName,
            'beforeShow' => 'beforeShow',
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