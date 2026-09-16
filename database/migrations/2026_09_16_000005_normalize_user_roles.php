<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Normalizeaza rolurile existente pe noua schema cu 4 niveluri:
     * admin, manager, editor, viewer.
     *
     * Maparea vechilor valori:
     *   super_admin -> admin
     *   editor      -> editor (neschimbat)
     *   analyst     -> viewer
     *
     * "manager" este un rol complet nou, fara utilizatori existenti de migrat.
     */
    public function up(): void
    {
        DB::table('users')->where('role', 'super_admin')->update(['role' => 'admin']);
        DB::table('users')->where('role', 'analyst')->update(['role' => 'viewer']);
    }

    public function down(): void
    {
        DB::table('users')->where('role', 'admin')->update(['role' => 'super_admin']);
        DB::table('users')->where('role', 'viewer')->update(['role' => 'analyst']);
        DB::table('users')->where('role', 'manager')->update(['role' => 'editor']);
    }
};
