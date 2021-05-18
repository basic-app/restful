<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @author CodeIgniter Foundation <admin@codeigniter.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful;

use Webmozart\Assert\Assert;

trait RESTfulTrait
{

    protected $createModelName;

    protected $createModel;

    protected $updateModelName;

    protected $updateModel;

    protected $parent;

    protected $parentKey;

    protected $parentModelName;

    protected $parentModel;

    protected $searchModelName;

    protected $searchModel;

    protected $perPage;

    protected $perPageItems;

    /**
     * Set or change the model this controller is bound to.
     * Given either the name or the object, determine the other.
     *
     * @param object|string|null $which
     *
     * @return void
     */
    public function setCreateModel($which = null)
    {
        // save what we have been given
        if ($which)
        {
            $this->createModel = is_object($which) ? $which : null;
            $this->createModelName = is_object($which) ? null : $which;
        }

        // make a model object if needed
        if (empty($this->createModel) && ! empty($this->createModelName))
        {
            if (class_exists($this->createModelName))
            {
                $this->createModel = model($this->createModelName);
            }
        }

        // determine model name if needed
        if (! empty($this->createModel) && empty($this->createModelName))
        {
            $this->createModelName = get_class($this->createModel);
        }
    }

    /**
     * Set or change the model this controller is bound to.
     * Given either the name or the object, determine the other.
     *
     * @param object|string|null $which
     *
     * @return void
     */
    public function setUpdateModel($which = null)
    {
        // save what we have been given
        if ($which)
        {
            $this->updateModel = is_object($which) ? $which : null;
            $this->updateModelName = is_object($which) ? null : $which;
        }

        // make a model object if needed
        if (empty($this->updateModel) && ! empty($this->updateModelName))
        {
            if (class_exists($this->updateModelName))
            {
                $this->updateModel = model($this->updateModelName);
            }
        }

        // determine model name if needed
        if (! empty($this->updateModel) && empty($this->updateModelName))
        {
            $this->updateModelName = get_class($this->updateModel);
        }
    }

    /**
     * Set or change the model this controller is bound to.
     * Given either the name or the object, determine the other.
     *
     * @param object|string|null $which
     *
     * @return void
     */
    public function setParentModel($which = null)
    {
        // save what we have been given
        if ($which)
        {
            $this->parentModel = is_object($which) ? $which : null;
            $this->parentModelName = is_object($which) ? null : $which;
        }

        // make a model object if needed
        if (empty($this->parentModel) && ! empty($this->parentModelName))
        {
            if (class_exists($this->parentModelName))
            {
                $this->parentModel = model($this->parentModelName);
            }
        }

        // determine model name if needed
        if (! empty($this->parentModel) && empty($this->parentModelName))
        {
            $this->parentModelName = get_class($this->parentModel);
        }
    }

    /**
     * Set or change the model this controller is bound to.
     * Given either the name or the object, determine the other.
     *
     * @param object|string|null $which
     *
     * @return void
     */
    public function setSearchModel($which = null)
    {
        // save what we have been given
        if ($which)
        {
            $this->searchModel = is_object($which) ? $which : null;
            $this->searchModelName = is_object($which) ? null : $which;
        }

        // make a model object if needed
        if (empty($this->searchModel) && ! empty($this->searchModelName))
        {
            if (class_exists($this->searchModelName))
            {
                $this->searchModel = model($this->searchModelName);
            }
        }

        // determine model name if needed
        if (! empty($this->searchModel) && empty($this->searchModelName))
        {
            $this->searchModelName = get_class($this->searchModel);
        }
    }

    public function getParent($refresh = false)
    {
        if ($this->parent && !$refresh)
        {
            return $this->parent;
        }

        Assert::notEmpty($this->parentModelName, 'Parent model name not defined.');

        Assert::notEmpty($this->parentModel, 'Parent model not found: ' . $this->parentModelName);

        $parentId = $this->request->getGet('parentId');

        Assert::notEmpty($parentId, 'parentId not defined.');
        
        $this->parent = $this->parentModel->findOrFail($parentId, 'Parent not found.');
    
        return $this->parent;
    }

    public function userCanMethod($user, $method, $entity, &$error = null) : bool
    {
        return true;
    }

}