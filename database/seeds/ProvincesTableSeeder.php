<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinces = (array) [
            ["id" => "11", "iso" => "ac", "name" => "aceh", "capital" => "banda aceh", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "51", "iso" => "ba", "name" => "bali", "capital" => "denpasar", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "19", "iso" => "bb", "name" => "bangka-belitung", "capital" => "pangkalpinang", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "36", "iso" => "bt", "name" => "banten", "capital" => "serang", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "17", "iso" => "be", "name" => "bengkulu", "capital" => "bengkulu", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "75", "iso" => "go", "name" => "gorontalo", "capital" => "gorontalo", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "31", "iso" => "jk", "name" => "jakarta raya", "capital" => "jakarta", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "15", "iso" => "ja", "name" => "jambi", "capital" => "jambi (telanaipura)", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "32", "iso" => "jb", "name" => "jawa barat", "capital" => "bandung", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "33", "iso" => "jt", "name" => "jawa tengah", "capital" => "semarang", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "35", "iso" => "ji", "name" => "jawa timur", "capital" => "surabaya", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "61", "iso" => "kb", "name" => "kalimantan barat", "capital" => "pontianak", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "63", "iso" => "ks", "name" => "kalimantan selatan", "capital" => "banjarmasin", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "62", "iso" => "kt", "name" => "kalimantan tengah", "capital" => "palangkaraya", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "64", "iso" => "ki", "name" => "kalimantan timur", "capital" => "samarinda", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "65", "iso" => "ku", "name" => "kalimantan utara", "capital" => "tanjung selor", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "21", "iso" => "kr", "name" => "kepulauan riau", "capital" => "tanjung pinang", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "18", "iso" => "la", "name" => "lampung", "capital" => "bandar lampung", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "81", "iso" => "ma", "name" => "maluku", "capital" => "ambon", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "82", "iso" => "mu", "name" => "maluku utara", "capital" => "sofifi", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "52", "iso" => "nb", "name" => "nusa tenggara barat", "capital" => "mataram", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "53", "iso" => "nt", "name" => "nusa tenggara timur", "capital" => "kupang", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "94", "iso" => "pa", "name" => "papua", "capital" => "jayapura", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "91", "iso" => "pb", "name" => "papua barat", "capital" => "manokwari", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "14", "iso" => "ri", "name" => "riau", "capital" => "pekanbaru", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "76", "iso" => "sr", "name" => "sulawesi barat", "capital" => "mamuju", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "73", "iso" => "sn", "name" => "sulawesi selatan", "capital" => "makassar", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "72", "iso" => "st", "name" => "sulawesi tengah", "capital" => "palu", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "74", "iso" => "sg", "name" => "sulawesi tenggara", "capital" => "kendari", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "71", "iso" => "sa", "name" => "sulawesi utara", "capital" => "manado", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "13", "iso" => "sb", "name" => "sumatera barat", "capital" => "padang", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "16", "iso" => "ss", "name" => "sumatera selatan", "capital" => "palembang", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "12", "iso" => "su", "name" => "sumatera utara", "capital" => "medan", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["id" => "34", "iso" => "yo", "name" => "yogyakarta", "capital" => "yogyakarta", "iso_country" => "id", "created_at" => Carbon::now(), "updated_at" => Carbon::now()]
        ];

        foreach ($provinces as $province) {
            DB::table('m_provinces')->insert($province);
        }
    }
}
