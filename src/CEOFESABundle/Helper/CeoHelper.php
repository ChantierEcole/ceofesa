<?php

namespace CEOFESABundle\Helper;

/**
 * @author Matthieu Sansen <matthieu.sansen@outlook.com>
 */
class CeoHelper
{
    /**
     * @param float $duration
     *
     * @return array
     */
    public static function DurationFloatToArray($duration)
    {
        if (empty($duration)) {
            return array('hour' => 0, 'minute' => 0, 'display' => '00h00');
        }

        return array(
            'hour'    => $hour = intval($duration),
            'minute'  => $minute = ($duration - $hour)*60,
            'display' => sprintf('%02dh%02d', $hour, $minute),
        );
    }

    /**
     * @param array $duration
     *
     * @return float
     */
    public static function DurationArrayToFloat($duration)
    {
        return empty($duration) ? 0.0 : (float)($duration['hour'] + $duration['minute']/60);
    }
}
