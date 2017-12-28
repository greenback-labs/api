<?php

use Illuminate\Database\Seeder;
use App\Person;

class PersonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $minRecords = 20;
        $maxRecords = 80;

        factory(Person::class, rand($minRecords, $maxRecords))->create()->each(function($recordPerson) {
            $except = PersonTableSeeder::getRecursiveRecordsId($recordPerson);
            array_push($except, $recordPerson->id);
            
            if(rand(1, 2) % 2 === 0 && ($id = PersonTableSeeder::randomPersonId($except))) {
                $recordPerson->person_id = $id;
                $recordPerson->save();
            }
        });
    }

    /**
     * Get an random person id.
     *
     * @param  array  $except
     * @return int
     */
    public static function randomPersonId(array $except = [])
    {
        do {
            $id = rand(Person::min('id') ?: 0, Person::count());
        } while(in_array($id, $except));
        
        return $id ?: null;
    }


    /**
     * Get an array containing the person id of recursive records.
     *
     * @param  \App\Person  $recordPerson
     * @return array
     */
    public static function getRecursiveRecordsId(Person $recordPerson)
    {
        $recursiveRecordsId = [];
        $currentPerson = $recordPerson;
        
        while($currentPerson = $currentPerson->recordPerson) {
            array_push($recursiveRecordsId, $currentPerson->id);
        }

        return $recursiveRecordsId;
    }
}
