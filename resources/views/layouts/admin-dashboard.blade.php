<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Admin Dashboard</title>
        <!-- ======= Styles ====== -->
        <link rel="stylesheet" href="import/assets/css/dashboard-style.css">
    </head>

    <body>
        <!-- =============== Navigation ================ -->
        <div class="container">
            <div class="navigation">
                <ul>
                    <li>
                        <a href="dashboard">
                            <span class="logo">
                                {{-- <img src="import/assets/img/sanpedrologo.png" alt="Logo"> --}}
                            </span>
                            {{-- <span class="title">Heaven's Cradle key</br>Memorial Park</span> --}}

                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <span class="icon">
                                <ion-icon name="documents-outline"></ion-icon>
                            </span>
                            <span class="title">Document Handling</span>
                        </a>
                    </li>

                    <li>
                        <a href="clients">
                            <span class="icon">
                                <ion-icon name="people-outline"></ion-icon>
                            </span>
                            <span class="title">Clients</span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <span class="icon">
                                <ion-icon name="receipt-outline"></ion-icon>
                            </span>
                            <span class="title">Transactions</span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <span class="icon">
                                <ion-icon name="calendar-number-outline"></ion-icon>
                            </span>
                            <span class="title">Schedule Management</span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <span class="icon">
                                <ion-icon name="person-outline"></ion-icon>
                            </span>
                            <span class="title">Deceased Records</span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <span class="icon">
                                <ion-icon name="map-outline"></ion-icon>
                            </span>
                            <span class="title">Plot Management</span>
                        </a>
                    </li>

                    {{-- <li>
                        <a href="#">
                            <span class="icon">
                                <ion-icon name="settings-outline"></ion-icon>
                            </span>
                            <span class="title">Settings</span>
                        </a>
                    </li> --}}

                    <li>
                        <a href="#">
                            <span class="icon">
                                <ion-icon name="people-circle-outline"></ion-icon>
                            </span>
                            <span class="title">User Management</span>
                        </a>
                    </li>
                </ul>
            </div>
                    <!-- ========================= Main ==================== -->
            <div class="main">
                <div class="topbar">
                    <div class="toggle">
                        <ion-icon name="menu-outline"></ion-icon>
                    </div>

                    <div class="search">
                        <label>
                            <input type="text" placeholder="Search here">
                            <ion-icon name="search-outline"></ion-icon>
                        </label>
                    </div>

                    <div class="user">
                        <img src="{{ Auth::guard('admin')->user()->profile_picture ? asset('storage/profile_pictures/admins/' . Auth::guard('admin')->user()->profile_picture) : asset('import/assets/img/customer01.jpg') }}" alt="User Profile Picture" onclick="toggleDropdown()">
                    </div>
                    <div class="dropdown-menu" id="dropdown-menu">
                        <p>Welcome, {{ Auth::guard('admin')->user()->name }}</p>
                        <a href="{{ route('hckmp.admin.adminprofile') }}">
                            <span class="icon">
                                <ion-icon name="person-outline"></ion-icon>
                            </span>
                            <span class="title">Profile</span>
                        </a>
                        <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span class="icon">
                                <ion-icon name="log-out-outline"></ion-icon>
                            </span>
                            <span class="title">Sign Out</span>
                        </a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
                <!-- Content will be injected here -->
                @yield('content')
            </div>
        </div>


        <!-- =========== Scripts =========  -->
    <script src="{{ asset('import/assets/js/client.js') }}"></script>
    <script src="{{ asset('import/assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="{{ asset('import/assets/js/chartsJS.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    </body>
</html>
