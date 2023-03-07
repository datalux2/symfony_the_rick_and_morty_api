<?php
    
    namespace App\DTO\Response\Transformer;
    
    interface ResponseDTOTransformerInterface
    {
        public function transformFromObject($object);
        
        public function transformFromObjects(iterable $objects): iterable;
    }
    
?>
