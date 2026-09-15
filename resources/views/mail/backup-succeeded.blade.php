<x-mail::message>
# Backup finalizat cu succes

Backup-ul automat pentru Conectica IT s-a incheiat fara probleme.

**Baza de date:** {{ $dumpName }} ({{ $dumpSize }})

@if ($filesZipName)
**Fisiere incarcate:** {{ $filesZipName }}
@endif

Daca dump-ul bazei de date a fost suficient de mic, il gasesti atasat la acest email. Toate fisierele raman si pe server, in `storage/app/backups`, cu rotatie automata (se pastreaza ultimele 14 backup-uri).

</x-mail::message>
