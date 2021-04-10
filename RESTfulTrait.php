<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @author CodeIgniter Foundation <admin@codeigniter.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful;

trait RESTfulTrait
{

    protected $formModelName;

    protected $formModel;

    protected $parentKey;

    protected $parentModelName;

    protected $parentModel;

    protected $searchModelName;

    protected $searchModel;

    /**
     * Set or change the model this controller is bound to.
     * Given either the name or the object, determine the other.
     *
     * @param object|string|null $which
     *
     * @return void
     */
    public function setFormModel($which = null)
    {
        // save what we have been given
        if ($which)
        {
            $this->formModel = is_object($which) ? $which : null;
            $this->formModelName = is_object($which) ? null : $which;
        }

        // make a model object if needed
        if (empty($this->formModel) && ! empty($this->formModelName))
        {
            if (class_exists($this->formModelName))
            {
                $this->formModel = model($this->formModelName);
            }
        }

        // determine model name if needed
        if (! empty($this->formModel) && empty($this->formModelName))
        {
            $this->formModelName = get_class($this->formModel);
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

}