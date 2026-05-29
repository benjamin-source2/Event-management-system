@extends('layouts.app', ['title' => 'Manage Invitations'])

@section('content')
<div class="py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">Invitations</h1>
            <p class="text-gray-500 dark:text-gray-400">Manage all invitation requests</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.invitations') }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ !request('status') ? 'bg-primary-500 text-white' : 'bg-gray-100 dark:bg-navy-800 text-gray-600' }}">All</a>
            <a href="{{ route('admin.invitations', ['status' => 'pending']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('status') === 'pending' ? 'bg-amber-500 text-white' : 'bg-gray-100 dark:bg-navy-800 text-gray-600' }}">Pending</a>
            <a href="{{ route('admin.invitations', ['status' => 'approved']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('status') === 'approved' ? 'bg-emerald-500 text-white' : 'bg-gray-100 dark:bg-navy-800 text-gray-600' }}">Approved</a>
            <a href="{{ route('admin.invitations', ['status' => 'rejected']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('status') === 'rejected' ? 'bg-rose-500 text-white' : 'bg-gray-100 dark:bg-navy-800 text-gray-600' }}">Rejected</a>
        </div>
    </div>

    <div class="premium-card overflow-hidden">
        <div class="table-container">
            <table class="table-premium">
                <thead>
                    <tr><th>User</th><th>Event</th><th>Code</th><th>Status</th><th>Requested</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse($invitations as $invitation)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center text-white text-xs font-bold">{{ $invitation->user->initials }}</div>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $invitation->user->full_name ?: $invitation->user->name }}</span>
                                </div>
                            </td>
                            <td class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($invitation->event->title, 30) }}</td>
                            <td class="font-mono text-xs text-gray-500">{{ $invitation->invitation_code }}</td>
                            <td>
                                @if($invitation->approval_status === 'approved')
                                    <span class="badge-success">Approved</span>
                                @elseif($invitation->approval_status === 'rejected')
                                    <span class="badge-danger">Rejected</span>
                                @else
                                    <span class="badge-warning">Pending</span>
                                @endif
                            </td>
                            <td class="text-sm text-gray-500">{{ $invitation->created_at->diffForHumans() }}</td>
                            <td>
                                <div class="flex gap-2">
                                    @if($invitation->approval_status === 'pending')
                                        <form action="{{ route('admin.invitations.approve', $invitation) }}" method="POST" class="inline">@csrf
                                            <button type="submit" class="btn-success btn-sm flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> <span class="hidden lg:inline">Approve</span></button>
                                        </form>
                                    @endif
                                    <button onclick="showRejectModal({{ $invitation->id }})" class="btn-danger btn-sm flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> <span class="hidden lg:inline">Reject</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-8 text-gray-500">No invitations found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-6">{{ $invitations->links() }}</div>
</div>

<!-- Reject Modal -->
<div id="reject-modal" x-data="{ show: false, invitationId: null, reason: '' }" x-show="show" x-cloak class="modal-backdrop" @keydown.escape.window="show = false">
    <div class="modal-content" @click.outside="show = false">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Reject Invitation</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Provide a reason for rejection (optional)</p>
        <form :action="'/admin/invitations/' + invitationId + '/reject'" method="POST">
            @csrf
            <div class="input-group mb-4">
                <textarea x-model="reason" name="reason" rows="3" class="input-field" placeholder="Reason for rejection..."></textarea>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" @click="show = false" class="btn-secondary">Cancel</button>
                <button type="submit" class="btn-danger">Reject</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showRejectModal(invitationId) {
        const modalEl = document.getElementById('reject-modal');
        if (modalEl && modalEl.__x) {
            modalEl.__x.$data.invitationId = invitationId;
            modalEl.__x.$data.show = true;
        }
    }
</script>
@endsection
