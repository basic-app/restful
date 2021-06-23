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

    public function show($id = null)
    {
        if (!$this->isActionAllowed('show'))
        {
            $this->throwPageNotFoundException();            
        }

        return $this->createAction('BasicApp\RESTful\Actions\ShowAction', [
            'modelName' => $this->showModelName ?? $this->modelName
        ])->execute('show', $id);
    }
    
}