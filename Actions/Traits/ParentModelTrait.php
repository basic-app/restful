<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions\Traits;

trait ParentModelTrait
{

    public function parentModelOne(...$params)
    {
        return $this->controller->callFormModel('one', ...$params);
    }

    public function parentModelFindOrFail(...$params)
    {
        return $this->controller->callFormModel('findOrFail', ...$params);
    }    

    public function parentModelFindOne(...$params)
    {
        return $this->controller->callFormModel('findOne', ...$params);
    }

    public function parentModelAll(...$params)
    {
        return $this->controller->callFormModel('all', ...$params);
    }

    public function parentModelCreateEntity(...$params)
    {
        return $this->controller->callFormModel('createEntity', ...$params);
    }

    public function parentModelEntityPrimaryKey(...$params)
    {
        return $this->controller->callFormModel('entityPrimaryKey', ...$params);
    }

    public function parentModelInsertID(...$params)
    {
        return $this->controller->callFormModel('insertID', ...$params);
    }

    public function parentModelFillEntity(...$params)
    {
        return $this->controller->callFormModel('fillEntity', ...$params);
    }

    public function parentModelSave(...$params)
    {
        return $this->controller->callFormModel('save', ...$params);
    }

    public function parentModelDelete(...$params)
    {
        return $this->controller->callFormModel('delete', ...$params);
    }

    public function parentModelErrors(...$params)
    {
        return $this->controller->callFormModel('errors', ...$params);
    }

    public function parentModelEntitySetField(...$params)
    {
        return $this->controller->callFormModel('entitySetField', ...$params);
    }

}