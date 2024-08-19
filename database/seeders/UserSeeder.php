<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
   
    public function run(): void
    {
      
        $users = [
            ['name' => 'Islam Walid', 'email' => 'islamwalid@gmail.com', 'password' => 'IslamWalid123@', 'password_confirmation' => 'IslamWalid123@', 'role' => 'member'],
            ['name' => 'NourEldin Ahmed', 'email' => 'noureldinahmed@gmail.com', 'password' => 'NourEldinAhmed123@', 'password_confirmation' => 'NourEldinAhmed123@', 'role' => 'member'],
            ['name' => 'Hisham Anwar', 'email' => 'hishamanwar@gmail.com', 'password' => 'HishamAnwar123@', 'password_confirmation' => 'HishamAnwar123@', 'role' => 'leader'],
            ['name' => 'Mohamed Abdelaziz', 'email' => 'mohamedabdelaziz@gmail.com', 'password' => 'MohamedAbdelaziz123@', 'password_confirmation' => 'MohamedAbdelaziz123@', 'role' => 'member'],
            ['name' => 'Ahmed Assem', 'email' => 'ahmedassem@gmail.com', 'password' => 'AhmedAssem123@', 'password_confirmation' => 'AhmedAssem123@', 'role' => 'member'],
            ['name' => 'Gamal Sobhy', 'email' => 'gamalsobhy@gmail.com', 'password' => 'GamalSobhy123@', 'password_confirmation' => 'GamalSobhy123@', 'role' => 'leader'],
        ];

        $createdUsers = [];
        
        foreach ($users as $user) {
            $createdUsers[$user['name']] = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'role' => $user['role'], 
            ]);
        }

   
        $teamData = [
            ['name' => 'Team A', 'leader' => 'Hisham Anwar'],
            ['name' => 'Team B', 'leader' => 'Gamal Sobhy'],
        ];

        foreach ($teamData as $team) {
            $teamRecord = Team::create([
                'name' => $team['name'],
                'leader_id' => $createdUsers[$team['leader']]->id,
            ]);

      
            $teamRecord->users()->attach($createdUsers[$team['leader']]->id);
        }
    }
}
