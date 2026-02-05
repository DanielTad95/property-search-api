<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;
use Illuminate\Support\Facades\File;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Property::truncate();

        $csvFile = base_path('property-data.csv');
        
        if (!File::exists($csvFile)) {
            $this->command->error('CSV file not found!');
            return;
        }

        $file = fopen($csvFile, 'r');
        fgetcsv($file); // Skip header
        
        while (($row = fgetcsv($file)) !== false) {
            Property::create([
                'name' => $row[0],
                'price' => $row[1],
                'bedrooms' => $row[2],
                'bathrooms' => $row[3],
                'storeys' => $row[4],
                'garages' => $row[5],
            ]);
        }
        
        fclose($file);
        
        $this->command->info('Properties imported successfully!');
    }
}
