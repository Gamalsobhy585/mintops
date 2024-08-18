<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users
        $users = [
            ['name' => 'Islam Walid', 'email' => 'islamwalid@gmail.com', 'password' => 'IslamWalid123@'],
            ['name' => 'NourEldin Ahmed', 'email' => 'noureldinahmed@gmail.com', 'password' => 'NourEldinAhmed123@'],
            ['name' => 'Hisham Anwar', 'email' => 'hishamanwar@gmail.com', 'password' => 'HishamAnwar123@'],
            ['name' => 'Mohamed Abdelaziz', 'email' => 'mohamedabdelaziz@gmail.com', 'password' => 'MohamedAbdelaziz123@'],
            ['name' => 'Ahmed Assem', 'email' => 'ahmedassem@gmail.com', 'password' => 'AhmedAssem123@'],
            ['name' => 'Gamal Sobhy', 'email' => 'gamalsobhy@gmail.com', 'password' => 'GamalSobhy123@'],
        ];

        $createdUsers = [];
        
        foreach ($users as $user) {
            $createdUsers[$user['name']] = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
            ]);
        }

        // Create teams and assign leaders
        $teamData = [
            ['name' => 'Team A', 'leader' => 'Hisham Anwar'],
            ['name' => 'Team B', 'leader' => 'Gamal Sobhy'],
        ];

        foreach ($teamData as $team) {
            $teamRecord = Team::create([
                'name' => $team['name'],
                'leader_id' => $createdUsers[$team['leader']]->id,
            ]);

            // Assign the leader to the team
            $teamRecord->users()->attach($createdUsers[$team['leader']]->id);
        }
    }
}
