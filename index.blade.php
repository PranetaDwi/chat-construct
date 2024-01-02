@extends('monitoring-chat.layout-base.layout')

@section('title', 'List Progres Proyek')

@section('monitoring_chat')
@php
    if ($percentage ===  0){
        $rotate = 180;
        $type = 'loading-2';
    } elseif ($percentage <= 50){
        $rotate = $percentage / 100 * 360;
        $type = 'loading-1';
    } elseif ($percentage > 50 && $percentage < 100){
        $rotate = ($percentage / 100 * 360) - 180;
        $type = 'loading-2';
    } elseif ($percentage === 100){
        $rotate = 180;
        $type = 'loading-2';
    }
@endphp
<link rel="stylesheet" href="/monitoring-chat/css/progress-user.css">
<style>
.progress .progress-right .progress-bar {
  left: -100%;
  border-top-left-radius: 80px;
  border-bottom-left-radius: 80px;
  border-right: 0;
  -webkit-transform-origin: center right;
  transform-origin: center right;
  animation: <?php echo $type;?> 1.8s linear forwards;
}
    @keyframes loading-1 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }

  100% {
    -webkit-transform: rotate(<?php echo $rotate;?>deg);
    transform: rotate(<?php echo $rotate;?>deg);
  }
}
@keyframes loading-2 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }

  100% {
    -webkit-transform: rotate(180deg);
    transform: rotate(180deg);
  }
}
</style>
@vite('resources/js/app.js')
@endsection

