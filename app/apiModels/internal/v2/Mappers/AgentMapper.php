<?php

namespace App\apiModels\internal\v2\Mappers;

use App\apiModels\internal\v2\Model\Agent;

class AgentMapper
{
    public static function fromObjects(array $agents)
    {
    	$mappedAgents = [];
        foreach ($agents as $agent) {
        	$mappedAgents[] = self::fromObject($agent);
        }
        return $mappedAgents;
    }

    public static function fromObject($agent, Agent $mappedAgent = null)
    {   
        if (!$mappedAgent) {
            $mappedAgent = new Agent();
        }
        
        !isset($agent['jsta']) ?: $mappedAgent->setCode(strval($agent['jsta']));
        !isset($agent['role']) ?: $mappedAgent->setRole(strval($agent['role']));
        !isset($agent['forfolder']) ?: $mappedAgent->setCreateFolder(strtoupper($agent['forfolder']) === 'Y');
        !isset($agent['distchanel']) ?: $mappedAgent->setDistributionChannel(strval($agent['distchanel']));

		return $mappedAgent;
    }
}
