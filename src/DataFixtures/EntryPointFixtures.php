<?php

namespace App\DataFixtures;

use App\Entity\EntryPoint;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EntryPointFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $entryPoints = [
            ['1', 'Trout Lake'],
            ['4', 'Crab Lake and Cummings from Burntside Lake'],
            ['6', 'Slim Lake'],
            ['7', 'Big Lake'],
            ['8', 'Moose River (south)'],
            ['9', 'Little Indian Sioux River (south)'],
            ['12', 'Little Vermilion Lake (Crane Lake)'],
            ['12A', 'Lac LaCroix Only'],
            ['14', 'Little Indian Sioux River (north)'],
            ['16', 'Moose/Portage River (north)'],
            ['19', 'Stuart River'],
            ['20', 'Angleworm Lake'],
            ['22', 'Mudro Lake (restricted--no camping on Horse Lake)'],
            ['23', 'Mudro Lake'],
            ['24', 'Fall Lake'],
            ['25', 'Moose Lake'],
            ['26', 'Wood Lake'],
            ['27', 'Snowbank Lake'],
            ['28', 'Snowbank Lake Only'],
            ['29', 'North Kawishiwi River'],
            ['30', 'Lake One'],
            ['31', 'Farm Lake'],
            ['32', 'South Kawishiwi River'],
            ['33', 'Little Gabbro Lake'],
            ['34', 'Island River'],
            ['35', 'Isabella Lake'],
            ['36', 'Hog Creek'],
            ['37', 'Kawishiwi Lake'],
            ['38', 'Sawbill Lake'],
            ['39', 'Baker Lake'],
            ['40', 'Homer Lake'],
            ['41', 'Brule Lake'],
            ['43', 'Bower Trout Lake'],
            ['44', 'Ram Lake'],
            ['45', 'Morgan Lake'],
            ['47', 'Lizz and Swamp Lakes'],
            ['48', 'Meeds Lake'],
            ['49', 'Skipper and Portage Lakes'],
            ['50', 'Cross Bay Lake'],
            ['51', 'Missing Link Lake'],
            ['52', 'Brant Lake'],
            ['54', 'Seagull Lake'],
            ['54A', 'Seagull Lake Only'],
            ['55', 'Saganaga Lake'],
            ['55A', 'Saganaga Lake Only'],
            ['57', 'Magnetic Lake'],
            ['58', 'South Lake'],
            ['60', 'Duncan Lake'],
            ['61', 'Daniels Lake'],
            ['62', 'Clearwater Lake'],
            ['64', 'East Bearskin Lake'],
            ['66', 'Crocodile River'],
            ['67', 'Bog Lake'],
            ['68', 'Pine Lake'],
            ['69', 'John Lake'],
            ['70', 'North Fowl Lake'],
            ['71', 'From CANADA'],
            ['75', 'Little Isabella River'],
            ['77', 'South Hegman Lake'],
            ['80', 'Larch Creek'],
            ['84', 'Snake River'],
        ];

        foreach ($entryPoints as [$number, $name]) {
            $entryPoint = new EntryPoint();
            $entryPoint->setNumber($number);
            $entryPoint->setName($name);
            
            $manager->persist($entryPoint);
        }

        $manager->flush();
    }
}