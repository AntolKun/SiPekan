<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Superadmin
    User::create([
      'name' => 'Super Admin',
      'email' => 'superadmin@tokoikan.com',
      'password' => Hash::make('superadmin123'),
      'role' => 'superadmin',
    ]);

    // Admin
    User::create([
      'name' => 'Admin',
      'email' => 'admin@tokoikan.com',
      'password' => Hash::make('admin123'),
      'role' => 'admin',
    ]);

    // Kasir
    User::create([
      'name' => 'Kasir',
      'email' => 'kasir@tokoikan.com',
      'password' => Hash::make('kasir123'),
      'role' => 'kasir',
    ]);
  }
}
