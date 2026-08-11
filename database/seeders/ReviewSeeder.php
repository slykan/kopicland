<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'author_name' => 'Fran Hrsan',
                'rating' => 5,
                'comment' => [
                    'hr' => 'Bio sam samo u restoranu Kopićland i iskustvo je bilo stvarno odlično. Hrana je bila jako ukusna, porcije dobre, a osoblje ljubazno i brzo. Atmosfera je ugodna i opuštena, pogotovo zbog dobre lokacije i pogleda. Sve je bilo uredno i usluga na visokoj razini. Definitivno mjesto gdje bih ponovno došao jesti.',
                    'en' => "I've only been to the Kopićland restaurant and the experience was really great. The food was very tasty, the portions were good, and the staff was friendly and fast. The atmosphere is pleasant and relaxed, especially because of the good location and view. Everything was neat and the service was at a high level. Definitely a place I would come to eat again.",
                    'de' => 'Ich war nur im Restaurant Kopićland und das Erlebnis war wirklich großartig. Das Essen war sehr schmackhaft, die Portionen gut, und das Personal freundlich und schnell. Die Atmosphäre ist angenehm und entspannt, besonders wegen der guten Lage und Aussicht. Alles war ordentlich und der Service auf hohem Niveau. Definitiv ein Ort, an den ich gerne wieder zum Essen komme.',
                ],
            ],
            [
                'author_name' => 'Ivana Futivić',
                'rating' => 5,
                'comment' => [
                    'hr' => 'Predivna atmosfera, jelo izvrsno ukusno i obilno, piće također, osoblje perfektno usluga brza i prijazna, uz prekrasan ambijent i glazbu uživo predivno smo se proveli. Hvala na svemu.',
                    'en' => 'Wonderful atmosphere, delicious and plentiful food, drinks too, perfect staff, fast and friendly service, beautiful ambiance and live music, we had a wonderful time. Thank you for everything.',
                    'de' => 'Wunderbare Atmosphäre, köstliches und reichhaltiges Essen, auch die Getränke, perfektes Personal mit schnellem und freundlichem Service, wunderschönes Ambiente und Live-Musik – wir hatten eine wundervolle Zeit. Danke für alles.',
                ],
            ],
            [
                'author_name' => 'Ivana Dragicevic',
                'rating' => 5,
                'comment' => [
                    'hr' => 'Vrlo ugodna atmosfera, jeli smo čobanac, porcije su više nego obilne, vrlo ukusna hrana. Osoblje izuzetno ugodno, preporuka za obiteljska slavlja i svečane prigode. Prvi puta smo ovdje, ali vjerujem ne i zadnji. Bravo!',
                    'en' => "Very pleasant atmosphere, we had čobanac, the portions are more than generous, very tasty food. The staff is extremely pleasant, recommended for family celebrations and festive occasions. This is our first time here, but I believe it won't be the last. Bravo!",
                    'de' => 'Sehr angenehme Atmosphäre, wir hatten Čobanac (Hirteneintopf), die Portionen sind mehr als großzügig, sehr schmackhaftes Essen. Das Personal ist äußerst angenehm, empfehlenswert für Familienfeiern und festliche Anlässe. Wir sind zum ersten Mal hier, aber ich glaube nicht zum letzten Mal. Bravo!',
                ],
            ],
            [
                'author_name' => 'Mario Lončar',
                'rating' => 5,
                'comment' => [
                    'hr' => 'Iz Imotskog stigli, oduševljeni. Hrana, ambijent, usluga.. Sve preporuke, vraćamo se sigurno!',
                    'en' => 'Arrived from Imotski, delighted. Food, ambiance, service... All recommendations, we will definitely be back!',
                    'de' => 'Aus Imotski angereist, begeistert. Essen, Ambiente, Service... Absolute Empfehlung, wir kommen sicher wieder!',
                ],
            ],
            [
                'author_name' => 'Dragana Gubić',
                'rating' => 5,
                'comment' => [
                    'hr' => 'Osoblje krajnje pristojno uslužno i raspoloženo. Hrana sočna svježa... Prostor ugodan. Prvi put sam ovdje i svakako želim doći opet. Svaka pohvala kuharu i osoblju.',
                    'en' => "The staff is extremely polite, helpful and cheerful. The food is juicy and fresh... The space is cozy. It's my first time here and I definitely want to come again. All praise to the chef and the staff.",
                    'de' => 'Das Personal ist überaus höflich, hilfsbereit und gut gelaunt. Das Essen ist saftig und frisch... Der Raum ist gemütlich. Ich bin zum ersten Mal hier und möchte definitiv wiederkommen. Alle Anerkennung für den Koch und das Personal.',
                ],
            ],
            [
                'author_name' => 'Katarina Marić',
                'rating' => 5,
                'comment' => [
                    'hr' => 'Odlično mjesto za odmoriti dušu i tijelo, dobro se najesti i popiti. Za obitelji s djecom milina.. park u prirodi sa svim sadržajima za njih. Osoblje profesionalno i ljubazno.',
                    'en' => 'A great place to rest your body and soul, have a good meal and drink. For families with children, a delight... a park in nature with all the facilities for them. The staff is professional and friendly.',
                    'de' => 'Ein großartiger Ort, um Körper und Seele auszuruhen, gut zu essen und zu trinken. Für Familien mit Kindern ein Vergnügen... ein Park in der Natur mit allen Einrichtungen für sie. Das Personal ist professionell und freundlich.',
                ],
            ],
            [
                'author_name' => 'Dolores Sremac',
                'rating' => 5,
                'comment' => [
                    'hr' => 'Nevjerojatno iskustvo od početka do kraja! Hrana je bila izvanredna – svaki zalogaj je oduševio, ali posebno bih istaknula domaće njoke koje su bile fantastične: mekane, savršeno kuhane i u umaku koji im je savršeno pristajao. Konobar koji nas je posluživao bio je izuzetno ljubazan, profesionalan i nenametljiv, sve s osmijehom. Ambijent restorana je predivan – topao, elegantan i vrlo ugodan. Osjećaš se kao kod kuće, ali s daškom luksuza. Sve pohvale cijelom osoblju i kuhinji na trudu, kvaliteti i gostoprimstvu.',
                    'en' => "An incredible experience from start to finish! The food was outstanding – every bite was a delight, but I would especially highlight the homemade gnocchi which were fantastic: soft, perfectly cooked and in a sauce that suited them perfectly. The waiter who served us was extremely kind, professional and unobtrusive, all with a smile. The restaurant's ambiance is wonderful – warm, elegant and very comfortable. You feel like at home, but with a touch of luxury. All praise to the entire staff and kitchen for their effort, quality and hospitality.",
                    'de' => 'Ein unglaubliches Erlebnis von Anfang bis Ende! Das Essen war hervorragend – jeder Bissen war ein Genuss, aber besonders hervorheben möchte ich die hausgemachten Gnocchi, die fantastisch waren: weich, perfekt gekocht und in einer Sauce, die perfekt dazu passte. Der Kellner, der uns bediente, war äußerst freundlich, professionell und zurückhaltend, alles mit einem Lächeln. Das Ambiente des Restaurants ist wunderbar – warm, elegant und sehr gemütlich. Man fühlt sich wie zu Hause, aber mit einem Hauch von Luxus. Alle Anerkennung für das gesamte Personal und die Küche für ihren Einsatz, Qualität und Gastfreundschaft.',
                ],
            ],
            [
                'author_name' => 'Luka Jurić',
                'rating' => 5,
                'comment' => [
                    'hr' => 'Ako želite pravu slavonsku atmosferu, dobre ljude, dobru hranu, dobru glazbu, od duše preporučujem. Ovo stvarno treba doživjeti! Svaka čast gazdi, ekipi i osoblju.',
                    'en' => 'If you want a real Slavonian atmosphere, good people, good food, good music, I recommend it from the bottom of my heart. This is something you really need to experience! Kudos to the owner, the team and the staff.',
                    'de' => 'Wenn Sie echte slawonische Atmosphäre, gute Leute, gutes Essen und gute Musik erleben möchten, empfehle ich es von ganzem Herzen. Das muss man wirklich erlebt haben! Alle Achtung dem Besitzer, dem Team und dem Personal.',
                ],
            ],
            [
                'author_name' => 'Mimi',
                'rating' => 5,
                'comment' => [
                    'hr' => 'Jako lijep ugođaj, profesionalna usluga i posluga, hrana vrhunska, atmosfera bila super, glazba uživo (tamburaši). Lokacija top, bravo svaka čast. Rezervirali odmah za doček, jedva čekamo i vidimo se. Zdravi bili!',
                    'en' => 'Very nice atmosphere, professional service, excellent food, great atmosphere, live music (tamburica players). Top location, well done, congratulations. Booked right away for the reception, can\'t wait to see you. Cheers!',
                    'de' => 'Sehr schöne Atmosphäre, professioneller Service und Bedienung, erstklassiges Essen, tolle Stimmung mit Live-Musik (Tamburica-Spieler). Top Lage, bravo, alle Achtung. Gleich für den Silvesterempfang gebucht, wir können es kaum erwarten, uns zu sehen. Zum Wohl!',
                ],
            ],
        ];

        foreach ($reviews as $index => $review) {
            Review::updateOrCreate(
                ['author_name' => $review['author_name']],
                [
                    'rating' => $review['rating'],
                    'comment' => $review['comment'],
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
