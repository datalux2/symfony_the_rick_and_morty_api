<?php
    
    namespace App\DTO\Response\Transformer;
    
    use App\DTO\Response\CharactersResponseDTO;
    use App\Entity\Characters;
    
    class CharactersResponseDTOTransformer extends AbstractResponseDTOTransformer
    {
        /**
         * @param Character $character
         * 
         * @return CharactersResponseDTO
         */
        public function transformFromObject($character): CharactersResponseDTO
        {
            $dto = new CharactersResponseDTO();
            
            $dto->id = $character->getId();
            $dto->name = $character->getName();
            $dto->originName = $character->getOriginName();
            $dto->originUrl = $character->getOriginUrl();
            $dto->image = $character->getImage();
            $dto->species = $character->getSpecies();
            $dto->status = $character->getStatus();
            $dto->type = $character->getType();
            $dto->url = $character->getUrl();
            $dto->gender = $character->getGender();
            $dto->created = $character->getCreated();
            
            return $dto;
        }
    }
    
?>
