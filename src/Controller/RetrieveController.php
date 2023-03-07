<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Characters;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Classes\MyExtendedHttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[Route('/retrieve')]
class RetrieveController extends AbstractController
{     
    #[Route('/from_api_and_save_db', name: 'app_retrieve_from_api_and_save_db', methods: ['GET'])]
    public function retrieve_from_api_and_save_db(EntityManagerInterface $entityManager, ManagerRegistry $doctrine)
    {   
        try
        {
            $doctrine->getRepository(Characters::class)->deleteAllCharacters();
            
            $entityManager->getConnection()->beginTransaction();
            
            $http_client = new MyExtendedHttpClient();

            $result = $http_client->request('GET', $_ENV['API_CHARACTERS_URL'], []);

            $content = $result->getContent();

            $result_array = json_decode($content, true);

            $pages = (int)$result_array['info']['pages'];

            $error = false;
            
            $comment = '';

            for($i = 1; $i <= $pages; $i++)
            {
                $result2 = $http_client->request('GET', $_ENV['API_CHARACTERS_URL'] . 
                        $_ENV['API_CHARACTERS_URL_PARAMS'] . $i, []);

                $content2 = $result2->getContent();

                $result_array2 = json_decode($content2, true);

                if(!empty($result_array2['results']))
                {
                    foreach($result_array2['results'] as $row)
                    {
                        $character = new Characters();
                        $character->setId($row['id']);
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
                else
                {
                    $error = true;
                    $entityManager->getConnection()->rollBack();
                    $comment = 'Brak klucza "results" w tablicy wyników';
                }
            }

            $entityManager->getConnection()->commit();
        }
        catch(TransportExceptionInterface $ex)
        {
            $error = true;
            $entityManager->getConnection()->rollBack();
            $comment = $ex->getMessage();
        }
        
        return $this->render('retrieve/from_api_and_save_db.html.twig', [
            'app_name' => $_ENV["APP_NAME"],
            'error' => $error,
            'comment' => $comment
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
