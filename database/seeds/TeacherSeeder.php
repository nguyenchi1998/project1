<?php

use App\Models\Media;
use App\Models\ProfessionalGroup;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $path = $faker->image(
            storage_path(config('default.path.app_public')),
            config('default.avatar_size'),
            config('default.avatar_size')
        );
        $teacher = Teacher::create([
            'name' => 'Teacher Chi',
            'gender' => 1,
            'birthday' => Carbon::now(),
            'email' => 'teacher@gmail.com',
            'password' => Hash::make(config('default.auth.password')),
            'address' => $faker->address(),
        ]);
        $media = Media::create([
            'path' => str_replace(
                storage_path(config('default.path.app_public')),
                '',
                $path
            ),
        ]);
        $teacher->avatar()->save($media);
        $teacher->update([
            'professional_group_id' => 1,
        ]);
        $professionalGroupIds = ProfessionalGroup::all()->pluck('id')->toArray();
        factory(Teacher::class, 50)->create()
            ->each(function ($teacher) use ($professionalGroupIds, $path) {
                $media = Media::create([
                    'path' => str_replace(storage_path(config('default.path.app_public')), '', $path),
                ]);
                $teacher->avatar()->save($media);
                $teacher->update([
                    'professional_group_id' => $professionalGroupIds[array_rand($professionalGroupIds)]
                ]);
            });
    }
}
