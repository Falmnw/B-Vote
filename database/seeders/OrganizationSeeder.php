<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = [
            // Religion and Society
            "AIESEC in BINUS",
            "BINUS Square Student Committee (BSSC)",
            "Keluarga Besar Mahasiswa Khonghuchu (KBMK)",
            "Keluarga Mahasiswa Buddhis Dhammavaddhana (KMBD)",
            "Keluarga Mahasiswa Hindu (KMH)",
            "Keluarga Mahasiswa Katolik (KMK)",
            "Majelis Ta’lim (MT) Al Khawarizmi",
            "Persekutuan Oikumene (PO)",
            "TFI Student Community (TFI SC)",

            // Reasoning and Knowledge
            "Binus Entrepreneur (B-Preneur)",
            "Binus Game Development Club (BGDC)",
            "Binus Business International Club (BIC)",
            "Bina Nusantara Computer Club (BNCC)",
            "BINUS English Club (BNEC)",
            "Bina Nusantara Finance Club (BNFC)",
            "Binus Mandarin Club (BNMC)",
            "Binus Student Learning Community (BSLC)",
            "Cyber Security Community (CSC)",
            "International Marketing Community of Binus (IMCB)",
            "ISACA Student Group (ISG)",
            "Nippon Club",
            "Data Science Club (DSC)",

            // Arts and Information Media
            "B-Voice Radio",
            "Band",
            "Bersama Dalam Musik (BDM)",
            "BINUS TV Club",
            "Klub Seni Fotografi Bina Nusantara (KLIFONARA)",
            "Paduan Suara Mahasiswa Bina Nusantara (PARAMABIRA)",
            "Seni Tari Mahasiswa Bina Nusantara (STAMANARA)",
            "Seni Teater Mahasiswa Bina Nusantara (STMANIS)",
            "Modeling Club BINUS (MCB)",
            "Pojok Aksi dan Informasi Bina Nusantara (Panorama)",

            // Sports and Martial Arts
            "Aikido",
            "Binus Badminton",
            "Bina Nusantara Swimming Club (BASIC)",
            "Basket",
            "Futsal",
            "Mahasiswa Bina Nusantara Pencinta Alam (SWANARAPALA)",
            "Volley",
            "Wushu",
            "Hapkido",
            "Binusian Gaming"
        ];
        foreach($organizations as $name){
            Organization::create([
                'name' => $name,
            ]);
        }
    }
}
