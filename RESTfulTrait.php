<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful;

use Webmozart\Assert\Assert;
use BasicApp\Action\ActionInterface;

trait RESTfulTrait
{

    protected $perPage;

    protected $perPageItems;

    protected $data;

    protected $errors = [];

    protected $validationErrors = [];

    protected $parentKey;

    protected $parentModelName;

    protected $parentData;

    protected $searchModelName;

    protected $searchData;

    public function userCanMethod($user, string $method, &$error = null) : bool
    {
        return true;
    }

}