<?php

namespace CEOFESABundle\Form\Transformer;

use CEOFESABundle\Helper\CeoHelper;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * @author Matthieu Sansen <matthieu.sansen@outlook.com>
 */
class FloatToTimeTransformer implements DataTransformerInterface
{
    /**
     * @param float|null $duration
     *
     * @return array
     */
    public function transform($duration)
    {
        return CeoHelper::DurationFloatToArray($duration);
    }

    /**
     * @param array $duration
     *
     * @return float
     */
    public function reverseTransform($duration)
    {
        return CeoHelper::DurationArrayToFloat($duration);
    }
}
