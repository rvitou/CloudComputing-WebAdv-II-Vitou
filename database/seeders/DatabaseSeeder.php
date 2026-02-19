<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Models\Coach;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\Exercise;
use App\Models\LiveSession;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // -- 1. CREATE ADMIN USER --
        User::firstOrCreate(
            ['email' => 'admin@topfitness.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'password' => Hash::make('password'),
                'account_type' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // -- 2. CREATE YOUR SUBSCRIPTION PLANS --
        $plans = [
            ['name' => 'Monthly', 'description' => 'Access for 30 days.', 'duration_days' => 30, 'price' => 16.00],
            ['name' => 'Semi-Annual', 'description' => 'Access for 180 days.', 'duration_days' => 180, 'price' => 66.00],
            ['name' => 'Annual', 'description' => 'Access for 360 days.', 'duration_days' => 360, 'price' => 96.00],
        ];
        foreach ($plans as $planData) {
            SubscriptionPlan::firstOrCreate(['name' => $planData['name']], $planData);
        }
        $allPlans = SubscriptionPlan::all();


        // -- 3. CREATE YOUR 10 COACHES --
        $coachUsersData = [
            ['first_name' => 'Jane', 'last_name' => 'Doe', 'gender' => 'female', 'specialization' => 'Strength Training', 'certification' => 'CPT', 'years_of_experience' => 5],
            ['first_name' => 'Mike', 'last_name' => 'Ross', 'gender' => 'male', 'specialization' => 'Cardio & Endurance', 'certification' => 'ACE', 'years_of_experience' => 8],
            ['first_name' => 'Sarah', 'last_name' => 'Connor', 'gender' => 'female', 'specialization' => 'Yoga & Flexibility', 'certification' => 'RYT-200', 'years_of_experience' => 10],
            ['first_name' => 'Chris', 'last_name' => 'Lee', 'gender' => 'male', 'specialization' => 'HIIT', 'certification' => 'CPT', 'years_of_experience' => 4],
            ['first_name' => 'Emily', 'last_name' => 'Clark', 'gender' => 'female', 'specialization' => 'Pilates', 'certification' => 'Stott Pilates', 'years_of_experience' => 6],
            ['first_name' => 'David', 'last_name' => 'Chen', 'gender' => 'male', 'specialization' => 'Bodybuilding', 'certification' => 'IFBB Pro', 'years_of_experience' => 12],
            ['first_name' => 'Jessica', 'last_name' => 'Alba', 'gender' => 'female', 'specialization' => 'Functional Fitness', 'certification' => 'FMS', 'years_of_experience' => 7],
            ['first_name' => 'Tom', 'last_name' => 'Hardy', 'gender' => 'male', 'specialization' => 'CrossFit', 'certification' => 'CF-L1', 'years_of_experience' => 5],
            ['first_name' => 'Olivia', 'last_name' => 'Wilde', 'gender' => 'female', 'specialization' => 'Wellness Coaching', 'certification' => 'CHC', 'years_of_experience' => 9],
            ['first_name' => 'Ben', 'last_name' => 'Affleck', 'gender' => 'male', 'specialization' => 'Athletic Performance', 'certification' => 'CSCS', 'years_of_experience' => 15],
        ];

        foreach ($coachUsersData as $data) {
            $user = User::firstOrCreate(
                ['email' => strtolower($data['first_name']).'.'.strtolower($data['last_name']).'@topfitness.com'],
                [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'password' => Hash::make('password'),
                    'account_type' => 'coach',
                    'gender' => $data['gender'],
                    'dob' => Carbon::now()->subYears(30)->subDays(rand(0, 365)),
                    'email_verified_at' => now(),
                ]
            );
            Coach::firstOrCreate(['user_id' => $user->id], [
                'specialization' => $data['specialization'],
                'certification' => $data['certification'],
                'years_of_experience' => $data['years_of_experience'],
            ]);
        }
        $allCoaches = Coach::all();


        // -- 4. CREATE YOUR 15 STUDENTS --
        $studentUsersData = [
            ['first_name' => 'John', 'last_name' => 'Smith'], ['first_name' => 'Peter', 'last_name' => 'Jones'],
            ['first_name' => 'Mary', 'last_name' => 'Williams'], ['first_name' => 'Susan', 'last_name' => 'Brown'],
            ['first_name' => 'William', 'last_name' => 'Davis'], ['first_name' => 'Patricia', 'last_name' => 'Miller'],
            ['first_name' => 'Robert', 'last_name' => 'Wilson'], ['first_name' => 'Jennifer', 'last_name' => 'Moore'],
            ['first_name' => 'Michael', 'last_name' => 'Taylor'], ['first_name' => 'Linda', 'last_name' => 'Anderson'],
            ['first_name' => 'James', 'last_name' => 'Thomas'], ['first_name' => 'Elizabeth', 'last_name' => 'Jackson'],
            ['first_name' => 'John', 'last_name' => 'White'], ['first_name' => 'Barbara', 'last_name' => 'Harris'],
            ['first_name' => 'Richard', 'last_name' => 'Martin'],
        ];

        foreach ($studentUsersData as $data) {
            $user = User::firstOrCreate(
                ['email' => strtolower($data['first_name']).'.'.strtolower($data['last_name']).'@email.com'],
                [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'password' => Hash::make('password'),
                    'account_type' => 'student',
                    'gender' => (rand(0, 1) == 0) ? 'male' : 'female',
                    'dob' => Carbon::now()->subYears(25)->subDays(rand(0, 365)),
                    'email_verified_at' => now(),
                ]
            );
            Student::firstOrCreate(['user_id' => $user->id], [
                'height' => rand(150, 190),
                'weight' => rand(55, 95),
            ]);
        }
        $allStudents = Student::all();

        // -- 5. CREATE YOUR SUBSCRIPTIONS FOR STUDENTS --
        foreach ($allStudents->take(12) as $student) {
            $plan = $allPlans->random();
            $coach = $allCoaches->random();
            $isExpired = (rand(1, 3) == 1); 
            $startDate = $isExpired 
                ? now()->subDays($plan->duration_days + rand(5, 30)) 
                : now()->subDays(rand(0, $plan->duration_days - 1));
            
            $endDate = (clone $startDate)->addDays($plan->duration_days);

            Subscription::firstOrCreate(
                ['student_id' => $student->id, 'plan_id' => $plan->id],
                [
                    'coach_id' => $coach->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'is_active' => !$isExpired,
                ]
            );
        }

        // ==================================================================
        // === THE ONLY CHANGE IS HERE: Updated video URLs ===
        // 6. CREATE YOUR 20 EXERCISES
        // ==================================================================
        $exercises = [
            ['name' => 'Barbell Bench Press', 'category' => 'Strength', 'video_url' => 'https://www.youtube.com/watch?v=gRVjAtPip0Y'],
            ['name' => 'Deadlift', 'category' => 'Strength', 'video_url' => 'https://www.youtube.com/watch?v=ytGaGIn3SjE'],
            ['name' => 'Overhead Press', 'category' => 'Strength', 'video_url' => 'https://www.youtube.com/watch?v=2yjwXTZQDDI'],
            ['name' => 'Bent Over Row', 'category' => 'Strength', 'video_url' => 'https://www.youtube.com/watch?v=vT2GjY_Umpw'],
            ['name' => 'Pull-ups', 'category' => 'Bodyweight', 'video_url' => 'https://www.youtube.com/watch?v=eGo4IYlbE5g'],
            ['name' => 'Dips', 'category' => 'Bodyweight', 'video_url' => 'https://www.youtube.com/watch?v=2z8JmcrW-As'],
            ['name' => 'Leg Press', 'category' => 'Strength', 'video_url' => 'https://www.youtube.com/watch?v=IZxysobcM-M'],
            ['name' => 'Bicep Curls', 'category' => 'Isolation', 'video_url' => 'https://www.youtube.com/watch?v=ykJmrZ5v0Oo'],
            ['name' => 'Tricep Extensions', 'category' => 'Isolation', 'video_url' => 'https://www.youtube.com/watch?v=2-LAMcpzODU'],
            ['name' => 'Lateral Raises', 'category' => 'Isolation', 'video_url' => 'https://www.youtube.com/watch?v=3VcKaXpzqRo'],
            ['name' => 'Calf Raises', 'category' => 'Isolation', 'video_url' => 'https://www.youtube.com/watch?v=JbyjN43haPs'],
            ['name' => 'Crunches', 'category' => 'Core', 'video_url' => 'https://www.youtube.com/watch?v=Xyd_fa5zoEU'],
            ['name' => 'Leg Raises', 'category' => 'Core', 'video_url' => 'https://www.youtube.com/watch?v=JB2oyawG9KI'],
            ['name' => 'Russian Twists', 'category' => 'Core', 'video_url' => 'https://www.youtube.com/watch?v=wkD8rjkodUI'],
            ['name' => 'Treadmill Running', 'category' => 'Cardio', 'video_url' => 'https://www.youtube.com/watch?v=5-y7e42-J_M'],
            ['name' => 'Cycling', 'category' => 'Cardio', 'video_url' => 'https://www.youtube.com/watch?v=GLy2rMpkB3E'],
            ['name' => 'Jumping Jacks', 'category' => 'Cardio', 'video_url' => 'https://www.youtube.com/watch?v=n_3qk_j5v2M'],
            ['name' => 'Burpees', 'category' => 'HIIT', 'video_url' => 'https://www.youtube.com/watch?v=dZgVxmf6jkA'],
            ['name' => 'Mountain Climbers', 'category' => 'HIIT', 'video_url' => 'https://www.youtube.com/watch?v=cnyTQDSE884'],
            ['name' => 'Box Jumps', 'category' => 'Plyometrics', 'video_url' => 'https://www.youtube.com/watch?v=52r_D4I9MvQ'],
        ];

        foreach($exercises as $ex) {
            Exercise::firstOrCreate(['name' => $ex['name']], [
                'category' => $ex['category'],
                'description' => 'A sample description for ' . $ex['name'] . '.',
                'video_url' => $ex['video_url'],
                'coach_id' => $allCoaches->random()->id
            ]);
        }

        // -- 7. CREATE YOUR LIVE SESSIONS --
        $sessionsToCreate = [
            ['title' => 'Morning Core Blast', 'description' => 'A 45-minute session focusing on core strength and stability.', 'start_time' => Carbon::parse('2025-07-01 09:00:00'), 'end_time' => Carbon::parse('2025-07-01 09:45:00'), 'join_url' => 'https://meet.google.com/abc-defg-hij', 'status' => 'scheduled'],
            ['title' => 'Evening Stretch & Mobility', 'description' => 'Relax and improve flexibility with this evening session.', 'start_time' => Carbon::parse('2025-07-02 18:30:00'), 'end_time' => Carbon::parse('2025-07-02 19:15:00'), 'join_url' => 'https://meet.google.com/klm-nopq-rst', 'status' => 'scheduled'],
            ['title' => 'HIIT Express', 'description' => 'A quick and intense high-intensity interval training session.', 'start_time' => Carbon::parse('2025-06-25 12:00:00'), 'end_time' => Carbon::parse('2025-06-25 12:30:00'), 'join_url' => 'https://meet.google.com/uvw-xyza-bcd', 'status' => 'completed'],
            ['title' => 'Beginner Yoga Flow', 'description' => 'Introduction to basic yoga poses and breathing techniques.', 'start_time' => Carbon::parse('2025-07-05 10:00:00'), 'end_time' => Carbon::parse('2025-07-05 11:00:00'), 'join_url' => 'https://meet.google.com/efg-hijk-lmn', 'status' => 'scheduled'],
            ['title' => 'Strength Circuit Training', 'description' => 'Full-body strength workout with various exercises in a circuit format.', 'start_time' => Carbon::parse('2025-06-20 17:00:00'), 'end_time' => Carbon::parse('2025-06-20 18:00:00'), 'join_url' => 'https://meet.google.com/opq-rst-uvw', 'status' => 'completed'],
            ['title' => 'Cardio Kickboxing', 'description' => 'High-energy workout combining cardio with kickboxing moves.', 'start_time' => Carbon::parse('2025-07-08 16:00:00'), 'end_time' => Carbon::parse('2025-07-08 17:00:00'), 'join_url' => 'https://meet.google.com/xyz-abcd-efg', 'status' => 'scheduled'],
            ['title' => 'Restorative Pilates', 'description' => 'Gentle Pilates session to improve flexibility and core strength.', 'start_time' => Carbon::parse('2025-07-10 11:00:00'), 'end_time' => Carbon::parse('2025-07-10 11:45:00'), 'join_url' => 'https://meet.google.com/hij-klmn-opq', 'status' => 'scheduled'],
            ['title' => 'Advanced Weightlifting', 'description' => 'A session for experienced lifters focusing on compound movements.', 'start_time' => Carbon::parse('2025-07-12 14:00:00'), 'end_time' => Carbon::parse('2025-07-12 15:30:00'), 'join_url' => 'https://meet.google.com/rst-uvw-xyz', 'status' => 'scheduled'],
            ['title' => 'Mindful Meditation', 'description' => 'A session to clear your mind and practice mindfulness.', 'start_time' => Carbon::parse('2025-06-28 08:00:00'), 'end_time' => Carbon::parse('2025-06-28 08:30:00'), 'join_url' => 'https://meet.google.com/fgh-ijkl-mno', 'status' => 'completed'],
            ['title' => 'Functional Fitness', 'description' => 'Exercises to improve everyday movements and overall functional strength.', 'start_time' => Carbon::parse('2025-07-15 10:00:00'), 'end_time' => Carbon::parse('2025-07-15 11:00:00'), 'join_url' => 'https://meet.google.com/pqr-stuv-wxy', 'status' => 'scheduled'],
        ];

        foreach ($sessionsToCreate as $sessionData) {
            LiveSession::firstOrCreate(
                ['title' => $sessionData['title'], 'coach_id' => $allCoaches->random()->id],
                array_merge($sessionData, ['coach_id' => $allCoaches->random()->id])
            );
        }
    }
}
