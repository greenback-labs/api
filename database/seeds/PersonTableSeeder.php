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
            if(rand(1, 2) % 2 === 0 && ($id = PersonTableSeeder::randomPersonId([$recordPerson->id]))) {
                $recordPerson->person_id = $id;
                $recordPerson->save();
            }
        });
    }

    /**
     * Get an random person.
     *
     * @return int
     */
    public static function randomPersonId(Array $except = [])
    {
        do {
            $id = rand(Person::min('id') ?: 0, Person::count());
        } while(in_array($id, $except));
        
        return $id ?: null;
    }
}
