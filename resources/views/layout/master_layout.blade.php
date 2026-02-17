<!DOCTYPE html>
<html class="no-js" lang="en_AU" />

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>CareerVibe | Find Best Jobs</title>
    <meta name="description" content="" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />
    <meta name="HandheldFriendly" content="True" />
    <meta name="pinterest" content="nopin" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />
    <!-- Fav Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="#" />
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/ui/trumbowyg.min.css" integrity="sha512-Fm8kRNVGCBZn0sPmwJbVXlqfJmPC13zRsMElZenX6v721g/H7OukJd8XzDEBRQ2FSATK8xNF9UYvzsCtUpfeJg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
</head>

<body data-instant-intensity="mousedown">
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow py-3">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">CareerVibe</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-0 ms-sm-0 me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href={{ url('/') }}>Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href={{ url('/job') }}>Find Jobs</a>
                        </li>
                    </ul>

                    @if (!Auth::check())
                    <a class="btn btn-outline-primary me-2" href={{ url('/login') }} type="submit">Login</a>
                    @else
                    @if (Auth::user()->role =='admin')

                    <a class="btn btn-outline-primary me-2" href={{ route('admin.dashboard') }} type="submit">Admin</a>
                    @endif


                        <a class="btn btn-outline-primary me-2" href={{ url('/account') }} type="submit">Account</a>
                    @endif
                    <a class="btn btn-primary" href={{ url('/postjob') }} type="submit">Post a Job</a>
                </div>
            </div>
        </nav>
    </header>


    <main class="main">

        @yield('page')

    </main>

    <footer style="background: #2c3e50; color: #ecf0f1; padding: 60px 20px; text-align: center;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="display: flex; flex-wrap: wrap; justify-content: space-around; align-items: flex-start;">
                <div style="flex: 1 1 200px; margin-bottom: 20px;">
                    <h3 style="color: #ecdbba; font-size: 24px; margin-bottom: 10px;">About Us</h3>
                    <p style="font-size: 14px;">We are a creative agency focused on delivering unique and high-quality
                        digital experiences. Our goal is to make your brand stand out.</p>
                </div>
                <div style="flex: 1 1 200px; margin-bottom: 20px;">
                    <h3 style="color: #ecdbba; font-size: 24px; margin-bottom: 10px;">Quick Links</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li><a href={{ route('postjob') }} style="color: #ecf0f1; text-decoration: none; font-size: 14px;">Post a Job</a>
                        </li>
                        <li><a href={{ route('myjob') }}
                                style="color: #ecf0f1; text-decoration: none; font-size: 14px;">My Job</a>
                        </li>
                        <li><a href={{ route('mjobApplication') }}
                                style="color: #ecf0f1; text-decoration: none; font-size: 14px;">Job Applied </a>
                        </li>
                        <li><a href={{ route('savedJobs') }}
                                style="color: #ecf0f1; text-decoration: none; font-size: 14px;">Saved Job</a>
                        </li>
                    </ul>
                </div>
                <div style="flex: 1 1 200px; margin-bottom: 20px;">
                    <h3 style="color: #ecdbba; font-size: 24px; margin-bottom: 10px;">Follow Us</h3>
                    <div style="display: flex; justify-content: center;">
                       <a href="https://www.facebook.com/share/vqvvyTnonVqKJChm/?mibextid=qi2Omg"> <i class="fa fa-facebook" aria-hidden="true" style="font-size: 30px;margin: 0 10px;"></i></a>
                        <i class="fa fa-twitter" aria-hidden="true" style="font-size: 30px;margin: 0 10px;"></i>
                       <a href="https://www.instagram.com/edugaon?igsh=ZnJubnl4cjV2cXRk"> <i class="fa fa-instagram" aria-hidden="true" style="font-size: 30px;margin: 0 10px;"></i></a>
                       <a href="https://www.linkedin.com/company/edugaon/"> <i class="fa fa-linkedin" aria-hidden="true" style="font-size: 30px;margin: 0 10px;"></i></a>
                    </div>
                </div>
                <div style="flex: 1 1 200px; margin-bottom: 20px;">
                    <h3 style="color: #ecdbba; font-size: 24px; margin-bottom: 10px;">Contact Us</h3>
                    <p style="font-size: 14px;">Email :- edugaon@gmail.com</p>
                    <p style="font-size: 14px;">Phone :- +91 8709579455</p>
                </div>
            </div>
            <div style="margin-top: 30px; border-top: 1px solid #ecdbba; padding-top: 20px;">
                <p style="margin: 0;">&copy; Edugaon Education and Innovation Labs Private Limited</p>
            </div>
        </div>
        <div style="margin-right: 20px">

        </div>
    </footer>

    {{-- <footer class="bg-dark py-3 bg-2">
        <div class="container">
            <p class="text-center text-white pt-3 fw-bold fs-6">© 2023 xyz company, all right reserved</p>
        </div>
    </footer> --}}
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
    <script src="{{ asset('assets/js/instantpages.5.1.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/lazyload.17.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js" integrity="sha512-YJgZG+6o3xSc0k5wv774GS+W1gx0vuSI/kr0E0UylL/Qg/noNspPtYwHPN9q6n59CTR/uhgXfjDXLTRI+uIryg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        // $('.textarea').trumbowyg();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('customJs')
    @yield('profileJs')
</body>

</html>
