<?php

namespace Test\RouteTest\Block;

use Magento\Framework\View\Element\Template;

class Test extends Template
{
    public function __construct(
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
}
