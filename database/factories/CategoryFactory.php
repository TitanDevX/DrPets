<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
      
                // Predefined names and descriptions for generalized products
                $productNames = [
                    'en' => [
                        'Pet Essentials', 'Animal Care Products', 'Pet Health Items', 'Pet Grooming Supplies', 'Pet Comfort Gear',
                        'Pet Training Tools', 'Pet Safety Products', 'Pet Clothing', 'Pet Feeding Accessories', 'Pet Hygiene Items', 
                        'Pet Travel Gear', 'Pet Playtime Products'
                    ],
                    'ar' => [
                        'مستلزمات الحيوانات الأليفة', 'منتجات العناية بالحيوانات', 'منتجات صحة الحيوانات الأليفة', 'مستحضرات تجميل الحيوانات الأليفة', 'معدات راحة الحيوانات الأليفة',
                        'أدوات تدريب الحيوانات الأليفة', 'منتجات سلامة الحيوانات الأليفة', 'ملابس الحيوانات الأليفة', 'مستلزمات تغذية الحيوانات الأليفة', 'مستلزمات النظافة للحيوانات الأليفة',
                        'معدات السفر للحيوانات الأليفة', 'منتجات وقت اللعب للحيوانات الأليفة'
                    ],
                    'fr' => [
                        'Essentiels pour animaux', 'Produits de soin des animaux', 'Articles de santé pour animaux', 'Fournitures de toilettage pour animaux', 'Équipement de confort pour animaux', 
                        'Outils de dressage pour animaux', 'Produits de sécurité pour animaux', 'Vêtements pour animaux', 'Accessoires de nourrissage pour animaux', 'Articles d\'hygiène pour animaux', 
                        'Équipement de voyage pour animaux', 'Produits de jeu pour animaux'
                    ]
                ];
        
                $productDescriptions = [
                    'en' => [
                        'Essential items to care for your pets', 'High-quality products for animal care', 'Health-focused items for pets', 
                        'Supplies for grooming your pets', 'Comfort items for your pets', 'Training tools for your pets', 
                        'Safety items for your pets', 'Clothing for your pets', 'Accessories for feeding your pets', 'Hygiene products for pets',
                        'Travel gear for your pets', 'Fun products for your pets to play with'
                    ],
                    'ar' => [
                        'عناصر أساسية لرعاية حيواناتك الأليفة', 'منتجات عالية الجودة لرعاية الحيوانات', 'منتجات صحية لحيواناتك الأليفة', 'مستحضرات لتجميل حيواناتك الأليفة', 'منتجات للراحة لحيواناتك الأليفة', 
                        'أدوات تدريب لحيواناتك الأليفة', 'منتجات أمان لحيواناتك الأليفة', 'ملابس لحيواناتك الأليفة', 'مستلزمات تغذية الحيوانات الأليفة', 'منتجات نظافة للحيوانات الأليفة', 
                        'معدات سفر لحيواناتك الأليفة', 'منتجات وقت اللعب لحيواناتك الأليفة'
                    ],
                    'fr' => [
                        'Articles essentiels pour soigner vos animaux', 'Produits de haute qualité pour les soins des animaux', 'Articles de santé pour vos animaux', 'Fournitures pour toiletter vos animaux', 'Articles de confort pour vos animaux',
                        'Outils pour dresser vos animaux', 'Articles de sécurité pour vos animaux', 'Vêtements pour vos animaux', 'Accessoires pour nourrir vos animaux', 'Articles d\'hygiène pour vos animaux',
                        'Équipement de voyage pour vos animaux', 'Produits de jeu pour vos animaux'
                    ]
                ];
        
                // Predefined names and descriptions for generalized services
                $serviceNames = [
                    'en' => [
                        'Pet Care Services', 'Pet Training Services', 'Pet Grooming and Styling', 'Pet Health and Wellness', 'Pet Sitting and Watching', 
                        'Pet Walking Services', 'Pet Behavior Consulting', 'Pet Daycare Services', 'Pet Emergency Care', 'Pet Transport and Shuttle', 
                        'Pet Veterinary Services', 'Pet Adoption and Rescue Services', 'Pet Photography and Videography', 'Pet Event Planning', 
                        'Pet Spa and Relaxation Services'
                    ],
                    'ar' => [
                        'خدمات رعاية الحيوانات الأليفة', 'خدمات تدريب الحيوانات الأليفة', 'خدمات تجميل وتصفيف الحيوانات الأليفة', 'خدمات صحة ورفاهية الحيوانات الأليفة', 
                        'خدمات جليسة الحيوانات الأليفة', 'خدمات المشي مع الحيوانات الأليفة', 'استشارات سلوك الحيوانات الأليفة', 'خدمات رعاية نهارية للحيوانات الأليفة', 
                        'خدمات الطوارئ للحيوانات الأليفة', 'خدمات نقل وتوصيل الحيوانات الأليفة', 'خدمات الطب البيطري للحيوانات الأليفة', 
                        'خدمات تبني وإنقاذ الحيوانات الأليفة', 'خدمات تصوير الحيوانات الأليفة', 'تخطيط الفعاليات الخاصة بالحيوانات الأليفة', 'خدمات السبا واسترخاء الحيوانات الأليفة'
                    ],
                    'fr' => [
                        'Services de soins pour animaux', 'Services de dressage pour animaux', 'Toilettage et coiffure pour animaux', 'Santé et bien-être des animaux', 
                        'Garde et surveillance d\'animaux', 'Services de promenade d\'animaux', 'Consultation comportementale pour animaux', 'Services de garderie pour animaux', 
                        'Soins d\'urgence pour animaux', 'Transport et navette pour animaux', 'Services vétérinaires pour animaux', 'Adoption et sauvetage d\'animaux', 
                        'Photographie et vidéographie pour animaux', 'Planification d\'événements pour animaux', 'Spa et services de relaxation pour animaux'
                    ]
                ];
        
                $serviceDescriptions = [
                    'en' => [
                        'Comprehensive care for your pets', 'Training services for better behavior', 'Grooming and styling to keep your pets looking great', 
                        'Health and wellness programs for your pets', 'Reliable pet sitting services', 'Daily walking services for your pets', 
                        'Behavioral consulting for pets', 'Daycare services for pets', 'Emergency care for your pets', 'Transport services for your pets', 
                        'Veterinary care for your pets', 'Adoption and rescue assistance for pets', 'Photography and videography services for your pets', 
                        'Event planning services for your pets', 'Relaxation and spa services for your pets'
                    ],
                    'ar' => [
                        'رعاية شاملة لحيواناتك الأليفة', 'خدمات تدريب لتصرفات أفضل', 'تجميل وتصفيف للحفاظ على جمال حيواناتك الأليفة', 
                        'برامج صحية ورفاهية لحيواناتك الأليفة', 'خدمات جليسة موثوقة لحيواناتك الأليفة', 'خدمات المشي اليومية لحيواناتك الأليفة',
                        'استشارات سلوكية للحيوانات الأليفة', 'خدمات رعاية نهارية للحيوانات الأليفة', 'خدمات الطوارئ لحيواناتك الأليفة', 
                        'خدمات نقل حيواناتك الأليفة', 'رعاية بيطرية لحيواناتك الأليفة', 'مساعدة في التبني والإنقاذ للحيوانات الأليفة', 
                        'خدمات تصوير فيديو وصور لحيواناتك الأليفة', 'خدمات تخطيط الفعاليات لحيواناتك الأليفة', 'خدمات الاسترخاء والسبا لحيواناتك الأليفة'
                    ],
                    'fr' => [
                        'Soins complets pour vos animaux', 'Services de dressage pour un meilleur comportement', 'Toilettage et coiffure pour garder vos animaux magnifiques', 
                        'Programmes de santé et de bien-être pour vos animaux', 'Services de garde pour vos animaux', 'Services de promenade quotidiens pour vos animaux', 
                        'Consultation comportementale pour vos animaux', 'Garderie pour vos animaux', 'Soins d\'urgence pour vos animaux', 'Transport pour vos animaux', 
                        'Soins vétérinaires pour vos animaux', 'Aide à l\'adoption et au sauvetage des animaux', 'Services de photographie et vidéographie pour vos animaux', 
                        'Planification d\'événements pour vos animaux', 'Services de relaxation et de spa pour vos animaux'
                    ]
                ];
        
                // Randomly assign type (product or service)
                $type = $this->faker->randomElement([1, 2]);  // 1 for Product, 2 for Service
                
                if ($type == 1) {
                    $index =rand(0,11);
                    // Handle product type
                    $name = $this->translations(['en', 'ar', 'fr'], [
                      $productNames['en'][$index],
                       $productNames['ar'][$index],
                      $productNames['fr'][$index],
                    ]);
                    $description = $this->translations(['en', 'ar', 'fr'], [
                        $productDescriptions['en'][$index],
                       $productDescriptions['ar'][$index],
                       $productDescriptions['fr'][$index],
                    ]);
                } else {
                    $index =rand(0,14);
                    // Handle service type
                    $name = $this->translations(['en', 'ar', 'fr'], [
                      $serviceNames['en'][$index],
                       $serviceNames['ar'][$index],
                   $serviceNames['fr'][$index],
                    ]);
                    $description = $this->translations(['en', 'ar', 'fr'], [
                      $serviceDescriptions['en'][$index],
                     $serviceDescriptions['ar'][$index],
                     $serviceDescriptions['fr'][$index],
                    ]);
                }
        
                return [
                    'name' => $name,
                    'description' => $description,
                    'enabled' => $this->faker->boolean,
                    'type' => $type,  // 1 for product, 2 for service
                ];
        
    }
}
