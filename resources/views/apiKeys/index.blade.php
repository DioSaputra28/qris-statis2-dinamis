@extends('layouts.app')

@section('title', 'API Key')

@section('content')
<div class="space-y-6">
    <!-- Table Section -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <!-- Header with Search and Actions -->
            <div class="flex flex-col md:flex-row gap-4 mb-4">
                <div class="flex-1">
                    <div class="form-control">
                        <div class="input-group flex gap-3">
                            <input type="text" placeholder="Cari API Key..." class="input input-bordered w-full" />
                            <button class="btn btn-square">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-2">
                    <button class="btn btn-primary gap-2" onclick="create_api_key_modal.showModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create
                    </button>
                </div>
            </div>
            
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Key</th>
                            <th>Created At</th>
                            <th>Total Call</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <code class="text-sm">sk_live_abc123...xyz789</code>
                                    <button class="btn btn-ghost btn-xs" title="Copy">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm">2024-11-17 10:30:00</div>
                            </td>
                            <td>
                                <div class="badge badge-ghost">1,234</div>
                            </td>
                            <td>
                                <button class="btn btn-ghost btn-sm text-error">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <code class="text-sm">sk_live_def456...uvw012</code>
                                    <button class="btn btn-ghost btn-xs" title="Copy">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm">2024-11-16 14:20:00</div>
                            </td>
                            <td>
                                <div class="badge badge-ghost">856</div>
                            </td>
                            <td>
                                <button class="btn btn-ghost btn-sm text-error">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <code class="text-sm">sk_live_ghi789...rst345</code>
                                    <button class="btn btn-ghost btn-xs" title="Copy">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm">2024-11-15 09:15:00</div>
                            </td>
                            <td>
                                <div class="badge badge-ghost">2,567</div>
                            </td>
                            <td>
                                <button class="btn btn-ghost btn-sm text-error">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="flex justify-center mt-4">
                <div class="join">
                    <button class="join-item btn btn-sm">«</button>
                    <button class="join-item btn btn-sm btn-active">1</button>
                    <button class="join-item btn btn-sm">2</button>
                    <button class="join-item btn btn-sm">3</button>
                    <button class="join-item btn btn-sm">»</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create API Key Modal -->
<dialog id="create_api_key_modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Buat API Key Baru</h3>
        
        <form method="dialog">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Nama API Key</span>
                </label>
                <input type="text" placeholder="Masukkan nama API Key" class="input input-bordered w-full" />
                <label class="label">
                    <span class="label-text-alt hidden md:block">Nama ini akan membantu Anda mengidentifikasi API Key</span>
                </label>
            </div>
            
            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="create_api_key_modal.close()">Cancel</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
@endsection
