
<div class="chat col-sm-5 mb-3 mb-sm-0">
    <div class="form-container-satpam2">
        <h5 class="card-title" style="text-align: center;">Chat</h5>
        <hr>
    </div>
    <div class="form-container-satpam4 p-4 example-1 scrollbar-ripe-malinka">
        <div class="card-body">
        @php
            $last = null;
        @endphp

        @forelse($historyChats as $historyChat)
            @php
                $now = \Carbon\Carbon::parse($historyChat->created_at)->addHours(7)->format('Y-m-d');
            @endphp

            @if($now !== $last)
                @php
                    $today = new DateTime();
                    $todayFormat = \Carbon\Carbon::parse($today)->addHours(7)->format('Y-m-d');
                @endphp

                @if($now == $todayFormat)
                    <p class="text-center">Today</p>
                @else
                    <p class="text-center">{{ date('d F Y', strtotime($now)) }}</p>
                @endif
            @endif

            @php
                $last = $now;
            @endphp
            @if ($countUnread !== null && $countUnread === $historyChat->id )
                <p class="text-center" style="font-weight: bold;" id="unreadMessage">{{ $sumUnread }} Unread Messages</p>
            @endif
            <div class="chat-container {{ $historyChat->sender_id == Auth::user()->account_id ? 'darker' : ' ' }}">
                <div class="chat-icon">
                    <img src="\monitoring-chat\assets\icon-user.png" alt="User Icon">
                </div>
                <div class=" d-grid gap-2">
                    <div class="chat-content">
                        <p style="padding: 0px; margin-bottom: 0px;">{{ $historyChat->message }}</p>
                    </div>
                    @php
                    $createdAtDate = \Carbon\Carbon::parse($historyChat->created_at);
                    $formattedTime = $createdAtDate->addHours(7)->format('h:i A');
                    @endphp
                    <div class="chat-time" style="margin-<?php echo $historyChat->sender_id == auth()->user()->account_id ? 'left' : 'right'?>: auto;">{{ $formattedTime }}</div>
                </div>
            </div>
            @empty
            <div class="alert alert-danger">
                Tidak ada History Chat
            </div>
            @endforelse
