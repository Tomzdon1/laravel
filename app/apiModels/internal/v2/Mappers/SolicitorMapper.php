<?php

namespace App\apiModels\internal\v2\Mappers;

use App\apiModels\internal\v2\Model\Solicitor;

class SolicitorMapper
{
    public static function fromObjects(array $solicitors)
    {
    	$mappedSolicitors = [];
        foreach ($solicitors as $solicitor) {
        	$mappedSolicitors[] = self::fromObject($solicitor);
        }
        return $mappedSolicitors;
    }

    public static function fromObject($solicitor, Solicitor $mappedSolicitor = null)
    {   
        if (!$mappedSolicitor) {
            $mappedSolicitor = new Solicitor();
        }
        
        !isset($solicitor->solicitor_id) ?: $mappedSolicitor->setSolicitorId(strval($solicitor->solicitor_id));
        !isset($solicitor->agent_id) ?: $mappedSolicitor->setAgentId(strval($solicitor->agent_id));
        
        if (isset($solicitor->permissions) && (is_array($solicitor->permissions) || $solicitor->permissions instanceof Traversable)) {
            $permissions = [];
            
            foreach ($solicitor->permissions as $permission) {
                $permissions[] = strval($permission);
            }

            $permissions = array_unique($permissions);

            !count($permissions) ?: $mappedSolicitor->setPermissions($permissions);
        }
        

		return $mappedSolicitor;
    }
}
