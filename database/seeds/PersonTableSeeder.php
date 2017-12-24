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
        $recordsPerson = factory(Person::class, rand(6, 20))->create();
        
        foreach($recordsPerson as $recordPerson) {
            if(rand(1, 2) % 2 === 0 && ($id = rand(1, Person::count())) !== $recordPerson->id) {
                $recordPerson->person_id = $id;
            }
        }
    }
}
