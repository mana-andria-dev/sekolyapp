<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Tenant, Classe, Teacher, Student, Subject, Assignment};

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ Créer 5 établissements (tenants) malagasy
        $tenants = Tenant::factory()->count(5)->create();

        foreach ($tenants as $tenant) {
            // 2️⃣ Créer 8 matières pour chaque établissement
            $subjects = Subject::factory()->count(8)->create([
                'tenant_id' => $tenant->id
            ]);

            // 3️⃣ Créer 10 enseignants pour chaque établissement
            $teachers = Teacher::factory()->count(10)->create([
                'tenant_id' => $tenant->id
            ]);

            // 4️⃣ Créer 5 classes pour chaque établissement
            $classes = Classe::factory()->count(5)->create([
                'tenant_id' => $tenant->id
            ]);

            // 5️⃣ Pour chaque classe
            $classes->each(function ($class) use ($subjects, $teachers) {

                // 5a. Créer 20 étudiants pour cette classe
                $students = Student::factory()->count(20)->create([
                    'tenant_id' => $class->tenant_id,
                ]);

                // 5b. Associer les étudiants à la classe via la table pivot
                $class->students()->attach($students->pluck('id'));

                // 5c. Associer 3 matières à la classe
                $class->subjects()->attach($subjects->random(3)->pluck('id'));

                // 5d. Associer 2 enseignants à la classe
                $class->teachers()->attach($teachers->random(2)->pluck('id'));

                // 5e. Créer 5 devoirs pour cette classe, chaque devoir lié à une matière et un enseignant
                Assignment::factory()->count(5)->create([
                    'class_id'   => $class->id,
                    'subject_id' => $subjects->random()->id,
                    'teacher_id' => $teachers->random()->id,
                ]);
            });
        }

        // 6️⃣ Optionnel : créer un super admin fixe
        \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@sekolypro.com',
            'password' => bcrypt('sekolypro'),
            'role' => 'superadmin',
        ]);
    }
}
