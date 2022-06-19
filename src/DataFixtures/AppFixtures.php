<?php

namespace App\DataFixtures;

use App\Entity\Advance;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Avatar;
use App\Entity\User;
use App\Entity\WholepayEvent;

use App\Entity\Expense;
use App\Entity\Invitation;
use phpDocumentor\Reflection\Types\Float_;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $avatar = new Avatar();
        $avatar->setImage("http://hostname.com/path/avatar1.png");
        


        $avatar = new Avatar();
        $avatar->setImage("http://hostname.com/path/avatar2.png");
        $manager->persist($avatar);



        // creation de compte pour afaf
        $afaf = new user();
        $afaf->setname("Labed");
        $afaf->setFirstname("Afaf");
        $afaf->setPassword("passwordAfaf");
        $afaf->setEmail("afaf@gmail.com");
        $afaf->setAvatar($avatar);

        $rayan = new user();
        $rayan->setname("Ayad");
        $rayan->setFirstname("Rayan");
        $rayan->setPassword("passwordRayan");
        $rayan->setEmail("rayan@gmail.com");
        $rayan->setAvatar($avatar);

       

        // creation du wholepay sejour paris
        $sejourparisEvent = new WholepayEvent();
        $sejourparisEvent->setTitle("Sejour paris");
        $sejourparisEvent->setDescription("pas de description");
        $sejourparisEvent->setCurrency("Eur");
        $sejourparisEvent->setCategory("Touristique");
        $sejourparisEvent->setCreatorUser($afaf);
        $sejourparisEvent->addParticipantUser($rayan);
        $sejourparisEvent->addParticipantUser($afaf);
        $rayan->addWholepayEvent($sejourparisEvent);
        $afaf->addWholepayEvent($sejourparisEvent);
        $manager->persist($rayan);
        $manager->persist($afaf);
        $manager->persist($sejourparisEvent);        
        $manager->flush();

        $restomergezExpense= new Expense();
        $restomergezExpense->setTitle("Resto merges");
        $restomergezExpense->setAmount(55);
        $restomergezExpense->setDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2022-05-26 14:52:10'));
        $restomergezExpense->setPaidByUser($rayan);
        $restomergezExpense->setWholepay($sejourparisEvent);
        $manager->persist($restomergezExpense);
        $sejourparisEvent->addWholepayExpense($restomergezExpense);

        $manager->persist($sejourparisEvent);
        $manager->flush();


        $rayanRestomergesAdvance= new Advance();
        $rayanRestomergesAdvance->setParticipantAmount(35);
        $rayanRestomergesAdvance->setExpense($restomergezExpense);
        $rayanRestomergesAdvance->setParticipantUser($rayan);
       
        $manager->persist( $rayanRestomergesAdvance);

       $afafRestomergesAdvance= new Advance();
       $afafRestomergesAdvance->setParticipantAmount(20);
       $afafRestomergesAdvance->setExpense($restomergezExpense);
       $afafRestomergesAdvance->setParticipantUser($afaf);
       
        $manager->persist( $afafRestomergesAdvance);
        $restomergezExpense->addAdvance($rayanRestomergesAdvance);
        $restomergezExpense->addAdvance($afafRestomergesAdvance);
        $manager->persist($restomergezExpense);
        $manager->flush();

 
        $visiteEiffelExpense= new Expense();
        $visiteEiffelExpense->setTitle("Visite Tours Eiffel");
        $visiteEiffelExpense->setAmount(55);
        $visiteEiffelExpense->setDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2022-05-26 14:52:10'));
        $visiteEiffelExpense->setPaidByUser($afaf);
        $visiteEiffelExpense->setWholepay($sejourparisEvent);
        $manager->persist($visiteEiffelExpense);
        $sejourparisEvent->addWholepayExpense($visiteEiffelExpense); 
        $manager->persist($sejourparisEvent);
        //$restomergezExpense->addAdvance()
        $manager->flush();


        $rayanVisiteEiffelAdvance= new Advance();
        $rayanVisiteEiffelAdvance->setParticipantAmount(60);
        $rayanVisiteEiffelAdvance->setExpense($visiteEiffelExpense);
        $rayanVisiteEiffelAdvance->setParticipantUser($rayan);
       
        $manager->persist($rayanVisiteEiffelAdvance);

       $afafVisiteEiffelAdvance= new Advance();
       $afafVisiteEiffelAdvance->setParticipantAmount(60);
       $afafVisiteEiffelAdvance->setExpense($visiteEiffelExpense);
       $afafVisiteEiffelAdvance->setParticipantUser($afaf);
       
        $manager->persist( $afafVisiteEiffelAdvance);
        $visiteEiffelExpense->addAdvance($rayanVisiteEiffelAdvance);
        $visiteEiffelExpense->addAdvance($afafVisiteEiffelAdvance);
        $manager->persist($visiteEiffelExpense);
        $manager->flush();
       
        // creation du wholepay sejour paris
        $conferenceEvent = new WholepayEvent();
        $conferenceEvent->setTitle("Conference scientifique Grenoble");
        $conferenceEvent->setDescription("pas de description");
        $conferenceEvent->setCurrency("Eur");
        $conferenceEvent->setCategory("Scientifique");
        $conferenceEvent->setCreatorUser($afaf);
        $conferenceEvent->addParticipantUser($rayan);
        $manager->persist($conferenceEvent);
        $afaf->addWholepayEvent($conferenceEvent);
        $manager->persist($afaf);
        $manager->flush();

        foreach($afaf->getWholepayEvents() as $event){
            echo $event->getTitle()."\n";
        }

        foreach ($sejourparisEvent->getWholepayExpense() as $expense){
           echo 'expense: '.$expense->getTitle();
            //echo $expense->getParticipantUser()->getFirstname()."\n";
        }        


        foreach ($restomergezExpense->getAdvances() as $advance){
            echo $advance->getParticipantAmount();
            echo $advance->getParticipantUser()->getFirstname()."\n";
        }

        foreach ($visiteEiffelExpense->getAdvances() as $advance){
            echo $advance->getParticipantAmount();
            echo $advance->getParticipantUser()->getFirstname()."\n";
        }        

 return;

        $Invitation= new Invitation();
        $Invitation->setEmail('email');
        $Invitation->setStatus('status');
        //$Invitation->setUser($user);
        //$Invitation->addUser($user);
        $Invitation->setWholepay($wholepayEvent);
        $manager->persist($Invitation);

        $manager->flush();


        

    }
}
