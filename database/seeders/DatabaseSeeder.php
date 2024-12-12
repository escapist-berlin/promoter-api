<?php

namespace Database\Seeders;

use App\Models\Promoter;
use App\Models\PromoterGroup;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $promoterGroupsData = [
            [
                'name' => 'Latte-Art Baristas',
                'description' => 'Diese Gruppe besteht aus Baristas, die sich durch ihre Latte-Art-Fähigkeiten auszeichnen und umfassende Kenntnisse im Umgang mit Kaffeezubereitung und Espressomaschinen haben. Sie sind Experten für die Bedienung von Siebträgermaschinen und die perfekte Zubereitung von Milchkaffeegetränken.',
                'skills' => [
                    ['name' => 'Latte-Art-Zertifikat', 'description' => 'Fähigkeit, fortgeschrittene Latte-Art-Techniken zu beherrschen und ein offizielles Zertifikat zu besitzen.'],
                    ['name' => 'Kenntnisse in Kaffeeröstung', 'description' => 'Verständnis für den Röstprozess von Kaffeebohnen, einschließlich der Auswahl, Temperatursteuerung und sensorischen Beurteilung.'],
                    ['name' => 'Bedienung von Siebträgermaschinen', 'description' => 'Fachkenntnisse im professionellen Umgang mit Siebträgermaschinen, um Espresso und andere Kaffeespezialitäten in höchster Qualität zuzubereiten.'],
                ],
            ],
            [
                'name' => 'Event Barkeeper',
                'description' => 'Diese Gruppe setzt sich aus erfahrenen Barkeepern zusammen, die speziell für Veranstaltungen geschult sind. Sie verfügen über Cocktail-Mixing-Zertifikate und kennen sich mit Getränkekunde aus. Ihre Schnelligkeit und Präzision machen sie ideal für Events mit hohem Gästeaufkommen.',
                'skills' => [
                    ['name' => 'Cocktail-Mixing-Zertifikat', 'description' => 'Nachweis über fundierte Kenntnisse und Fähigkeiten im Mixen klassischer sowie moderner Cocktails, einschließlich Präsentation und Dekoration.'],
                    ['name' => 'Erfahrung in Getränkekunde', 'description' => 'Umfassendes Wissen über Getränke, darunter Spirituosen, Weine und Softdrinks, sowie die Fähigkeit, Gäste fachgerecht zu beraten.'],
                    ['name' => 'Schnellservice für große Events', 'description' => 'Fähigkeit, unter Zeitdruck schnell und präzise zu arbeiten, um auch bei hohem Gästeaufkommen effizienten Service zu gewährleisten.'],
                ],
            ],
            [
                'name' => 'Sales Promoter',
                'description' => 'Die Sales Promoter sind Verkaufsspezialisten, die über umfassende Kenntnisse in Produktpräsentation und Kundenkommunikation verfügen. Sie sind Experten im Umgang mit Kassensystemen und beherrschen Techniken wie Upselling und Cross-Selling, um den Verkaufserfolg zu maximieren.',
                'skills' => [
                    ['name' => 'Verkaufstechniken (z. B. Upselling, Cross-Selling)', 'description' => 'Beherrschung effektiver Verkaufstechniken, um zusätzliche Produkte oder höherwertige Alternativen anzubieten und den Umsatz zu steigern.'],
                    ['name' => 'Erfahrung im Umgang mit Kassensystemen', 'description' => 'Sichere Bedienung moderner Kassensysteme, einschließlich der Abwicklung von Transaktionen, Rückgaben und Rabattierungen.'],
                    ['name' => 'Produktpräsentation und Kundenansprache', 'description' => 'Fähigkeit, Produkte ansprechend zu präsentieren und potenzielle Kunden gezielt und überzeugend anzusprechen.'],
                ],
            ],
            [
                'name' => 'Technische Promoter',
                'description' => 'Diese Gruppe besteht aus Promotern, die sich auf technische Unterstützung bei Veranstaltungen spezialisiert haben, einschließlich Bühnenaufbau, Licht- und Tontechnik.',
                'skills' => [
                    ['name' => 'Grundlagen der Veranstaltungstechnik', 'description' => 'Grundkenntnisse über die technische Planung und Durchführung von Events, einschließlich der Bedienung von Equipment und Sicherheitsstandards.'],
                    ['name' => 'Lichtsteuerung', 'description' => 'Erfahrung in der Einrichtung und Steuerung von Lichtanlagen, um verschiedene Stimmungen und Effekte zu erzeugen.'],
                    ['name' => 'Tonsteuerung', 'description' => 'Fähigkeit, Tontechnik einzurichten und zu bedienen, um eine optimale Klangqualität für Veranstaltungen sicherzustellen.'],
                ],
            ],
            [
                'name' => 'Fitness-Coaches',
                'description' => 'Diese Gruppe umfasst Promoter, die Fitness- und Gesundheitsförderung betreiben, z. B. bei Sportevents oder in Fitnessstudios.',
                'skills' => [
                    ['name' => 'Zertifikat für Personal Training', 'description' => 'Qualifikation im Bereich Personal Training, mit Schwerpunkt auf individueller Trainingsplanung und -durchführung.'],
                    ['name' => 'Grundkenntnisse in Ernährung', 'description' => 'Basiswissen über gesunde Ernährung und deren Einfluss auf körperliche Fitness und Gesundheit.'],
                    ['name' => 'Erste-Hilfe-Zertifikat', 'description' => 'Nachweis über die Fähigkeit, in Notfällen Erste Hilfe zu leisten und schnell zu reagieren.'],
                ],
            ],
        ];

        // Create Promoter Groups and Skills
        foreach ($promoterGroupsData as $groupData) {
            $promoterGroup = PromoterGroup::create([
                'name' => $groupData['name'],
                'description' => $groupData['description'],
            ]);

            foreach ($groupData['skills'] as $skillData) {
                $skill = Skill::create($skillData);
                $promoterGroup->skills()->attach($skill);
            }
        }

        // Create Promoters and Assign to Groups
        $promoters = Promoter::factory(3)->create();
        $promoters[0]->skills()->attach([1, 2]);
        $promoters[0]->promoterGroups()->attach(1);

        $promoters[1]->skills()->attach([4, 5]);
        $promoters[1]->promoterGroups()->attach(2);

        $promoters[2]->skills()->attach([7]);
        $promoters[2]->promoterGroups()->attach(3);
    }
}
