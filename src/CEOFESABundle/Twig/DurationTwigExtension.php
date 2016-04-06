<?php

namespace CEOFESABundle\Twig;

use CEOFESABundle\Helper\CeoHelper;

/**
 * @author Matthieu Sansen <matthieu.sansen@outlook.com>
 */
class DurationTwigExtension extends \Twig_Extension
{
    /**
     * @inheritDoc
     */
    public function getFilters()
    {
        return array(new \Twig_SimpleFilter('ceo_duration', array($this, 'getFormattedDuration')));
    }

    public function getFormattedDuration($floatDuration)
    {
        return CeoHelper::DurationFloatToArray($floatDuration)['display'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'nexity_price_extension';
    }
}
