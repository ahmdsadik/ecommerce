@extends('dashboard.layouts.app')

@section('title')
    {{ __('dashboard/chat/index.title') }}
@endsection

@push('css')
    <link rel="stylesheet"
          href="{{ asset('assets/dashboard/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.css') }}"/>

    <link rel="stylesheet" href="{{ asset('assets/dashboard/vendor/css/pages/app-chat.css') }}"/>

@endpush

@push('js')
    <script src="{{ asset('assets/dashboard/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>

    <script src="{{ asset('assets/dashboard/js/app-chat.js') }}"></script>


    @vite(['resources/js/chat.js'])
@endpush


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="app-chat overflow-hidden card">
            <div class="row g-0">

                <!-- Chat & Contacts -->
                <div class="col app-chat-contacts app-sidebar flex-grow-0 overflow-hidden border-end"
                     id="app-chat-contacts">
                    <div class="sidebar-header pt-3 px-3 mx-1 text-center">
                        <div class="my-1">
                            {{ __('dashboard/chat/index.online_users') }} (<span id="online-users-count"></span>)
                        </div>
                    </div>
                    <hr class="container-m-nx mt-3 mb-0">
                    <div class="sidebar-body">

                        <!-- Contacts -->
                        <ul id="online-users" class="list-unstyled chat-contact-list mb-0">

                        </ul>
                    </div>
                </div>
                <!-- /Chat contacts -->

                <!-- Chat History -->
                <div class="col app-chat-history">
                    <div class="chat-history-wrapper">
                        <div class="chat-history-header border-bottom">
                            <div class="d-flex justify-content-center align-items-center">
                                <span>{{ __('dashboard/chat/index.messages') }}</span>
                            </div>
                        </div>
                        <div class="chat-history-body">
                            <ul class="list-unstyled chat-history mb-0" id="chat-msg">
                                @foreach($messages as $message)

                                    @if($message->user_id == auth()->id())
                                        <li class="chat-message chat-message-right">
                                            <div class="d-flex overflow-hidden">
                                                <div class="chat-message-wrapper flex-grow-1">
                                                    <div class="chat-message-text">
                                                        <p class="mb-0">{{ $message->body }}</p>
                                                    </div>
                                                    <div class="text-muted mt-1">
                                                        <small>{{ $message->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                    @else

                                        <li class="chat-message">
                                            <div class="d-flex overflow-hidden">
                                                <div class="user-avatar flex-shrink-0 me-3">
                                                    <div class="avatar avatar-sm">
                                                        <img src="{{ $message->user->imgUrl }}"
                                                             alt="Avatar" class="rounded-circle">
                                                    </div>
                                                </div>
                                                <div class="chat-message-wrapper flex-grow-1">
                                                    <div class="chat-message-text">
                                                        <small class="my-1 text-primary">
                                                            {{ $message->user->name }}
                                                        </small>
                                                        <p class="mb-0">{{ $message->body }}</p>
                                                    </div>
                                                    <div class="text-muted mt-1">
                                                        <small>{{ $message->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                    @endif

                                @endforeach

                            </ul>

                            <div class="my-1 p-1">
                                <span id="typing"></span>
                            </div>
                        </div>
                        <!-- Chat message form -->
                        <div class="chat-history-footer">
                            <form class="form-send-message d-flex justify-content-between align-items-center ">
                                <input class="form-control message-input border-0 me-3 shadow-none"
                                       placeholder="{{ __('dashboard/chat/index.type_message_placeholder') }}">
                                <div class="message-actions d-flex align-items-center">
                                    <i class="speech-to-text bx bx-microphone bx-sm cursor-pointer"></i>
                                    <label for="attach-doc" class="form-label mb-0">
                                        <i class="bx bx-paperclip bx-sm cursor-pointer mx-3"></i>
                                        <input type="file" id="attach-doc" hidden>
                                    </label>
                                    <button class="btn btn-primary d-flex send-msg-btn">
                                        <i class="bx bx-paper-plane me-md-1 me-0"></i>
                                        <span class="align-middle d-md-inline-block d-none">{{ __('dashboard/chat/index.send_message') }}</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Chat History -->


                <div class="app-overlay"></div>
            </div>
        </div>
    </div>
@endsection



