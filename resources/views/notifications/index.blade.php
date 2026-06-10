@extends('layouts.Nav')

@section('title', 'Notifications')
@section('page-title', 'Notifications')
@section('breadcrumb')
    <span>/</span> <span>Notifications</span>
@endsection

@section('content')
<div style="max-width:720px;">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
        <h2 style="font-size:1.1rem;font-weight:700;color:#0f172a;margin:0;">All Notifications</h2>
        @if(auth()->user()->unreadNotifications()->count() > 0)
        <form method="POST" action="{{ route('notifications.readAll') }}">
            @csrf
            <button type="submit"
                style="font-size:.8rem;font-weight:600;color:#1d4ed8;background:none;border:none;cursor:pointer;padding:6px 12px;border-radius:8px;transition:background .15s;"
                onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='none'">
                Mark all as read
            </button>
        </form>
        @endif
    </div>

    @forelse($notifications as $n)
    @php $data = $n->data; $isRead = !is_null($n->read_at); @endphp
    <a href="{{ route('notifications.read', $n->id) }}"
       style="display:flex;align-items:flex-start;gap:14px;padding:14px 16px;background:#fff;border-radius:12px;margin-bottom:8px;text-decoration:none;border:1px solid {{ $isRead ? '#e8eef4' : '#bfdbfe' }};transition:box-shadow .15s;"
       onmouseover="this.style.boxShadow='0 2px 12px rgba(0,0,0,.08)'" onmouseout="this.style.boxShadow='none'">

        <div style="width:40px;height:40px;border-radius:50%;flex-shrink:0;
                    background:{{ $isRead ? '#f1f5f9' : '#eff6ff' }};
                    display:flex;align-items:center;justify-content:center;">
            <i class="material-icons-round" style="font-size:1.2rem;color:{{ $isRead ? '#94a3b8' : '#1d4ed8' }};">
                {{ $data['icon'] ?? 'notifications' }}
            </i>
        </div>

        <div style="flex:1;min-width:0;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:2px;">
                <span style="font-size:.88rem;font-weight:{{ $isRead ? '500' : '700' }};color:#0f172a;">
                    {{ $data['title'] ?? 'Notification' }}
                </span>
                @if(!$isRead)
                <span style="width:7px;height:7px;border-radius:50%;background:#1d4ed8;flex-shrink:0;"></span>
                @endif
            </div>
            <div style="font-size:.82rem;color:#64748b;line-height:1.4;">{{ $data['message'] ?? '' }}</div>
            <div style="font-size:.74rem;color:#94a3b8;margin-top:4px;">
                {{ \Carbon\Carbon::parse($n->created_at)->diffForHumans() }}
            </div>
        </div>
    </a>
    @empty
    <div style="text-align:center;padding:60px 20px;background:#fff;border-radius:12px;">
        <i class="material-icons-round" style="font-size:3rem;color:#cbd5e1;display:block;margin-bottom:12px;">notifications_none</i>
        <p style="color:#64748b;font-size:.92rem;margin:0;">You have no notifications yet.</p>
    </div>
    @endforelse

    <div style="margin-top:16px;">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
