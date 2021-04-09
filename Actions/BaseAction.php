<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

abstract class BaseAction extends \BasicApp\Action\BaseAction
{

    use Traits\ModelTrait;

    use Traits\FormModelTrait;

    use Traits\SearchModelTrait;

    use Traits\ParentModelTrait;

}