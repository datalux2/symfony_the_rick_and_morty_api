<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Characters;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

#[Route('/retrieve')]
class RetrieveController extends AbstractController
{     
    #[Route('/from_api_and_save_db', name: 'app_retrieve_from_api_and_save_db', methods: ['GET'])]
    public function retrieve_from_api_and_save_db(EntityManagerInterface $entityManager, ManagerRegistry $doctrine)
    {   
        $result = shell_exec("curl --ssl-no-revoke https://rickandmortyapi.com/api/character");
        
        if ($result !== null)
        {
            $result_array = json_decode($result, true);
            
            $pages = (int)$result_array['info']['pages'];
            
            $doctrine->getRepository(Characters::class)->deleteAllCharacters();
            
            $entityManager->getConnection()->beginTransaction();
            
            $error = false;
            
            for($i = 1; $i <= $pages; $i++)
            {
                $result2 = shell_exec("curl --ssl-no-revoke https://rickandmortyapi.com/api/character/?page=" . $i);
                                
                if ($result2 !== null)
                {
                    $result_array2 = json_decode($result2, true);
                    
                    if(!empty($result_array2['results']))
                    {
                        foreach($result_array2['results'] as $row)
                        {
                            $character = new Characters();
                            $character->setName($row['name']);
                            $character->setOriginName($row['origin']['name']);
                            $character->setOriginUrl($row['origin']['url']);
                            $character->setUrl($row['url']);
                            $character->setImage($row['image']);
                            $character->setStatus($row['status']);
                            $character->setSpecies($row['species']);
                            $character->setType($row['type']);
                            $character->setGender($row['gender']);
                            $created_string = date('Y-m-d H:i:s', strtotime($row['created']));
                            $created = \DateTime::createFromFormat('Y-m-d H:i:s', $created_string); 
                            $character->setCreated($created);
                            
                            $entityManager->persist($character);
                            $entityManager->flush();
                        }
                    }
                }
                else
                {
                    $error = true;
                    $entityManager->getConnection()->rollBack();
                    break;
                }
            }
            
            if (!$error)
            {
                $entityManager->getConnection()->commit();
            }
        }
        
        return $this->render('retrieve/from_api_and_save_db.html.twig', [
            'app_name' => $_ENV["APP_NAME"],
            'result' => $result,
            'error' => $error
        ]);
    }
    
    #[Route('/from_db_json', name: 'app_retrieve_from_db_json', methods: ['GET'])]
    public function retrieve_from_db_json(EntityManagerInterface $entityManager): Response
    {
        $characters_entities = $entityManager->getRepository(Characters::class)->findAll();
        
        return $this->json(
            $characters_entities,
            headers: ['Content-Type' => 'application/json;charset=UTF-8']
        );
    }

    #[Route('/from_db_json/{name}', name: 'app_retrieve_from_db_json_by_name', methods: ['GET'])]
    public function retrieve_from_db_json_by_name(Request $request, EntityManagerInterface $entityManager): Response
    {
        //$characters_entities = $entityManager->getRepository(Characters::class)->findAll();
        
        $routeParams = $request->attributes->get('_route_params');
        
        $result = $entityManager->getRepository(Characters::class)->createQueryBuilder('o')
                ->where('o.name LIKE :name')
                ->setParameter('name', $routeParams['name'] . '%')
                ->getQuery()
                ->getResult();
        
        return $this->json(
            $result,
            headers: ['Content-Type' => 'application/json;charset=UTF-8']
        );
    }
}
