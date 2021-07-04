<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;

trait ParentTrait
{

    public $parentKey;

    public $parentModelName;

    public $parentModel;

    public $parentData;

    public $parentId;

    public function initializeParent()
    {
        if ($this->parentKey)
        {
            Assert::notEmpty($this->parentModelName, 'Parent model not defined.');

            $this->parentModel = model($this->parentModelName, false);

            Assert::notEmpty($this->parentModel, 'Parent model not found: ' . $this->parentModelName);
        
            $this->parentId = $this->request->getGet('parentId');

            Assert::notEmpty($this->parentId, 'Parent ID not defined.');
            
            $this->parentData = $this->parentModel->findOrFail($this->parentId, 'Parent not found.');

            $this->parentId = $this->parentModel->getIdValue($this->parentData);

            Assert::notEmpty($this->parentId, 'Parent ID not found.');
        }
    }

}