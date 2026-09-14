# Plan de dezvoltare: conectica-it.ro

## 1. Viziune si obiective

conectica-it.ro va fi o platforma proprie pentru:

- prezentarea serviciilor si proiectelor;
- publicarea de continut tehnic;
- administrarea centralizata a continutului;
- generarea de lead-uri si, ulterior, comercializarea produselor software;
- automatizari SEO si operational analytics cu respectarea confidentialitatii.

Obiectivul este **controlul codului, datelor si infrastructurii**, nu eliminarea nerealista a tuturor dependentelor. Dependentele open-source vor fi versionate, documentate si inlocuibile.

## 2. Principii de arhitectura

- **Backend:** Laravel, folosind versiunea stabila suportata la momentul implementarii.
- **Admin:** Filament, extins custom numai unde este necesar.
- **Frontend:** Blade/Livewire si Tailwind CSS pentru un site rapid si usor de intretinut.
- **Baza de date:** PostgreSQL preferat; MySQL ramane alternativa compatibila cu hostingul.
- **Task-uri asincrone:** Laravel Queue + Redis, nu procese lungi executate direct in request.
- **Python:** worker sau serviciu intern separat pentru SEO audit si automatizari; input validat, permisiuni minime.
- **Deploy:** staging si production separate, deploy repetabil, rollback documentat.
- **Securitate:** least privilege, 2FA, validare server-side, rate limiting, audit log si secrete in environment.
- **Confidentialitate:** analytics fara fingerprinting si fara cookie-uri neesentiale; retenție si anonimizare documentate.

## 3. Faza 0 - Decizii si infrastructura (1-2 zile)

- [ ] Confirmarea identitatii vizuale, a serviciilor si a limbii principale.
- [ ] Alegerea PostgreSQL sau MySQL, cu PostgreSQL ca optiune recomandata.
- [ ] Instalarea Laravel in mediul local Laragon.
- [ ] Configurarea `.env`, `.env.example` si a conexiunii la baza de date.
- [ ] Repository Git si reguli pentru branch-uri.
- [ ] Definirea mediilor `local`, `staging`, `production`.
- [ ] Configurarea formatterului, test runner-ului si a pipeline-ului CI de baza.

**Criteriu de finalizare:** aplicatia porneste local, conexiunea la baza de date functioneaza, iar configurarea poate fi recreata din documentatie.

## 4. Faza 1 - MVP functional (saptamanile 1-3)

### Domeniu si continut

- [ ] Pagina principala orientata spre conversie.
- [ ] Pagini Servicii, Despre, Contact si Politica de confidentialitate.
- [ ] Portofoliu cu proiecte filtrabile.
- [ ] Blog tehnic cu categorii, tag-uri, slug si status draft/publicat.
- [ ] SEO per pagina: title, description, canonical si Open Graph.

### Model de date

- [ ] `users`, roluri si permisiuni.
- [ ] `projects` si tehnologii relationate.
- [ ] `services`.
- [ ] `posts`, categorii si tag-uri.
- [ ] `media`, cu metadata si variante optimizate.
- [ ] `seo_metadata`.

### Calitate

- [ ] Migrari, seedere si date demo.
- [ ] Validare server-side si politici de autorizare.
- [ ] Teste pentru autentificare, permisiuni, CRUD si rute publice.
- [ ] Upload securizat, limite de dimensiune si procesare WebP.
- [ ] Sitemap, robots.txt si meta tags.

**Criteriu de finalizare:** un administrator poate publica un proiect si un articol, iar vizitatorul le poate accesa rapid pe mobil si desktop.

## 5. Faza 2 - Administrare si UX premium (saptamanile 4-5)

- [ ] Panou Filament cu roluri `SuperAdmin`, `Editor` si `Analyst`.
- [ ] 2FA pentru conturile privilegiate.
- [ ] Audit log pentru actiunile administrative.
- [ ] Preview inainte de publicare si programare articole.
- [ ] Biblioteca media cu redimensionare si optimizare.
- [ ] Design system, componente reutilizabile si stari accesibile.
- [ ] Formular de contact cu validare, rate limiting si notificari.
- [ ] Teste de accesibilitate si verificare responsive.

**Criteriu de finalizare:** administrarea zilnica nu necesita acces direct la baza de date.

## 6. Faza 3 - Analytics privacy-first si SEO audit (saptamanile 6-7)

### Analytics

- [ ] Middleware limitat la paginile HTML, nu la asset-uri sau rute interne.
- [ ] Colectare minima: pagina, data, referrer normalizat, dispozitiv si tara aproximativa.
- [ ] Anonimizare IP si eliminare automata a datelor vechi.
- [ ] Excludere roboti, admin si trafic de dezvoltare.
- [ ] Procesare prin queue si agregare zilnica pentru performanta.
- [ ] Dashboard cu vizualizari, pagini populare si surse.
- [ ] Documentarea temeiului legal, retentiei si drepturilor utilizatorilor.

### SEO audit

- [ ] Comanda Laravel pentru sitemap si verificari interne.
- [ ] Worker Python separat pentru link-uri rupte, imagini fara `alt` si timpi de raspuns.
- [ ] Rulare programata, logare rezultate si notificare la esec.
- [ ] Fara executie de cod sau comenzi provenite direct din inputul utilizatorului.

**Criteriu de finalizare:** dashboard-ul este util fara a introduce tracking invaziv, iar auditul poate fi reluat si verificat.

## 7. Faza 4 - Produse si monetizare (dupa validarea MVP)

- [ ] Separarea produselor, planurilor, versiunilor si preturilor.
- [ ] Conturi de clienti si comenzi.
- [ ] Licente sau abonamente, numai dupa definirea fluxului comercial.
- [ ] Integrare procesator de plati prin webhook-uri semnate.
- [ ] Facturare, TVA, refund-uri si termeni comerciali.
- [ ] Teste pentru idempotenta platilor si reconciliere.

Aceasta faza nu va fi implementata inainte de validarea nevoii comerciale.

## 8. Faza 5 - Productie si operare

- [ ] VPS cu Ubuntu, Nginx, PHP, PostgreSQL/MySQL si Redis.
- [ ] Deploy automat sau repetabil din branch-ul stabil.
- [ ] HTTPS cu Let's Encrypt, firewall, SSH cu chei si fail2ban.
- [ ] Backup criptat automat si test periodic de restaurare.
- [ ] Error tracking, uptime monitoring si alertare.
- [ ] Cache, OPcache, queue workers si scheduler.
- [ ] Procedura de rollback si plan de incident.
- [ ] Verificare Lighthouse, Core Web Vitals si accesibilitate.

**Criteriu de lansare:** exista backup verificat, monitorizare, rollback si o procedura scrisa pentru incidente.

## 9. Definition of Done

O functionalitate este considerata finalizata numai daca:

1. are migrari si validare;
2. respecta autorizarea si confidentialitatea;
3. are teste relevante;
4. este responsive si accesibila;
5. este documentata;
6. functioneaza in staging;
7. are logging si tratarea explicita a erorilor;
8. poate fi lansata si retrasa controlat.

## 10. Ordinea imediata de lucru

1. Initializam proiectul Laravel in Laragon.
2. Configuram baza de date si autentificarea.
3. Implementam modelul MVP si panoul admin.
4. Construim paginile publice si SEO.
5. Adaugam testare, backup si staging.
6. Abia apoi introducem analytics, worker-ul Python si monetizarea.
