<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 03/05/18
 * Time: 16:24
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Kingdom;
use AppBundle\Entity\Person;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class PersonController extends Controller
{

    /**
     * @Route("/person/show/{id}", name="show_person")
     */
    public function showPersonAction(Person $person)
    {
        return $this->render('Person/show.html.twig', ['person' => $person]);
    }

    /**
     * @Route("/person/list/{gender}", name="list_person")
     */
    public function listPersonAction($gender)
    {
        $em = $this->getDoctrine()->getManager();
        $persons = $em->getRepository(Person::class)->findByGender($gender);

        return $this->render('Person/list.html.twig', ['persons' => $persons]);
    }

    /**
     * @Route("/person/add/{name}/{firstname}/{gender}/{bio}", name="add_person")
     */
    public function addPersonAction($name,$firstname,$gender,$bio)
    {
        $em = $this->getDoctrine()->getManager();
        $person = new Person();

        $person->setName($name);
        $person->setFirstname($firstname);
        $person->setGender($gender);
        $person->setBiography($bio);

        $em->persist($person);
        $em->flush();

        return $this->redirectToRoute('show_person', ['id' => $person->getId()]);
    }

    /**
     * @Route("/person/{person}/kingdom/{kingdom}", name="add_person")
     */
    public function changePersonKingdomAction(Person $person, Kingdom $kingdom)
    {
        $em = $this->getDoctrine()->getManager();

        $person->setKingdom($kingdom);
        $em->flush();

        return $this->redirectToRoute('show_person', ['id' => $person->getId()]);

    }


}
