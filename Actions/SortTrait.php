<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;

trait SortTrait
{

    protected $sortLabels;

    public function initializeSort()
    {
        $sortItems = $this->model->getSortItems();

        if ($sortItems)
        {
            foreach($sortItems as $key => $value)
            {
                if (!array_key_exists($key, $this->sortLabels))
                {
                    $key_segments = explode('.', $key);

                    if (count($key_segments) == 2)
                    {
                        if ($key_segments[1] == 'asc')
                        {
                            $this->sortLabels[$key] = $this->model->getAttributeLabel($key_segments[0]) . lang(' (asc)');
                        
                            continue;
                        }

                        if ($key_segments[1] == 'desc')
                        {
                            $this->sortLabels[$key] = $this->model->getAttributeLabel($key_segments[0]) . lang(' (desc)');
                        
                            continue;
                        }
                    }

                    $this->sortLabels[$key] = $key;
                }
            }
        }
    }

}