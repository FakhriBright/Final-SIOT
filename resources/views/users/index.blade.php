@extends('layouts.app')

@section('title', 'Kelola Pengguna - FR-SIOT Platform')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-active">Pengguna</span>
@endsection

@section('content')
<div class="page-header">
    <div class="page-title-row">
        <h1>Manajemen Anggota Tim</h1>
        <p>Lihat dan kelola akun pengguna yang memiliki akses ke platform IoT FR-SIOT.</p>
    </div>
</div>

<div class="table-wrapper">
    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Alamat Email</th>
                    <th>Hak Akses (Role)</th>
                    <th>Terdaftar Pada</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                                <div class="user-avatar" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <strong style="color: var(--text-primary);">{{ $user->name }}</strong>
                            </div>
                        </td>
                        <td><code>{{ $user->email }}</code></td>
                        <td>
                            <span class="badge {{ $user->role === 'admin' ? 'badge-online' : 'badge-offline' }}" style="background-color: var(--bg-input); border-color: var(--border-color)">
                                <span class="badge-dot" style="background-color: {{ $user->role === 'admin' ? 'var(--primary)' : 'var(--text-secondary)' }};"></span>
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            {{ $user->created_at->format('d M Y H:i') }}
                            <br>
                            <small style="color: var(--text-muted);">{{ $user->created_at->diffForHumans() }}</small>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--text-muted); padding: var(--spacing-xl);">
                            Tidak ada data pengguna.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- PAGINATION -->
@if($users->hasPages())
    <div class="pagination-area filter-bar">
        <div style="font-size: 0.875rem; color: var(--text-secondary);">
            Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} pengguna
        </div>
        <div>
            {{ $users->links() }}
        </div>
    </div>
@endif

@endsection
