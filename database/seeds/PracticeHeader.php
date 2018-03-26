<?php

use Illuminate\Database\Seeder;
use App\Models\PracticeHeader as Header;
use App\Models\PracticeTarget as Target;

class PracticeHeader extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $distances = array(15,30,45);
        $photos = array(
            '2-2-20180317091538.jpeg',
            '2-3-20180317091557.jpeg',
            '2-4-20180317110608.jpeg',
            '2-6-20180321194140.jpg',
            '2-7-20180321194202.jpg',
            null,
            null
        );

        DB::table('practice_header')->where('id','>','0')->delete();
        DB::table('practice_targets')->where('id','>','0')->delete();

        for($i=1; $i<=60; $i++){

            $practiceHeader = new Header();
            $practiceHeader->date_time = date("Y-m-d H:i:s", mktime(12, 0, 0, 2, $i, 2018));
            $practiceHeader->user_id = 2;
            $practiceHeader->location_id = rand(1,2);
            $practiceHeader->gear_id = rand(1,2);
            $practiceHeader->ammo_id = rand(1,2);
            $practiceHeader->save();

            for($j=1; $j<=rand(3,8); $j++){
                $practiceTarget = new Target();
                $practiceTarget->header_id = $practiceHeader->id;
                $practiceTarget->value = rand(95,120);
                $practiceTarget->rounds = rand(10, 20);
                $practiceTarget->distance = $distances[rand(0,2)];
                $practiceTarget->photo = $photos[rand(0,6)];
                $practiceTarget->units = "ft";
                $practiceTarget->save();
            }
        }
    }
}
