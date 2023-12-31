<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Prescription Management</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        jQuery(document).ready(function($) {
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });
        })
    </script>
    <style>
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css");

        body {
            overflow-x: hidden;
        }

        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -15rem;
            -webkit-transition: margin .25s ease-out;
            -moz-transition: margin .25s ease-out;
            -o-transition: margin .25s ease-out;
            transition: margin .25s ease-out;
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 0.875rem 1.25rem;
            font-size: 1.2rem;
        }

        #sidebar-wrapper .list-group {
            width: 15rem;
        }

        #page-content-wrapper {
            min-width: 100vw;
        }

        #wrapper.toggled #sidebar-wrapper {
            margin-left: 0;
        }

        @media (min-width: 768px) {
            #sidebar-wrapper {
                margin-left: 0;
            }

            #page-content-wrapper {
                min-width: 0;
                width: 100%;
            }

            #wrapper.toggled #sidebar-wrapper {
                margin-left: -15rem;
            }
        }

        .carousel-control-prev,
        .carousel-control-next {
            color: red;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: red;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 30px;
            height: 30px;
        }

        #photo_gal {
            width: 300px;
            /* Change the width as needed */
            height: 300px;
            /* Change the height as needed */
        }

        #page-content-wrapper {
            background-color: #b0e0e6;
            font-weight: bold;
        }

        #sidebar-wrapper {
            background-color: #ffefd5;
            font-weight: bold;
        }

        .list-group-item {
            background-color: #ffefd5;
            font-weight: bold;
        }

        .dropdown-menu {
            background-color: #f0e68c;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">PMS </div>
            <div class="list-group list-group-flush">

                <a href="/" class="list-group-item list-group-item-action">Dashboard</a>
                @if(session('user_type') === 'user')
                <a href="/prescriptions/create" class="list-group-item list-group-item-action">Add Prescription</a>
                <a href="/quotations" class="list-group-item list-group-item-action">Show Quotations</a>

                @endif
                @if(session('user_type') === 'admin')
                <a href="/prescriptions" class="list-group-item list-group-item-action">View Prescription</a>
                <a href="/accepted_quotations" class="list-group-item list-group-item-action">Show Accepted Quotations</a>
                @endif

            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg navbar-light border-bottom">

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a id="navbarNotification" class="nav-link" href="#" onclick="toggleNotificationDropdown();" aria-haspopup="true" aria-expanded="false" v-pre>
                                <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                                <lord-icon src="https://cdn.lordicon.com/msetysan.json" trigger="hover" colors="primary:#121331" style="width:25px;height:25px">
                                </lord-icon>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="badge badge-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
                                @endif
                            </a>
                            <ul id="notificationDropdown" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarNotification">
                                @foreach(auth()->user()->unreadNotifications as $notification)
                                <a class="dropdown-item list-group-item alert-{{ $notification->type }} notification-item" data-notification-id="{{ $notification->id }}">
                                    {{ $notification->data['message'] }}
                                </a>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" onclick="toggleUserDropdown();" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div id="userDropdown" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->
    <script>
        $(document).ready(function() {
            $('.notification-item').on('click', function() {
                var notificationId = $(this).data('notification-id');

                // Send an AJAX request to mark the notification as read
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/mark-as-read/' + notificationId,
                    method: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Remove the notification item from the DOM
                            $(this).remove();
                        } else {
                            alert('Failed to mark the notification as read.');
                        }
                    }.bind(this), // Ensure 'this' refers to the clicked notification
                    error: function() {
                        alert('An error occurred while processing your request.');
                    }
                });
            });
        });

        function toggleNotificationDropdown() {
            var notificationDropdown = document.getElementById("notificationDropdown");
            if (notificationDropdown.style.display === "block") {
                notificationDropdown.style.display = "none";
            } else {
                notificationDropdown.style.display = "block";
            }
        }

        function toggleUserDropdown() {
            var userDropdown = document.getElementById("userDropdown");
            if (userDropdown.style.display === "block") {
                userDropdown.style.display = "none";
            } else {
                userDropdown.style.display = "block";
            }
        }
    </script>
</body>

</html>