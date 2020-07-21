<?php
namespace Application\View\Helper;

use Laminas\View\Helper\AbstractHelper;

class ControllerName extends AbstractHelper
{
    protected $routeMatch;

    public function __construct($routeMatch)
    {
        $this->routeMatch = $routeMatch;
    }

    public function __invoke()
    {
        if ($this->routeMatch) {
            return $this->routeMatch->getMatchedRouteName();
        }
    }
}