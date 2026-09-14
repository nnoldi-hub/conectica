<x-filament-widgets::widget>
    <x-filament::section heading="Actiuni rapide">
        <div class="grid gap-3 sm:grid-cols-3">
            <a href="{{ route('filament.admin.resources.projects.create') }}" class="rounded-xl border border-gray-200 p-4 text-sm font-semibold transition hover:border-primary-500 hover:text-primary-600 dark:border-white/10">
                + Proiect nou
            </a>
            <a href="{{ route('filament.admin.resources.posts.create') }}" class="rounded-xl border border-gray-200 p-4 text-sm font-semibold transition hover:border-primary-500 hover:text-primary-600 dark:border-white/10">
                + Articol nou
            </a>
            <a href="{{ route('filament.admin.resources.services.create') }}" class="rounded-xl border border-gray-200 p-4 text-sm font-semibold transition hover:border-primary-500 hover:text-primary-600 dark:border-white/10">
                + Serviciu nou
            </a>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
