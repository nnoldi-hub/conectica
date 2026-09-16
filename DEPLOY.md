# Deploy pe server (Hostico / cPanel)

## Pași standard după `git push`

```bash
cd ~/conectica   # calea reala de pe server
git pull origin main
```

## Rebuild assets frontend (CSS/JS)

`public/build/` **nu este versionat in Git** (vezi `.gitignore`), deci trebuie
regenerat manual pe server dupa orice modificare in `resources/js` sau `resources/css`.

Hostico limiteaza numarul de thread-uri disponibile per proces, ceea ce face ca
`npm run build` sa esueze cu:

```
thread '<unnamed>' panicked at .../rayon-core.../registry.rs:168:10:
The global thread pool has not been initialized.: ThreadPoolBuildError { ... WouldBlock ... }
fatal runtime error: failed to initiate panic, error 5, aborting
```

**Solutie:** limiteaza explicit thread-pool-ul Rust (folosit de Vite/Lightning CSS)
la 1 thread:

```bash
RAYON_NUM_THREADS=1 npm run build
```

Daca tot esueaza, incearca suplimentar:

```bash
NODE_OPTIONS=--max-old-space-size=512 RAYON_NUM_THREADS=1 npm run build
```

## Dupa build

```bash
php artisan optimize:clear
```

## Alte probleme cunoscute de hosting (functii PHP dezactivate)

- `escapeshellarg()` este indisponibila -> `composer install` si comenzi Artisan
  care creeaza symlink-uri (ex. `php artisan storage:link`) pot esua.
  - Pentru storage link, creeaza-l manual din shell:
    ```bash
    ln -sf ../storage/app/public public/storage
    ```
  - Symlink-urile nu sunt versionate in Git si trebuie recreate manual dupa
    orice restaurare/arhivare de fisiere pe server.
