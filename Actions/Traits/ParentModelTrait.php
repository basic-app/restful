<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions\Traits;

trait ParentModelTrait
{

    public $parentKey;

    public $parentModelOne = 'parentModelOne';

    public $parentModelFindOrFail = 'parentModelFindOrFail';

    public $parentModelFindOne = 'parentModelFindOne';

    public $parentModelAll = 'parentModelAll';

    public $parentModelCreateEntity = 'parentModelCreateEntity';

    public $parentModelEntityPrimaryKey = 'parentModelEntityPrimaryKey';

    public $parentModelInsertID = 'parentModelInsertID';

    public $parentModelFillEntity = 'parentModelFillEntity';

    public $parentModelSave = 'parentModelSave';

    public $parentModelDelete = 'parentModelDelete';

    public $parentModelErrors = 'parentModelErrors';

    public $parentModelEntitySetField = 'parentModelEntitySetField';

    public function parentModelOne(...$params)
    {
        return $this->controller->callFormModel('one', $this->parentModelOne, ...$params);
    }

    public function parentModelFindOrFail(...$params)
    {
        return $this->controller->callFormModel('findOrFail', $this->parentModelFindOrFail, ...$params);
    }    

    public function parentModelFindOne(...$params)
    {
        return $this->controller->callFormModel('findOne', $this->parentModelFindOne, ...$params);
    }

    public function parentModelAll(...$params)
    {
        return $this->controller->callFormModel('all', $this->parentModelAll, ...$params);
    }

    public function parentModelCreateEntity(...$params)
    {
        return $this->controller->callFormModel('createEntity', $this->parentModelCreateEntity, ...$params);
    }

    public function parentModelEntityPrimaryKey(...$params)
    {
        return $this->controller->callFormModel('entityPrimaryKey', $this->parentModelEntityPrimaryKey, ...$params);
    }

    public function parentModelInsertID(...$params)
    {
        return $this->controller->callFormModel('insertID', $this->parentModelInsertID, ...$params);
    }

    public function parentModelFillEntity(...$params)
    {
        return $this->controller->callFormModel('fillEntity', $this->parentModelFillEntity, ...$params);
    }

    public function parentModelSave(...$params)
    {
        return $this->controller->callFormModel('save', $this->parentModelSave, ...$params);
    }

    public function parentModelDelete(...$params)
    {
        return $this->controller->callFormModel('delete', $this->parentModelDelete, ...$params);
    }

    public function parentModelErrors(...$params)
    {
        return $this->controller->callFormModel('errors', $this->parentModelErrors, ...$params);
    }

    public function parentModelEntitySetField(...$params)
    {
        return $this->controller->callFormModel('entitySetField', $this->parentModelEntitySetField, ...$params);
    }

}