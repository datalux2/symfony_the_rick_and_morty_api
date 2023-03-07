<?php
    
    namespace App\DTO\Response\Transformer;
    
    abstract class AbstractResponseDTOTransformer implements ResponseDTOTransformerInterface
    {
        public function transformFromObjects(iterable $objects): iterable
        {
            $dto = [];
            
            foreach ($objects as $object)
            {
                $dto[] = $this->transformFromObject($object);
            }
            
            return $dto;
        }
    }
    
?>
