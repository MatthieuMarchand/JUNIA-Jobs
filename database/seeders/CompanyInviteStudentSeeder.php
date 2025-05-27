<?php

namespace Database\Seeders;

use App\Models\CompanyInviteStudent;
use App\Models\CompanyProfile;
use App\Models\StudentProfile;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CompanyInviteStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companyProfiles = CompanyProfile::all();
        $studentProfiles = StudentProfile::all();

        if ($companyProfiles->isEmpty() || $studentProfiles->isEmpty()) {
            return;
        }

        $statuses = ['sent', 'read', 'accepted', 'declined', 'interview_scheduled', 'completed'];

        $invitationMessages = [
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean venenatis vitae neque sed viverra. Mauris sit amet aliquet ipsum. Aliquam quis tincidunt magna. Phasellus a quam mauris.',
            'Cras nec pharetra metus. Nullam faucibus turpis a sodales sodales. Fusce ac dapibus nisi. Vestibulum a augue vitae eros commodo tempor. Aliquam nisl quam, porttitor vel pulvinar sed, sollicitudin non dui. Fusce blandit enim at ultrices sollicitudin. In est felis, interdum ac felis vitae, lacinia pellentesque ligula. Phasellus facilisis neque elit, sed gravida leo scelerisque sed. Integer tempor mollis orci, mattis laoreet sapien euismod in. Vestibulum laoreet varius justo in vulputate. Nulla facilisi. ',
        ];

        // Pour chaque entreprise créer plusieur invitations
        foreach ($companyProfiles as $companyProfile) {
            // Sélectionner aléatoirement 3 à 6 étudiants
            $randomStudents = $studentProfiles->random(rand(3, min(6, count($studentProfiles))));

            foreach ($randomStudents as $studentProfile) {
                // Créer des invitations avec des dates et statuts variés
                CompanyInviteStudent::create([
                    'company_profile_id' => $companyProfile->id,
                    'student_profile_id' => $studentProfile->id,
                    'sent' => Carbon::now()->subDays(rand(1, 5)),
                    'invitation_date' => Carbon::now()->addDays(rand(5, 15)),
                    'invitation_details' => $invitationMessages[array_rand($invitationMessages)],
                    'invitation_status' => rand(0, 1) ? 'sent' : 'read',
                ]);

                if (rand(0, 1)) {
                    CompanyInviteStudent::create([
                        'company_profile_id' => $companyProfile->id,
                        'student_profile_id' => $studentProfile->id,
                        'sent' => Carbon::now()->subDays(rand(20, 60)),
                        'invitation_date' => Carbon::now()->subDays(rand(5, 15)),
                        'invitation_details' => $invitationMessages[array_rand($invitationMessages)],
                        'invitation_status' => $statuses[array_rand(array_slice($statuses, 2))], // acceptée, refusée, etc.
                    ]);
                }
            }
        }
    }
}
