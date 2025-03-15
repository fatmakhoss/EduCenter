<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ajouter des langues si elles n'existent pas
        $langues = [
            ['nom' => 'Français', 'code' => 'fr', 'description' => 'Langue française', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Anglais', 'code' => 'en', 'description' => 'Langue anglaise', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Arabe', 'code' => 'ar', 'description' => 'Langue arabe', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
        ];
        
        // Vérifier si les langues existent déjà
        if (DB::table('langues')->count() == 0) {
            DB::table('langues')->insert($langues);
            $this->command->info('Langues ajoutées avec succès.');
        } else {
            $this->command->info('Les langues existent déjà.');
        }
        
        // Ajouter des niveaux sans la colonne description
        $niveaux = [
            ['nom' => 'A1 - Débutant', 'langue_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'A2 - Élémentaire', 'langue_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'B1 - Intermédiaire', 'langue_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'B2 - Avancé', 'langue_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'C1 - Autonome', 'langue_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Beginner', 'langue_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Elementary', 'langue_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Intermediate', 'langue_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Advanced', 'langue_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        ];
        
        // Vérifier si les niveaux existent déjà
        if (DB::table('niveaux')->count() == 0) {
            DB::table('niveaux')->insert($niveaux);
            $this->command->info('Niveaux ajoutés avec succès.');
        } else {
            $this->command->info('Les niveaux existent déjà.');
        }
        
        // Ajouter des inscriptions
        $inscriptions = [
            [
                'langue_id' => 1,
                'niveau_id' => 1,
                'name' => 'Jean Dupont',
                'email' => 'jean.dupont@example.com',
                'pays' => 'France',
                'telephone' => '+33600000000',
                'status' => 'pending',
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'langue_id' => 1,
                'niveau_id' => 3,
                'name' => 'Marie Martin',
                'email' => 'marie.martin@example.com',
                'pays' => 'Belgique',
                'telephone' => '+32400000000',
                'status' => 'pending',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'langue_id' => 2,
                'niveau_id' => 6,
                'name' => 'John Smith',
                'email' => 'john.smith@example.com',
                'pays' => 'Royaume-Uni',
                'telephone' => '+44700000000',
                'status' => 'pending',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'langue_id' => 2,
                'niveau_id' => 8,
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@example.com',
                'pays' => 'États-Unis',
                'telephone' => '+15550000000',
                'status' => 'pending',
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay(),
            ],
        ];
        
        // Vérifier si les inscriptions existent déjà
        if (DB::table('inscriptions')->count() == 0) {
            DB::table('inscriptions')->insert($inscriptions);
            $this->command->info('Inscriptions ajoutées avec succès.');
        } else {
            $this->command->info('Les inscriptions existent déjà.');
        }

        // Ajouter des inscriptions aux cours
        $courseRegistrations = [
            [
                'full_name' => 'Ahmed Mohamed',
                'email' => 'ahmed.mohamed@example.com',
                'country' => 'Égypte',
                'phone' => '+20100000000',
                'course' => 'Français A1',
                'level' => 'Débutant',
                'status' => 'pending',
                'created_at' => Carbon::now()->subDays(6),
                'updated_at' => Carbon::now()->subDays(6),
            ],
            [
                'full_name' => 'Fatima Ali',
                'email' => 'fatima.ali@example.com',
                'country' => 'Maroc',
                'phone' => '+212600000000',
                'course' => 'Français B2',
                'level' => 'Avancé',
                'status' => 'pending',
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
            ],
            [
                'full_name' => 'Li Wei',
                'email' => 'li.wei@example.com',
                'country' => 'Chine',
                'phone' => '+8613000000000',
                'course' => 'Anglais Débutant',
                'level' => 'A1',
                'status' => 'pending',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'full_name' => 'Carlos Rodriguez',
                'email' => 'carlos.rodriguez@example.com',
                'country' => 'Espagne',
                'phone' => '+34600000000',
                'course' => 'Anglais Intermédiaire',
                'level' => 'B1',
                'status' => 'pending',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
        ];
        
        // Vérifier si les inscriptions aux cours existent déjà
        if (DB::table('course_registrations')->count() == 0) {
            DB::table('course_registrations')->insert($courseRegistrations);
            $this->command->info('Inscriptions aux cours ajoutées avec succès.');
        } else {
            $this->command->info('Les inscriptions aux cours existent déjà.');
        }
    }
} 