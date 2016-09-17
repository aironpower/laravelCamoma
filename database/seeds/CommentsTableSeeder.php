<?php 

use App\Comment;
use Illuminate\Database\Seeder;

Class CommentsTableSeeder extends Seeder {
	public function run() {
		$faker = Faker\Factory::create();
		Comment::truncate();

		for ($i=0; $i <10; $i++) { 
			$comment = Comment::create(array(
				'user_id'=>$faker->numberBetween($min = 1, $max =3),
				'post_id'=>$faker->numberBetween($min = 1, $max =10),
				'comment'=>$faker->realText(100),
				));
		}
	}
}