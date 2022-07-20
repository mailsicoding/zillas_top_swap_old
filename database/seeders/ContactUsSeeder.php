<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactUs;

class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContactUs::create([
            'name' => 'contact1',
            'email' => 'contact1@example.com',
            'message' => 'this is test message from contact1',
        ]);
    }
}
