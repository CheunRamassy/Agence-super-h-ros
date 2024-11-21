<?php

namespace App\Entity;

enum MissionStatus:string
{

    case PENDING="EN ATTENTE";
    case IN_PROGRESS="COMMENCE";
    case CANCELLED="ANNULEE";
    case COMPLETED="FINIE";
    case FAILED="ECHOUEE";

}

?>