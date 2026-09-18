<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Console\Command;

class SeedRealBlogPosts extends Command
{
    protected $signature = 'blog:seed-real';

    protected $description = 'Adauga articole de blog reale, bazate pe proiectele proprii (studii de caz).';

    public function handle(): int
    {
        $categories = [
            'studii-de-caz' => 'Studii de caz',
            'arhitectura-software-bune-practici' => 'Arhitectură software & bune practici',
            'product-management-ux' => 'Product Management & UX pentru aplicații românești',
            'digitalizare-companii-romania' => 'Digitalizare în companii din România',
            'ghiduri-tehnice-practice' => 'Ghiduri tehnice practice',
            'business-freelancing-tehnic' => 'Business & freelancing tehnic',
        ];

        $postsByCategory = [
            'studii-de-caz' => [
                [
                    'title' => 'De la un PHP simplu la Laravel: povestea Fleetly, aplicatia mea de management flote auto',
                    'slug' => 'povestea-fleetly-management-flote-auto',
                    'excerpt' => 'Cum a pornit Fleetly ca o aplicatie PHP simpla si de ce am ales acum sa o rescriu in Laravel, pe masura ce cerintele au crescut.',
                    'body' => "Fleetly a pornit dintr-o nevoie foarte concreta: firmele care gestioneaza flote de vehicule au nevoie de un loc unic in care sa tina evidenta masinilor, soferilor si cheltuielilor, in loc sa foloseasca hartii, Excel-uri si mesaje imprastiate.\n\nPrima versiune a fost construita in PHP simplu, fara framework, exact cat sa validez rapid ideea si sa o pun in fata unor utilizatori reali. Aplicatia acopera astazi administrarea documentelor pentru masini si soferi, evidenta cheltuielilor, un modul de service (intern sau la un service extern), un modul de piese de schimb si un modul dedicat mecanicilor. Din toate aceste module rezulta rapoarte care arata clar costurile totale ale unei flote, pe categorii.\n\nPe masura ce numarul de functionalitati a crescut, a devenit clar ca o structura mai organizata ar ajuta atat la mentenanta, cat si la adaugarea de functii noi mai rapid si mai sigur. De aceea lucrez acum la o versiune Fleetly construita in Laravel, care pastreaza toata logica de business validata in productie, dar beneficiaza de o arhitectura mai solida pe termen lung.\n\nEste un exemplu bun despre cum arata dezvoltarea de produs in realitate: pornesti simplu, validezi ideea cu utilizatori reali, apoi investesti in arhitectura pe masura ce aplicatia demonstreaza ca merita sa creasca.",
                    'tags' => ['Fleetly', 'Laravel', 'PHP', 'studiu de caz'],
                    'seo_title' => 'Povestea Fleetly: de la PHP simplu la Laravel | Conectica IT',
                    'seo_description' => 'Cum a evoluat Fleetly, aplicatia de management flote auto, de la o versiune PHP simpla catre o arhitectura Laravel.',
                ],
                [
                    'title' => 'Modulia: un ERP romanesc construit pentru problemele reale din santier',
                    'slug' => 'modulia-erp-romanesc-pentru-santier',
                    'excerpt' => 'De ce solutiile generice de project management (Asana, Trello, Excel) nu functioneaza pe un santier real si cum incearca Modulia sa rezolve asta.',
                    'body' => "Majoritatea firmelor de constructii sunt foarte bune la executie, dar pierd profit din lipsa de organizare operationala si din fluxul lent de informatii dintre santier si birou. Informatiile raman imprastiate intre Excel-uri, WhatsApp si documente, iar managerii nu au o imagine clara asupra bugetelor, task-urilor si termenelor in timp real.\n\nModulia este platforma pe care am construit-o pentru a rezolva exact aceasta problema: un sistem online, de tip ERP, gandit special pentru firmele de constructii, antreprenorii generali si echipele de renovari. Un diferentiator important este modulul de control al resurselor, care permite organizarea echipelor, programarea utilajelor in calendar si trasabilitatea materialelor direct de pe telefonul mobil.\n\nSolutiile generice de project management, precum Asana sau Trello, sunt excelente pentru marketing sau IT, dar nu inteleg contextul specific al unui santier: nu stiu ce este o situatie de lucrari, nu coreleaza consumul de materiale printr-un retetar si nu arata disponibilitatea unui utilaj pe zile. Excel-ul, la randul lui, devine rapid greu de gestionat cand exista mai multe modificari de deviz in aceeasi zi.\n\nUna dintre cele mai mari provocari a fost simplificarea conceptelor tehnice de project management (precum structura WBS) astfel incat un antreprenor fara pregatire specifica sa poata folosi platforma fara training suplimentar. Modulia traduce aceste concepte in etape simple si intuitive: Fundatie, Zidarie, Finisaje.\n\nPlatforma include si un modul de Snag List pentru identificarea din timp a neconformitatilor, pentru ca preventia sa fie mai simpla decat corectarea ulterioara.",
                    'tags' => ['Modulia', 'Laravel', 'ERP', 'constructii', 'studiu de caz'],
                    'seo_title' => 'Modulia: ERP romanesc pentru santier | Conectica IT',
                    'seo_description' => 'De ce solutiile generice de project management nu sunt suficiente pe santier si cum rezolva Modulia problemele operationale din constructii.',
                ],
                [
                    'title' => 'Cum ai construit Fleetly (partea 2): arhitectură, scalare și API',
                    'slug' => 'cum-ai-construit-fleetly-partea-2-arhitectura-scalare-api',
                    'excerpt' => 'Dupa validarea MVP-ului, am trecut la o arhitectura mai clara pentru service, rapoarte, API si extensibilitate.',
                    'body' => "Validarea ideii este doar jumatate din poveste. Dupa ce sistemul a inceput sa fie folosit in conditii reale, a aparut o problema clara: product logic si business rules se inmultesc, iar codul, daca nu este organizat, devine greu de intretinut.\n\nIn a doua etapa a Fleetly, am trecut la o arhitectura mai clara: servicii pentru business logic, modele de date care reflecta realitatea operationala, structuri de rapoarte explicite si API-uri stabile pentru frontend si integrari externe. Asta a permis ca fiecare functionalitate sa fie testabila separat si mai usor de extins.\n\nUn alt punct important a fost scalarea: cand numarul de clienti, vehicule si documente a crescut, solutiile ad-hoc au devenit costisitoare. In loc sa ingramadim logica in controlere, am separat fluxurile de business in servicii. Din acest motiv, new features nu mai afecteaza toata aplicatia dintr-o data.\n\nDaca vrei sa construiești un produs care are sanse sa creasca, nu este suficient ca MVP-ul sa functioneze. Trebuie sa ai o arhitectura care accepta schimbari fara sa distruga ce-a functionat deja.",
                    'tags' => ['Fleetly', 'arhitectura', 'API', 'Laravel'],
                    'seo_title' => 'Fleetly: arhitectura, scalare si API | Conectica IT',
                    'seo_description' => 'Povestea arhitecturii Fleetly: servicii, API, scalare si organizare a logicii de business.',
                ],
                [
                    'title' => 'Refactoring real: cum rescrii un proiect vechi fără să-l oprești',
                    'slug' => 'refactoring-real-cum-rescrii-un-proiect-vechi-fara-sa-il-opresti',
                    'excerpt' => 'Cel mai sigur refactoring nu este acela care intrerupe totul, ci acela care protejeaza fluxul live in timp real.',
                    'body' => "Multe proiecte nu se opresc din cauza unei erori majore, ci din cauza acumularii de compromisuri: cod duplicat, logica dispersata, proceduri manuale si procese netestate. In momentul in care lucrezi cu o aplicatie de business care este deja in productie, refactoring-ul devine o operatiune delicata.\n\nSolutia nu este sa rescrii totul dintr-o data, ci sa separi logica in etape mici, cu teste si securitate la nivel de business. In practica, inseamna sa protezi fluxurile critice, sa faci migrari incremental, sa documentezi schimbari si sa alegi ce se repara acum, ce se reporteaza mai tarziu.\n\nUn proiect nu este doar o colectie de funcii; este un sistem de decizii, reguli si procese care trebuie pastrate peste timp. De aceea refactoring-ul de succes are la baza o intelegere clara a valorii pe care o ofera clientului - nu doar a codului din spate.",
                    'tags' => ['refactoring', 'software', 'business'],
                    'seo_title' => 'Refactoring fara intreruperea aplicatiei | Conectica IT',
                    'seo_description' => 'Cum gestionezi un refactoring fara sa intrerupi un produs live si sa pierzi increderea clientului.',
                ],
            ],
            'arhitectura-software-bune-practici' => [
                [
                    'title' => 'Monolit vs microservicii în proiecte mici și mijlocii din România',
                    'slug' => 'monolit-vs-microservicii-proiecte-mici-romania',
                    'excerpt' => 'Pentru majoritatea companiilor locale, monolith-ul bine construit este adesea mai inteligent decat o arhitectura complexa din start.',
                    'body' => "Pentru o companie care are 5-50 de utilizatori interni sau 1.000-10.000 de utilizatori finali, microserviciile nu sunt intotdeauna solutia potrivita. In multe cazuri, un monolit bun, cu clear boundaries, bune practici de testare si arhitectura modulara, poate oferi acelasi nivel de flexibilitate, cu mult mai putin cost in operare.\n\nMicroserviciile devin relevante cand complexitatea depaseste capacitatea echipei de a mentine un singur sistem coerent, cand exista multe echipe cu independente deploys si cand exista nevoie reala de scale separat pe funcționalitati. In proiectele mici, adesea costul operational si al coordonarii e mai mare decat beneficiul.\n\nAlegerea potrivita ar trebui sa se bazeze nu pe hype, ci pe oboseala echipei, viteza de schimbare si riscul de eroare. In software, inteligenta nu este sa ai cea mai moderna arhitectura, ci sa ai una care iti permite sa adaugi valoare fara sa-ti pierzi timpul cu infrastructura.",
                    'tags' => ['arhitectura', 'microservicii', 'monolit'],
                    'seo_title' => 'Monolit vs microservicii in proiecte mici | Conectica IT',
                    'seo_description' => 'Cand monolit-ul este mai bun decat microserviciile si care este alegerea potrivita pentru companiile romanesti.',
                ],
                [
                    'title' => 'De ce Laravel este potrivit pentru aplicații de business',
                    'slug' => 'de-ce-laravel-este-potrivit-pentru-aplicatii-de-business',
                    'excerpt' => 'Laravel nu este doar framework pentru site-uri; este un instrument excelent pentru sisteme interne, CRM, ERP si aplicații de producție.',
                    'body' => "Laravel a devenit extrem de popular pentru ca uneste productivitate, claritate si un ecosistem matur. Pentru un business software, asta inseamna ca poti sa construiesti aplicatii care nu doar functioneaza, ci si se intretin usor, se extind rapid si se protejeaza de complexitate.\n\nDin punct de vedere operational, Laravel ofera un cadru clar pentru route, modele, validari, policy-uri, joburi si sisteme de autentificare. In proiectele de business, partea importanta nu este doar frontend-ul, ci si fluxurile interne, autorizarea, rapoartele, integrari si procese administrative.\n\nIn plus, ecosistemul larvelian (Filament, Spatie, Sanctum, Horizon, Laravel Pulse etc.) permite ca un proiect sa evolueze de la MVP la sistem de productie fara sa fie nevoie de o restructurare completa. Pentru startup-uri si firme locale, asta este un avantaj foarte concret.",
                    'tags' => ['Laravel', 'business', 'framework'],
                    'seo_title' => 'De ce Laravel se potriveste aplicatiilor de business',
                    'seo_description' => 'De ce Laravel este o alegere puternica pentru aplicatii interne, ERP si sisteme de business in Romania.',
                ],
            ],
            'product-management-ux' => [
                [
                    'title' => 'Cum validezi un produs digital fără buget mare',
                    'slug' => 'cum-validezi-un-produs-digital-fara-buget-mare',
                    'excerpt' => 'Validarea nu merge prin mai mult design sau cod; merge prin observarea problemelor reale si a fluxurilor de utilizare.',
                    'body' => "In multe proiecte mici, problema nu este lipsa de idei, ci lipsa de claritate asupra problemei. Inainte de a construi un produs complex, trebuie sa intelegi care este fluxul critic al utilizatorului si ce schimbare aduce.\n\nValidarea cu buget mic inseamna sa pornesti de la un scenariu clar, sa testezi cu 3-5 persoane reale si sa colectezi feedback usor de masurat. Nu este nevoie de un extensiv design system; este nevoie de un flux simplu, de o interfata pe care oamenii o pot intelege in primul minut.\n\nAici intervine product management real: stabilirea prioritati, eliminarea feature-urilor care nu rezolva problema, si bugetul de dezvoltare orientat catre acel flux care creeaza valoare. Odata ce acel flux e validat, restul se poate construi mult mai sigur.",
                    'tags' => ['product management', 'UX', 'MVP'],
                    'seo_title' => 'Cum validezi un produs digital cu buget redus',
                    'seo_description' => 'Cum validezi un produs digital fara sa arunci bani in feature-uri fara valoare.',
                ],
                [
                    'title' => 'UX pentru aplicații interne (ERP, CRM, flote): de ce onboarding-ul doare',
                    'slug' => 'ux-pentru-aplicatii-interne-erp-crm-flote',
                    'excerpt' => 'Aplicatiile interne nu sunt mai putin importante decat cele publice; dimpotriva, UX-ul lor determina productivitatea reala.',
                    'body' => "Aplicatiile interne sunt folosite zilnic de oameni care nu au timp sa se adapteze la software-ul complicat. Daca un manager, un contabil sau un operator de flota nu intelege rapid cum functioneaza un formular sau un dashboard, productivitatea scade.\n\nAici UX-ul nu este despre estetica; este despre reducerea efortului mental. Formulare clare, state simple, etichete relevante, filtre intuitive si vizualizari care ajuta la decizie.\n\nMajoritatea systemelor interne se pierd pentru ca sunt construite asuma de catre echipa de IT si nu de utilizatori reali. Solutia este sa pui in fata utilizatorilor fluxuri reale, sa masoare timpul de completare si sa simplifice ceea ce face frictiune.",
                    'tags' => ['UX', 'ERP', 'CRM'],
                    'seo_title' => 'UX pentru aplicatii interne (ERP, CRM, flote) | Conectica IT',
                    'seo_description' => 'Cum faci o aplicatie interna usor de utilizat, fara sa te pierzi in complexitate.',
                ],
            ],
            'digitalizare-companii-romania' => [
                [
                    'title' => 'De ce Excel omoară productivitatea în firmele mici',
                    'slug' => 'de-ce-excel-omoara-productivitatea-in-firmele-mici',
                    'excerpt' => 'Excel-ul este bun pentru analiza, dar devine rapid un cost ascuns in firmele care cresc.',
                    'body' => "Excel-ul a fost si ramane o unealta utila, dar in companiile care cresc si devin mai complexe, el devine rapid o sursa de eroare. Fisierul este transmis pe mail, modificat de mai multe persoane, versiuni se suprapun si datele nu mai sunt niciodata coerente.\n\nPe termen lung, orice firma care se bazeaza pe Excel pentru operatiuni critice pierde timp, nu doar la introducerea datelor, ci si la verificari, rapoarte si corecturi. Acest lucru face ca managerii sa ia decizii pe baza unor informatii incomplete.\n\nDigitalizarea nu inseamna automat un ERP costisitor. Uneori inseamna un flux de lucru clar, un sistem de stoc, un formular simplu si o baza de date organizata, ceea ce poate aduce o economie reala de timp in cateva saptamani.",
                    'tags' => ['excel', 'digitalizare', 'business'],
                    'seo_title' => 'De ce Excel omoara productivitatea firmelor mici',
                    'seo_description' => 'Cum Excel-ul devine un cost ascuns in companiile mici si de ce merita digitalizare.',
                ],
                [
                    'title' => 'Digitalizare în construcții: probleme reale din teren și cum le rezolvi',
                    'slug' => 'digitalizare-in-constructii-probleme-reale-din-teren',
                    'excerpt' => 'In constructii, grandele pierderi nu sunt de software, ci de coordonare, documentatie si timp pierdut in teren.',
                    'body' => "Un antreprenor din constructii nu are nevoie de un sistem sofisticat, ci de un sistem care rezolva neclaritati reale. La santier, problemele nu sunt abstracte; sunt documente lipsa, alocarea resurselor neclarificata, stocurile neactualizate si deciziile luate in graba.\n\nDigitalizarea castigata vine din structura clara a proceselor: documente, etape, resurse, task-uri si raportare. Cand acestea sunt puse in sistem, managerul are viziune, iar echipa de teren are un singur punct de referinta.\n\nPentru companiile mici, un astfel de sistem poate reduce pierderile fara sa impuna costuri enorme. In loc sa te focusati pe completitudinea platformei, cauti claritatea si predictibilitatea.",
                    'tags' => ['constructii', 'digitalizare', 'ERP'],
                    'seo_title' => 'Digitalizare in constructii: probleme din teren',
                    'seo_description' => 'Cum digitalizezi procesele din constructii fara sa complici inutil lucrurile si fara sa incarci echipa cu instrumente greu de folosit.',
                ],
            ],
            'ghiduri-tehnice-practice' => [
                [
                    'title' => 'Cum optimizezi o aplicație Laravel pentru viteză',
                    'slug' => 'cum-optimizezi-o-aplicatie-laravel-pentru-viteza',
                    'excerpt' => 'Optimizarea Laravel nu este doar despre cache; este despre eliminarea fricțiunii din codebase, query-uri si UI.',
                    'body' => "Viteza unei aplicatii Laravel nu se intelege doar din numarul de request-uri la secunda. In realitate, timpul de raspuns este influentat de query-uri neoptimizate, N+1, date prea multe, plus modele de front-end care incarca content in exces.\n\nUn start bun este sa identifice care sunt paginile critice si ce arata in logs. Apoi, reducere larca de lucru: evaluezi query-urile, folosesti eager loading, limitezi campurile selectate, cache-ul si job-urile.\n\nIn plus, optimizarea aplicației nu se rezuma la backend. UI-ul trebuie sa fie clar, sa nu incarca prea mult content si sa nu forțeze utilizatorul sa aștepte indiferent de performanta serverului.",
                    'tags' => ['Laravel', 'performanta', 'optimizare'],
                    'seo_title' => 'Optimizeaza o aplicatie Laravel pentru viteza',
                    'seo_description' => 'Cum reduci timpul de raspuns si frictiunea unei aplicatii Laravel in productie.',
                ],
                [
                    'title' => 'Cum testezi un API cu Postman ca un profesionist',
                    'slug' => 'cum-testezi-un-api-cu-postman-ca-un-profesionist',
                    'excerpt' => 'Un API bun nu este doar unul care functioneaza; este unul care este verificat in diverse scenarii si documentat clar.',
                    'body' => "Postman este unul dintre cele mai practice unelte pentru testarea API-urilor, dar multe echipe il folosesc doar pentru a face o cerere simpla si a verifica un status code. In realitate, un test profesionist inseamna sa validezi scenarii de succes, erori, auth, rate limits si edge cases.\n\nDaca lucrezi cu API-uri de business, ar trebui sa ai colectii organizate, variabile de mediu, teste automate si documentatie clara. Astfel, nu mai depinzi de memoria echipei ca sa stii cum functioneaza un endpoint.\n\nAcesta este calea catre un API stabil: teste utile, request-uri clar definite si consimtamantul ca orice schmbare se verifica inainte de a intra in productie.",
                    'tags' => ['API', 'Postman', 'testare'],
                    'seo_title' => 'Testeaza un API cu Postman | Ghid practic',
                    'seo_description' => 'Cum testezi corect un API in productie si ce scenarii trebuie sa verifici.',
                ],
            ],
            'business-freelancing-tehnic' => [
                [
                    'title' => 'Cum negociezi un proiect software în România',
                    'slug' => 'cum-negociezi-un-proiect-software-in-romania',
                    'excerpt' => 'Negocierea buna nu se face pe pret, ci pe claritate: scop, riscuri, prioritati si livrabile.',
                    'body' => "Negocierea unui proiect software de succes are mai mult de-a face cu claritatea decat cu pretul. Clientii nu cumpara doar dezvoltare; cumpara predictibilitate, rezultat si un proces care reduce haosul.\n\nDaca vrei sa ai o negociere sanatoasa, definește clar domeniul, beneficiul dorit, prioritati, limitari si riscuri. Nu te angaja la un proiect vag cu termene prea dure sau cu cerinte neclare. O conversatie bine facuta reduce multe probleme mai tarziu.\n\nAsta nu inseamna sa fii rigid; inseamna sa ancorezi contractul de valoarea reala pe care o aduci. In Romania, clientii sunt mai receptivi la un pachet clar decat la un pret discret, dar fara explicatie.",
                    'tags' => ['freelancing', 'business', 'negociere'],
                    'seo_title' => 'Cum negociezi un proiect software in Romania | Conectica IT',
                    'seo_description' => 'Cum negociezi un proiect software cu claritate, signalizare de risc si pret corect.',
                ],
                [
                    'title' => 'Cum stabilești prețul corect pentru un MVP',
                    'slug' => 'cum-stabilesti-pretul-corect-pentru-un-mvp',
                    'excerpt' => 'Pretul unui MVP nu se calculeaza din ore abstracte, ci din riscul, complexitatea si valoarea livrată.',
                    'body' => "Atunci cand stabilesti pretul pentru un MVP, nu te uita doar la timpul estimat, ci si la riscul pe care il iei in functie de cerinta si de neclaritatea din proiect. Un MVP nu este un produs simplu; este o solutie ghidata de scop, cu multe decizii despre ce este important si ce poate fi amanat.\n\nUn pret corect include si costul integrarii, testarii, documentatiei, iteratiilor si finetunii din faza post-lansare. Daca ignoram acest lucru, devine foarte usor sa obtii un proiect care pare scump sau chiar de pret prea mic, dar care nu are garantii de continuitate.\n\nAsta este un motiv pentru care un prenume clar in business e crucial: daca un client intelege ce primeste, poate accepta si variatii fara sa se transforme intr-un haos de cereri noi.",
                    'tags' => ['MVP', 'pret', 'business'],
                    'seo_title' => 'Cum stabilesti pretul corect pentru un MVP | Conectica IT',
                    'seo_description' => 'Cum stabilesti un pret corect pentru un MVP, tinand cont de complexitate, iteratii si riscul proiectului.',
                ],
                [
                    'title' => 'Aplicație web personalizată sau soluție SaaS: ce alegi pentru afacerea ta?',
                    'slug' => 'aplicatie-web-personalizata-sau-saas-ce-alegi',
                    'excerpt' => 'O comparație practică între o aplicație web construită pentru procesele tale și un produs SaaS gata de folosit.',
                    'body' => "Alegerea dintre o aplicație web personalizată și o soluție SaaS nu se rezumă la abonamentul lunar. Decizia corectă depinde de cât de bine se potrivesc procesele companiei cu produsul existent și cât de important este să păstrezi controlul asupra datelor și fluxurilor.\n\nUn SaaS este potrivit când ai nevoie rapid de funcții standard, iar procesele tale se pot adapta fără costuri mari. O aplicație personalizată devine mai eficientă când ai reguli de business specifice, integrări proprii sau un mod de lucru care îți oferă avantaj competitiv.\n\nÎnainte de alegere, inventariază procesele critice, utilizatorii, integrările și costul schimbării. Uneori soluția bună este un SaaS pentru funcțiile generale și un modul personalizat pentru ceea ce diferențiază afacerea.\n\nUn proiect software bun începe cu această analiză, nu cu alegerea unei tehnologii.",
                    'tags' => ['aplicație web', 'SaaS', 'software personalizat', 'digitalizare'],
                    'seo_title' => 'Aplicație personalizată sau SaaS? Ghid pentru firme',
                    'seo_description' => 'Află când este mai potrivită o aplicație web personalizată și când o soluție SaaS pentru afacerea ta.',
                ],
                [
                    'title' => 'Automatizări pentru firme mici: 7 procese care îți consumă timpul inutil',
                    'slug' => 'automatizari-pentru-firme-mici-procese',
                    'excerpt' => 'Descoperă procesele repetitive care pot fi automatizate pentru a reduce erorile și timpul pierdut în operațiunile zilnice.',
                    'body' => "Într-o firmă mică, timpul pierdut pe operațiuni repetitive se adună rapid: copierea datelor între aplicații, trimiterea acelorași emailuri, rapoarte făcute manual și urmărirea task-urilor în conversații.\n\nPrimele procese care merită analizate sunt preluarea lead-urilor, confirmarea programărilor, generarea ofertelor, notificările pentru documente expirate, sincronizarea comenzilor, rapoartele recurente și trimiterea de remindere către clienți.\n\nAutomatizarea nu înseamnă să elimini controlul uman. Înseamnă să muți pașii previzibili într-un flux verificabil, iar echipa să se concentreze pe decizii și relația cu clientul.\n\nÎncepe cu un proces frecvent, măsoară timpul economisit și extinde soluția doar după ce rezultatul este clar.",
                    'tags' => ['automatizări', 'firme mici', 'productivitate', 'procese'],
                    'seo_title' => 'Automatizări pentru firme mici: 7 procese',
                    'seo_description' => '7 procese repetitive din firmele mici care pot fi automatizate pentru mai mult timp și mai puține erori.',
                ],
                [
                    'title' => 'ERP sau CRM: care este diferența și de ce ai nevoie?',
                    'slug' => 'erp-sau-crm-diferenta-si-ce-ai-nevoie',
                    'excerpt' => 'ERP-ul și CRM-ul rezolvă probleme diferite. Iată cum alegi sistemul potrivit pentru etapa actuală a companiei.',
                    'body' => "ERP și CRM sunt două categorii de software confundate frecvent, deși au scopuri diferite. CRM-ul organizează relația cu clienții: lead-uri, oferte, contacte, vânzări și follow-up. ERP-ul urmărește operațiunile interne: stocuri, proiecte, resurse, achiziții, documente și financiar.\n\nO firmă orientată spre vânzări poate începe cu un CRM bine configurat. O companie care gestionează proiecte, echipe, materiale sau stocuri are nevoie mai degrabă de funcții ERP. În multe situații, cele două sisteme trebuie să comunice, nu să concureze.\n\nProblema nu se rezolvă prin cumpărarea celui mai complex produs. Ai nevoie de un flux clar, roluri definite și date care circulă fără introducere repetată.\n\nÎnainte de implementare, documentează ce informații se pierd astăzi și ce decizii vrei să iei mai repede.",
                    'tags' => ['ERP', 'CRM', 'software business', 'digitalizare'],
                    'seo_title' => 'ERP sau CRM: diferențe și criterii de alegere pentru firme',
                    'seo_description' => 'Înțelege diferența dintre ERP și CRM și află ce tip de sistem se potrivește proceselor companiei tale.',
                ],
                [
                    'title' => 'Cât costă mentenanța unei aplicații web și ce ar trebui să includă?',
                    'slug' => 'cat-costa-mentenanta-unei-aplicatii-web',
                    'excerpt' => 'Mentenanța software înseamnă mai mult decât repararea bugurilor. Iată ce servicii protejează o aplicație în timp.',
                    'body' => "O aplicație web nu este terminată în ziua lansării. După publicare apar actualizări de securitate, schimbări în browsere și servicii externe, cerințe noi ale utilizatorilor și situații care nu puteau fi anticipate în faza inițială.\n\nMentenanța poate include monitorizare, backup, actualizarea dependențelor, remedierea erorilor, verificarea performanței, suport pentru utilizatori și mici îmbunătățiri funcționale. Nivelul potrivit depinde de cât de importantă este aplicația pentru operațiunile companiei.\n\nCostul nu ar trebui calculat doar ca număr de ore. Contează timpul de răspuns, accesul la cod, documentația, infrastructura și riscul unei opriri.\n\nUn acord clar de mentenanță oferă predictibilitate și reduce costul intervențiilor urgente.",
                    'tags' => ['mentenanță software', 'aplicații web', 'securitate', 'suport tehnic'],
                    'seo_title' => 'Cât costă mentenanța unei aplicații web? | Conectica IT',
                    'seo_description' => 'Ce include mentenanța unei aplicații web, cum se calculează costul și de ce este importantă după lansare.',
                ],
            ],
        ];

        $created = 0;

        foreach ($categories as $slug => $name) {
            $category = PostCategory::query()->firstOrCreate(
                ['slug' => $slug],
                ['name' => $name],
            );

            foreach ($postsByCategory[$slug] ?? [] as $post) {
                $post['body'] = $this->structureBody($post['body']);

                Post::query()->updateOrCreate(
                    ['slug' => $post['slug']],
                    $post + [
                        'post_category_id' => $category->id,
                        'published_at' => now(),
                        'is_published' => true,
                    ],
                );

                $created++;
            }
        }

        $this->info('Categoria si articolele de blog au fost populate cu succes ('.$created.' articole).');

        return self::SUCCESS;
    }

    private function structureBody(string $body): string
    {
        if (str_contains($body, '## ')) {
            return $body;
        }

        $paragraphs = preg_split('/\n{2,}/', trim($body)) ?: [];
        $headings = ['Problema reala', 'Abordarea potrivita', 'Ce am invatat', 'Concluzie'];

        return collect($paragraphs)
            ->map(function (string $paragraph, int $index) use ($headings): string {
                if ($index === 0) {
                    return trim($paragraph);
                }

                $heading = $headings[min($index - 1, count($headings) - 1)];

                return '## '.$heading."\n\n".trim($paragraph);
            })
            ->implode("\n\n");
    }
}