@section('content')
<div class="dashboard__content bgc-f7 row mx-auto" style="display: flex;">
    <div class="col-lg-12 d-flex align-items-center">
        <a href="{{ route('projectProgress.page') }}">
            <div class="back-icon-container">
                <i class="fas fa-angle-left fa-2x" style="color:#161717;"></i>
            </div>
        </a>
        <div class="dashboard_title_area">
            <h2>Monitoring and Chat</h2>
        </div>
    </div>

    <p class="text" style="margin-left: 47px;">Monitoring Progres Pembangunan</p>
    <div class="row" style="padding:0px; margin:0px;">
        <div id="1" class="col-md-3 ms-0 ms-sm-5">
            <div class="card satu" style="box-shadow: 0 1px 1px black;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 mt-4 d-flex flex-column align-items-center">
                            <div id="circle_progress" class="progress {{ ($project_progress_list->status == 'On-Progress' ? 'blue' : ($project_progress_list->status == 'Done' ? 'green' : 'pink')) }}">
                                <span class="progress-left">
                                    <span class="{{ $percentage > 50 || $percentage === 0? 'progress-bar' : ' ' }}"></span>
                                </span>
                                <span class="progress-right">
                                    <span class="progress-bar"></span>
                                </span>
                                <div class="progress-value" id="persentaseResource"><p>{{ $percentage }}%</p></div>
                            </div>
                            <h5 id="title_progress" class="card-title p-3">{{ $project_progress_list->status }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 mt-3 mt-sm-0">
            <div class="card dua gap-3 p-3 col-12 progress-right-info">
                <div class="card p-3" style="height: 50px; box-shadow: 0 1px 1px black;">
                    <div class="row">
                        <div class="col-6">
                            <h6 class="card-title">
                                <img src="\monitoring-chat\assets\icon-user.png">
                                {{ $project_progress_list->developer_name }}
                            </h6>
                        </div>

                        <div class="col-6">
                            <h6 class="card-title">
                                <img src="\monitoring-chat\assets\icon-phone.png">
                                {{ $project_progress_list->developer_phone }}
                            </h6>
                        </div>
                    </div>
                </div>

                <div class="card p-3" style="box-shadow: 0 1px 1px black;">
                    <h5 class="card-title">{{ $project_progress_list->title }}</h5>
                    <hr>
                    <div class="list-meta2" style="margin-top: 15px;">
                        <div class="kartu d-flex justify-content-between">
                            @php
                            $path_function = 'App\Http\Controllers\Web\MonitoringChat\CommonFunction';
                            @endphp
                            <h6 class="card-title"><img
                                    src=" \monitoring-chat\assets\icon-money.png"> Rp{{ number_format($project_progress_list->price, 0, ',', '.') }}</h6>
                            <h6 class="card-title"> <img
                                    src=" \monitoring-chat\assets\icon-calender.png"> {{ $path_function::dateFormat($project_progress_list->start_date) }} - {{ $path_function::dateFormat($project_progress_list->end_date)  }}</h6>
                        </div>
                        <div>
                            <h6 class="card-title"><img
                                    src=" \monitoring-chat\assets\icon-pin.png"> 
                                    {{ ucwords(strtolower($project_progress_list->address)) }}, 
                                    {{ ucwords(strtolower($project_progress_list->district)) }}, 
                                    {{ ucwords(strtolower($project_progress_list->city)) }}, 
                                    {{ ucwords(strtolower($project_progress_list->province)) }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-4" style="padding: 0px; margin:0px;">
        <div class="progres col-sm-6 mb-3 mb-sm-0 ms-0 ms-sm-5" >
            <div class="form-container-satpam2 card card-body text-center">
                <h5 class="card-title">Progres Pembangunan</h5>
                <hr>
            </div>
            <div id="data-progress" style="height:490px;" class="form-container-satpam p-4 example-1 scrollbar-ripe-malinka">
                <div class="card-body text-center pb-3">
                    @forelse($progresses as $progress)
                    <div class="progress-container-grid" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal123" id="btnModalDetail"
                                onclick="showModalBuatDetail('{{ $progress->id }}')" >
                        <h6 class="mb-5">{{ $progress->brief_description }}</h6>
                        <div class="progress-bar-container">
                            <div class="progress-circle1"><img src="\monitoring-chat\assets\icon-roofhome.png"
                                    style="left: 10px; width: 30px; height: 30px;"></div>
                                <div class="progress-bar" style="width: <?php echo $progress->percentage; ?>%;"></div>
                            <div class="progress-circle2">{{ $progress->percentage }}%</div>
                        </div>
                        <div class="progress-details">
                            <div>{{ \Carbon\Carbon::parse($progress->created_at)->diffForHumans() }}</div>
                            <a>
                                Lihat Detail
                            </a>
                        </div>  
                    </div>
                    <div class=" {{ $progress->id === $oldest_progress->id || $progresses->count() == 1 ? ' ' : 'progress-to'}}"></div>
                    @empty
                    <div class="alert alert-danger">
                        Data Progres belum Tersedia
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

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

                    <div class="chatContainerAppend"></div>
                    <input type="hidden" id="chatLatestDate" value="{{ $latestDate }}">
                    <input type="hidden" class="form-control" id="chatParam" value="{{ $project_progress_list->id }}">
                    <input type="hidden" id="current_user" value="{{ \Auth::user()->account_id }}" />
                 </div>
            </div>
            <form class="form-container-satpam3">
                <div class="form-group d-flex justify-content-between">
                <input type="text" class="form-control" placeholder="Ketik Pesan" style="height: 50px;" id="chatInput" name="message">
                    <button type="button" class="btn btn-outline-dark" id="chatButton" style="height: 50px;">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade " id="exampleModalDetail" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">Data Detail Progres</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <h5 class="text-start p-2">Nama Progres Pembangunan</h5>
                <div class="card" style="margin: 10px;">
                    <div class="card-body">
                        <p class="card-text text-start" id="namaProgres">
                        </p>
                    </div>
                </div>

                <h5 class="text-start p-2">Deskripsi Progres</h5>
                <div class="card" style="margin: 10px;">
                    <div class="card-body">
                        <p class="card-text text-start" id="detailProgres">
                        </p>
                    </div>
                </div>
                <h5 class="text-start p-2">Bukti VIsual</h5>
                <div id="carouselExampleFade" class="carousel slide carousel-fade">
                    <div class="carousel-inner" id="carouselInner">
                    </div>
                    <button class="carousel-control-prev" type="button"
                        data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button"
                        data-bs-target="#carouselExampleFade" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function showModalBuatDetail(id) {
        var route = "{{ route('progress.detail', ':isi') }}";
        route = route.replace(':isi', id);

        console.log(id);

        $.ajax({
            type: 'get',
            url: route,
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (data) {
                $('#namaProgres').text(data.progres.name);
                $('#detailProgres').text(data.progres.detail);

                $('#carouselInner').empty();

                if (Array.isArray(data.pictures)) {
                    data.pictures.forEach(function (picture, index) {
                        var itemClass = index === 0 ? 'active' : '';
                        var imagePath = picture.url;

                        var carouselItem = '<div class="carousel-item ' + itemClass + '">'
                            + '<img src="' + imagePath + '" class="d-block w-100">'
                            + '</div>';

                        $('#carouselInner').append(carouselItem);
                    });
                };

                $('#exampleModalDetail').modal('show');

            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            },
        });
    }
</script>

<script type="text/javascript">
        var token = '{{ csrf_token() }}';
</script>

@endsection