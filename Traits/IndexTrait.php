<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Traits;

trait IndexTrait
{

    protected $indexModelName;

    public function index()
    {
        if (!$this->isActionAllowed('index'))
        {
            $this->throwPageNotFoundException();
        }

        return $this->createAction('BasicApp\RESTful\Actions\IndexAction', [
            'modelName' => $this->indexModelName ?? $this->modelName,
            'searchModelName' => $this->searchModelName,
            'parentModelName' => $this->parentModelName
        ])->execute('index');        
    }
    
}