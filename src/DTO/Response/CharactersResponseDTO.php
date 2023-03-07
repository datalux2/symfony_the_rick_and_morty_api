<?php
    
    namespace App\DTO\Response;
    
    use JMS\Serializer\Annotation as Serialization;
    
    class CharactersResponseDTO
    {
        /**
         * @Serialization\Type("int")
         */
        public int $id;
        
        /**
         * @Serialization\Type("string")
         */
        public string $name;
        
        /**
         * @Serialization\Type("string")
         */
        public string $originName;
        
        /**
         * @Serialization\Type("string")
         */
        public string $originUrl;
        
        /**
         * @Serialization\Type("string")
         */
        public string $url;
        
        /**
         * @Serialization\Type("string")
         */
        public string $image;
        
        /**
         * @Serialization\Type("string")
         */
        public string $status;
        
        /**
         * @Serialization\Type("string")
         */
        public string $species;
        
        /**
         * @Serialization\Type("string")
         */
        public string $type;
        
        /**
         * @Serialization\Type("string")
         */
        public string $gender;
        
        /**
         * @Serialization\Type("DateTime<'Y-m-d\TH:i:s'>")
         */
        public \DateTime $created;
    }
    
?>
