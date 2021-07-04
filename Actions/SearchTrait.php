<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;

trait SearchTrait
{

    public $searchModelName;

    public $searchModel;

    public $searchData;

    public function initializeSearch()
    {
        if ($this->searchModelName)
        {
            $this->searchModel = model($this->searchModelName, false);

            Assert::notEmpty($this->searchModel, 'Search model not found: ' . $this->searchModelName);

            $this->searchData = $this->searchModel->createData($this->request->getGet());
        }
    }

}