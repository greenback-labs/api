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
        factory(Person::class, rand(20, 80))->create()->each(function($recordPerson) {
            if(rand(1, 2) % 2 === 0 && ($id = $this->randomPersonId([$recordPerson->id]))) {
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
    private function randomPersonId(Array $except = [])
    {
        do {
            $id = rand(Person::min('id') ?: 0, Person::count())
        } while(in_array($id, $except));
        
        return Person::find($id) ?: null;
    }
}
