<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful;

class ResourcePresenter extends BaseResourcePresenter
{

    use RESTfulTrait;
    use ResourcePresenterTrait;

    use Traits\IndexTrait;
    use Traits\NewTrait;
    use Traits\CreateTrait;
    use Traits\EditTrait;
    use Traits\ViewTrait;
    use Traits\UpdateTrait;
    use Traits\ShowTrait;
    use Traits\DeleteTrait;
    use Traits\MassUpdateTrait;
    use Traits\MassEditTrait;

    public function _remap($method, ...$params)
    {
        if (method_exists($this, $method))
        {
            return $this->$method(...$params);
        }

        return $this->remapAction($method, ...$params);
    }

}