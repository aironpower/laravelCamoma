<?php 

use App\Post;
use Illuminate\Database\Seeder;

Class PostsTableSeeder extends Seeder {
	public function run() {
		$faker = Faker\Factory::create();
		Post::truncate();

		for ($i=0; $i <10; $i++) { 
			$painting = Post::create(array(
				'title'=>$faker->realText(rand(20,40)),
				'poster'=>'1',
				'description'=>$faker->realText(100),
				));
		}
	}
}