<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions\Traits;

trait SearchModelTrait
{

    public function searchModelOne(...$params)
    {
        return $this->controller->callSearchModel('one', ...$params);
    }

    public function searchModelFindOrFail(...$params)
    {
        return $this->controller->callSearchModel('findOrFail', ...$params);
    }

    public function searchModelFindOne(...$params)
    {
        return $this->controller->callSearchModel('findOne', ...$params);
    }

    public function searchModelAll(...$params)
    {
        return $this->controller->callSearchModel('all', ...$params);
    }

    public function searchModelCreateEntity(...$params)
    {
        return $this->controller->callSearchModel('createEntity', ...$params);
    }

    public function searchModelEntityPrimaryKey(...$params)
    {
        return $this->controller->callSearchModel('entityPrimaryKey', ...$params);
    }

    public function searchModelInsertID(...$params)
    {
        return $this->controller->callSearchModel('insertID', ...$params);
    }

    public function searchModelFillEntity(...$params)
    {
        return $this->controller->callSearchModel('fillEntity', ...$params);
    }

    public function searchModelSave(...$params)
    {
        return $this->controller->callSearchModel('save', ...$params);
    }

    public function searchModelDelete(...$params)
    {
        return $this->controller->callSearchModel('delete', ...$params);
    }

    public function searchModelErrors(...$params)
    {
        return $this->controller->callSearchModel('errors', ...$params);
    }

    public function searchModelEntitySetField(...$params)
    {
        return $this->controller->callSearchModel('entitySetField', ...$params);
    }

}