<?php

namespace App\apiModels\internal\v2\Mappers;

use App\apiModels\internal\v2\Model\OfferDefinition;

class OfferDefinitionMapper
{
    public static function fromObjects(array $offerDefinitions)
    {
    	$mappedOfferDefinitions = [];
        foreach ($offerDefinitions as $offerDefinition) {
        	$mappedOfferDefinitions[] = self::fromObject($offerDefinition);
        }
        return $mappedOfferDefinitions;
    }

    public static function fromObject($offerDefinition, OfferDefinition $mappedOfferDefinition = null)
    {   
        if (!$mappedOfferDefinition) {
            $mappedOfferDefinition = new OfferDefinition();
        }
        
        !isset($offerDefinition->_id) ?: $mappedOfferDefinition->setId(strval($offerDefinition->_id));
        !isset($offerDefinition->code) ?: $mappedOfferDefinition->setCode(strval($offerDefinition->code));
        !isset($offerDefinition->name) ?: $mappedOfferDefinition->setName(strval($offerDefinition->name));
        !isset($offerDefinition->elements) ?: $mappedOfferDefinition->setRisks(RiskMapper::fromObjects($offerDefinition->elements));
        !isset($offerDefinition->configuration->attendants) ?: $mappedOfferDefinition->setAgents(AgentMapper::fromObjects($offerDefinition->configuration->attendants));
        !isset($offerDefinition->configuration->depobsl->jsta) ?: $mappedOfferDefinition->setAttendantDepartmentCode(strval($offerDefinition->configuration->depobsl->jsta));
        !isset($offerDefinition->configuration->wube) ?: $mappedOfferDefinition->setWubeCode(strval($offerDefinition->configuration->wube));
        !isset($offerDefinition->configuration->formCode) ?: $mappedOfferDefinition->setFormCode(strval($offerDefinition->configuration->formCode));
        !isset($offerDefinition->configuration->folderType) ?: $mappedOfferDefinition->setFolderType(strval($offerDefinition->configuration->folderType));
        !isset($offerDefinition->configuration->cession) ?: $mappedOfferDefinition->setIndividualCession(boolval($offerDefinition->configuration->cession));
        !isset($offerDefinition->configuration->groupcession) ?: $mappedOfferDefinition->setGroupCession(boolval($offerDefinition->configuration->groupcession));
        !isset($offerDefinition->configuration->ispgen) ?: $mappedOfferDefinition->setIsPgen(boolval($offerDefinition->configuration->ispgen));
        !isset($offerDefinition->configuration->pgenserie) ?: $mappedOfferDefinition->setPgenSerie(strval($offerDefinition->configuration->pgenserie));
        !isset($offerDefinition->configuration->pgenpattern) ?: $mappedOfferDefinition->setPgenType(strval($offerDefinition->configuration->pgenpattern));

		return $mappedOfferDefinition;
    }
}
