<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('addresses')->insert([
            'zip_code' => '96960-000',
            'city' => 'Encantado',
            'street' => 'Rua Duque de Caxias',
            'neighborhood' => 'Centro',
            'number' => '1400',
        ]);

        DB::table('establishments')->insert([
            'name' => 'Basileus Pizzaria',
            'cnpj' => '83.627.380/0001-16',
            'phone_number' => '(51) 99999-9999',
            'description' => 'Test Description',
            'address_id' => 1
        ]);

        DB::table('users')->insert([
            'email' => 'basileus@gmail.com',
            'password' => Hash::make('basileus123', [ 'sha256' ]),
            'is_admin' => false,
            'establishment_id' => 1
        ]);

        DB::table('users')->insert([
            'email' => 'clienteteste@teste.com',
            'password' => Hash::make('teste123', [ 'sha256' ]),
            'is_admin' => false,
        ]);

        DB::table('clients')->insert([
            'name' => 'Test Client',
            'cpf' => '123.456.789-10',
            'date_birth' => '1999-01-01',
            'phone_number' => '(51) 99999-9999',
            'user_id' => 2
        ]);

        DB::table('users')->insert([
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123', [ 'sha256' ]),
            'is_admin' => true,
        ]);

        DB::table('clients')->insert([
            'name' => 'Admin',
            'cpf' => '123.456.789-00',
            'date_birth' => '1999-01-01',
            'phone_number' => '(51) 99999-9999',
            'user_id' => 3
        ]);
    }
}
