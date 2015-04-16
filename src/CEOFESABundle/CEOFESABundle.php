<?php

namespace CEOFESABundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CEOFESABundle extends Bundle
{
   public function getParent()
    {
        return 'FOSUserBundle';
    } 
}