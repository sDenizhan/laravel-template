<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = json_decode(file_get_contents('https://restcountries.com/v3.1/all'), true);

        $countriesArray = [];

        foreach ($countries as $country) {
            $countriesArray[] = [
                "name" => $country["translations"]["tur"]["common"] ?? $country["name"]["common"],
                "code" => $country["cca2"],
                "alpha3" => $country["cca3"],
                "phone_code" => isset($country["idd"]["root"]) ? $country["idd"]["root"] . (isset($country["idd"]["suffixes"]) ? $country["idd"]["suffixes"][0] : '') : ''
            ];
        }

        foreach ($countriesArray as $country) {
            $id = \App\Models\Country::create([
                'code' => $country['code'],
                'code_alpha3' => $country['alpha3'],
                'phone_code' => $country['phone_code']
            ]);

            $id->translations()->create([
                'country_id' => $id->id,
                'name' => $country['name'],
                'locale' => 'tr'
            ]);
        }

    }
}
