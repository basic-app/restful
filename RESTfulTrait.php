<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful;

trait RESTfulTrait
{

    protected $perPage;

    protected $perPageItems;

    protected $parentKey;

    protected $parentModelName;

    protected $searchModelName;

    protected function getRequestData(array $return = []) : array
    {
        if ($this->format === 'json')
        {
            $jsonData = $this->request->getJSON(true);

            if ($jsonData !== null)
            {
                return array_merge($return, $jsonData);
            }
        }

        $return = array_merge($return, $this->request->getPost());

        return $return;
    }

}