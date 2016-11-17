<?php

namespace CEOFESABundle\Entity;

class Opca
{
    const AGEFOS = 'Agefos';
    const FAFSEA = 'Fafsea';
    const OPCALIA = 'Opcalia';
    const UNIFORMATION = 'Uniformation';

    /**
     * @return string[]
     */
    public static function getChoices()
    {
        return array(
            self::UNIFORMATION,
            self::AGEFOS,
            self::FAFSEA,
            self::OPCALIA,
        );
    }
}
