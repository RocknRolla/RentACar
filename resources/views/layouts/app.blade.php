<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RentACar</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:600,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="../../../css/icons/css/fontello.css" media="all" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../css/style.css">
    <link rel="stylesheet" href="../../../../css/bootstrap-datetimepicker.css">


    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>

        .fa-btn {
            margin-right: 6px;
        }

        [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
            display: none !important;
        }
    </style>
</head>
<body id="app-layout" ng-app="rentACarApp">
    <header class="container">

    </header>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('home') }}">{!! trans('app.home') !!}</a></li>
                    <li><a href="{{ route('fleet') }}">{!! trans('app.fleet') !!}</a></li>
                    <!--link je vidljiv samo adminu-->
                    @if ( Auth::user()["isAdmin"] )
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" >
                                {!! trans('app.data') !!} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('getBranchesCitiesView') }}">{!! trans('app.branches') !!}</a></li>
                                <li><a href="{{ route('getCarsView') }}">{!! trans('app.cars') !!}</a></li>
                                <li><a href="{{ route('getClassesView') }}">{!! trans('app.classes') !!}</a></li>
                                <li><a href="{{ route('getExtrasView') }}">{!! trans('app.extras') !!}</a></li>
                                <li><a href="{{ route('getFuelsView') }}">{!! trans('app.fuels') !!}</a></li>
                                <li><a href="{{ route('getMakesModelsView') }}">{!! trans('app.makes_models') !!}</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ route('getReservationsView') }}" >{!! trans('app.reservations') !!}</a></li>
                    @endif
                    <li><a href="{{ route('contact') }}">{!! trans('home.contact') !!}</a></li>
                    <li><a href="/settings/lang/en" style="padding-bottom: 0;padding-top:0;"><img src="../../../img/flags/en.png"></a></li>
                    <li><a href="/settings/lang/hr" style="padding-bottom: 0;padding-top:0;"><img src="../../../img/flags/hr.png"></a></li>


                </ul>
                <ul class="nav navbar-nav navbar-right">

                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">{!! trans('app.login') !!}</a></li>
                        <li><a href="{{ url('/register') }}">{!! trans('app.registration') !!}</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('getUserReservationsView') }}">{!! trans('app.my_reservations') !!}</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>{!! trans('app.logout') !!}</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <!--Start Login modal-->
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                    <h4>Prijava</h4>
                </div>
                <!--Start Login Form -->
                <form id="login-form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="login-username">Username:</label>
                            <input id="login-username" name="login-username" class="form-control" type="text" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <label for="login-password">Password:</label>
                            <input id="login-password" name="login-password" class="form-control" type="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div>
                            <button type="reset" class="btn btn-info" data-dismiss="modal">Odustani</button>
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </div>
                </form>
                <!-- End  Login Form -->
            </div>
        </div>
    </div>
    <!-- End Login Modal -->

    <!--Start Register Modal-->
    <div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" >
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                    <h4>Registracija</h4>
                </div>
                <!-- Start Register Form -->
                <form id="register-form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="register-name">Ime i prezime:</label>
                            <input id="register-name" name="register-name" class="form-control" type="text" placeholder="Ime i prezime" required>
                        </div>
                        <div class="form-group">
                            <label for="register-username">Username:</label>
                            <input id="register-username" name="register-username" class="form-control" type="text" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <label for="register-mail">Email:</label>
                            <input id="register-mail" name="register-mail" class="form-control" type="text" placeholder="E-Mail" required>
                        </div>
                        <div class="form-group">
                            <label for="register-password">Password:</label>
                            <input id="register-password" name="register-password" class="form-control" type="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label for="register-conf-password">Ponovite password:</label>
                            <input id="register-conf-password" name="register-conf-password" class="form-control" type="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div>
                            <button type="reset" class="btn btn-info" data-dismiss="modal">Odustani</button>
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </div>
                </form>
                <!-- End Register Form -->
            </div>
        </div>
    </div>
    <!-- End  Register Modal -->

    <div ng-controller="RentACarController" ng-cloak ng-init="init();" class="ng-cloak">
        @yield('content')
    </div>


    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-xs-6">
                    <h3>{!! trans('app.work_time') !!}</h3>
                    <p>{!! trans('app.week') !!}</p>
                    <p>{!! trans('app.weekend') !!}</p>
                </div>
                <div class="col-sm-4 col-xs-6">
                    <h3>{!! trans('app.social') !!}</h3>
                    <a href="https://www.facebook.com/" target="_blank"><i class="fa fa-facebook"></i></a>
                    <a href="https://twitter.com/" target="_blank"><i class="fa fa-twitter"></i></a>
                    <a href="https://www.youtube.com/" target="_blank"><i class="fa fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js" ></script>
    <script type="text/javascript" src="{{ URL::asset('../js/bootstrap/transition.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('../js/bootstrap/collapse.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/locale/hr.js"></script>
    <script type="text/javascript" src="{{ URL::asset('../js/bootstrap-datetimepicker.min.js') }}"></script>

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <script type="text/javascript" src="{{ URL::asset('../js/custom.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('../js/ng-file-upload.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('../js/app/app.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('../js/app/controllers/RentACarController.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('../js/app/services/RentACarService.js') }}"></script>


    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

    {{-- <script type="text/javascript" src="{{ URL::asset('../js/app/app.js') }}"></script> --}}


</body>
</html>
