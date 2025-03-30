<?php

namespace Database\Seeders;

use App\Models\Breed;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BreedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $f = Breed::factory();
   
        $petBreeds = [
            'Dog' => [
                'type' => [
                    'en' => 'Dog',
                    'ar' => 'كلب',
                    'fr' => 'Chien'
                ],
                'breeds' => [
            'Labrador Retriever' => [
                'en' => 'Friendly and outgoing.',
                'ar' => 'ودود واجتماعي.',
                'fr' => 'Affectueux et sociable.'
            ],
            'German Shepherd' => [
                'en' => 'Loyal and intelligent.',
                'ar' => 'وفي وذكي.',
                'fr' => 'Fidèle et intelligent.'
            ],
            'Golden Retriever' => [
                'en' => 'Gentle and playful.',
                'ar' => 'لطيف ومرح.',
                'fr' => 'Doux et joueur.'
            ],
            'Bulldog' => [
                'en' => 'Calm and affectionate.',
                'ar' => 'هادئ وحنون.',
                'fr' => 'Calme et affectueux.'
            ],
            'Poodle' => [
                'en' => 'Smart and elegant.',
                'ar' => 'ذكي وأنيق.',
                'fr' => 'Intelligent et élégant.'
            ],
            'Beagle' => [
                'en' => 'Curious and friendly.',
                'ar' => 'فضولي وودود.',
                'fr' => 'Curieux et amical.'
            ]
        ]
    ],
    'Cat' => [
        'type' => [
            'en' => 'Cat',
            'ar' => 'قط',
            'fr' => 'Chat'
        ],
        'breeds' => [
            'Persian' => [
                'en' => 'Fluffy and calm.',
                'ar' => 'كثيف الفرو وهادئ.',
                'fr' => 'Doux et calme.'
            ],
            'Maine Coon' => [
                'en' => 'Large and affectionate.',
                'ar' => 'كبير وحنون.',
                'fr' => 'Grand et affectueux.'
            ],
            'Siamese' => [
                'en' => 'Vocal and affectionate.',
                'ar' => 'صاخب وحنون.',
                'fr' => 'Vocal et affectueux.'
            ],
            'British Shorthair' => [
                'en' => 'Quiet and loyal.',
                'ar' => 'هادئ ومخلص.',
                'fr' => 'Calme et fidèle.'
            ],
            'Ragdoll' => [
                'en' => 'Gentle and affectionate.',
                'ar' => 'لطيف وحنون.',
                'fr' => 'Doux et affectueux.'
            ]
        ]
    ],
            'Bird' => [
                'type' => [
                    'en' => 'Bird',
                    'ar' => 'طائر',
                    'fr' => 'Oiseau'
                ],
                'breeds' => [
                    'Parrot' => [
                        'en' => 'Intelligent and talkative.',
                        'ar' => 'ذكي ويتكلم.',
                        'fr' => 'Intelligent et bavard.'
                    ],
                    'Canary' => [
                        'en' => 'Small and sings beautifully.',
                        'ar' => 'صغير ويغني بجمال.',
                        'fr' => 'Petit et chante bien.'
                    ]
                ]
            ],
            'Small Pet' => [
                'type' => [
                    'en' => 'Small Pet',
                    'ar' => 'حيوان أليف صغير',
                    'fr' => 'Petit animal'
                ],
                'breeds' => [
                    'Hamster' => [
                        'en' => 'Tiny and energetic.',
                        'ar' => 'صغير ونشيط.',
                        'fr' => 'Petit et énergique.'
                    ],
                    'Rabbit' => [
                        'en' => 'Soft and quiet.',
                        'ar' => 'ناعم وهادئ.',
                        'fr' => 'Doux et silencieux.'
                    ]
                ]
            ]
        ];
        
        foreach($petBreeds as $key ){
            foreach($key['breeds'] as $breedName=> $desc ){
            $f->create([
                    'name' => $breedName,
                    'type' => $f->translations(['en','ar','fr'],[$key['type']['en'],
                    $key['type']['ar'],
                    $key['type']['fr']]),
                    'description' => $f->translations(['en','ar','fr'],[$desc['en'], $desc['ar'],$desc['fr']] ),
                    'enabled' => fake()->boolean(90)
            ]);
            }
        }
    }
}
