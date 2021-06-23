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

    public function massEdit()
    {
        if ($this->isActionAllowed('massEdit'))
        {
            if (property_exists($this, 'massUpdateModelName'))
            {
                $modelName = $this->massEditModelName ?? ($this->massUpdateModelName ?? $this->modelName);
            }
            else
            {
                $modelName = $this->massEditModelName ?? $this->modelName;
            }

            return $this->createAction('BasicApp\RESTful\Actions\MassEditAction', [
                'modelName' => $modelName
            ])->execute('massEdit');
        }

        $this->throwPageNotFoundException();
    }
    
}