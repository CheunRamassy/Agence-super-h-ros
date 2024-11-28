<?php

namespace App\Entity;

enum MissionStatus:string
{

    case EN_ATTENTE="PENDING";
    case EN_COURS="IN_PROGRESS";
    case ANNULEE="CANCELLED";
    case FINIE="COMPLETED";
    case ECHOUEE="FAILED";

}

?>