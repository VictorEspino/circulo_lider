<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script src="https://kit.fontawesome.com/a692f93986.js" crossorigin="anonymous"></script>

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <style>
            /* The side navigation menu */
            .sidenav {
            height: 100%; /* 100% Full-height */
            width: 0; /* 0 width - change this with JavaScript */
            position: fixed; /* Stay in place */
            /*z-index: 1; /* Stay on top */
            /*top: 0; /* Stay at the top */
            /*left: 0;*/
            font-size: 14px;
            background-color:#343d49; /* Black*/
            overflow-x: hidden; /* Disable horizontal scroll */
            overflow-y: scroll;
            padding-top: 25px; /* Place content 60px from the top */
            transition: 0.2s; /* 0.5 second transition effect to slide in the sidenav */
            }

            /* The navigation menu links */
            .OLD_sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 18px;
            color: #919191;
            display: block;
            transition: 0.3s;
            }

            /* When you mouse over the navigation links, change their color */
            /*.sidenav a:hover {
            color: #4C98E1;
            }
            */
            /* Position and style the close button (top right corner) */
            .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 25px;
            margin-left: 50px;
            }

            /* Style page content - use this if you want to push the page content to the right when you open the side navigation */
            #main {
            transition: margin-left .5s;
            padding: 20px;
            }

            /* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
            @media screen and (max-height: 450px) {
            .sidenav {padding-top: 15px;}
            .sidenav a {font-size: 14px;}
            }

            </style>


    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
            <!--
            <header class="bg-blue-900">
                    <div class="max-w-7xl mx-auto py-6 px-2 sm:px-2 lg:px-4">
                        <h2 class="font-semibold text-l text-gray-100 leading-tight bg-blue-900">
    
                                <i class="fas fa-bars pr-2 text-white" onclick="sidebarToggle()"></i>
    
                                {{ $header }}

                        </h2>
                    </div>
                </header>
            -->

            <header class="bg-gray-100">
                <div id="mySidenav" class="sidenav flex flex-col">
                    <div class="flex flex-col overflow-y-auto">
                        <div><a href="javascript:void(0)" class="closebtn text-red-400" onclick="closeNav()">&times;</a></div>
                        @if (Auth::user()->perfil==1)
                        <div class="px-3 font-semibold flex flex-col">
                            <div class="text-slate-200">
                                <i class="fas fa-tasks"></i>
                                Plantilla
                            </div>
                            <div class="flex flex-col" id="distribuidores">                                
                                <div class="pl-5 pt-2">
                                    <a href="{{route('usuarios')}}" class="text-slate-200 hover:text-slate-400">
                                        <span class="text-amber-300"><i class="fas fa-users"></i></span>
                                        Administracion plantilla
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="px-3 font-semibold flex flex-col pt-3">
                            <div class="text-slate-200 font-bold">
                                <i class="fas fa-tasks"></i>
                                Ventas
                            </div>
                            <div class="flex flex-col" id="distribuidores">
                                
                                <div class="pl-5 pt-2">
                                    <a href="{{route('ventas_nueva')}}" class="text-slate-200 hover:text-slate-400">
                                        <span class="text-orange-500"><i class="fas fa-file-signature"></i></span>
                                        Registrar Venta
                                    </a>
                                </div>   
                                
                                <div class="pl-5 pt-2">
                                    <a href="{{route('base_ventas')}}" class="text-slate-200 hover:text-slate-400">
                                        <span class="text-amber-300"><i class="fas fa-database"></i></span>
                                        Base de Ventas
                                    </a>
                                </div>
                                <div class="pl-5 pt-2">
                                    <a href="{{route('carga_cis_pospago')}}" class="text-slate-200 hover:text-slate-400">
                                        <span class="text-amber-300"><i class="fas fa-upload"></i></span>
                                        Carga CIS Pospago
                                    </a>
                                </div>
                                <div class="pl-5 pt-2">
                                    <a href="{{route('carga_cis_renovacion')}}" class="text-slate-200 hover:text-slate-400">
                                        <span class="text-amber-300"><i class="fas fa-upload"></i></span>
                                        Carga CIS Renovacion
                                    </a>
                                </div>  
                            </div>
                        </div>
                        @if (Auth::user()->perfil==1)
                        <div class="px-3 font-semibold flex flex-col pt-3">
                            <div class="text-slate-200 font-bold">
                                <i class="fas fa-tasks"></i>
                                Comisiones
                            </div>
                            <div class="flex flex-col" id="distribuidores">
                                
                                <div class="pl-5 pt-2">
                                    <a href="{{route('nuevo_calculo')}}" class="text-slate-200 hover:text-slate-400">
                                        <span class="text-orange-500"><i class="fas fa-file-signature"></i></span>
                                        Nuevo Calculo
                                    </a>
                                </div>     
                                <div class="pl-5 pt-2">
                                    <a href="{{route('cuotas_gerentes')}}" class="text-slate-200 hover:text-slate-400">
                                        <span class="text-amber-300"><i class="fas fa-database"></i></span>
                                        Cuotas Tienda
                                    </a>
                                </div>         
                                <div class="pl-5 pt-2">
                                    <a href="{{route('seguimiento_calculo')}}" class="text-slate-200 hover:text-slate-400">
                                        <span class="text-amber-300"><i class="fas fa-database"></i></span>
                                        Calculos de comisiones
                                    </a>
                                </div>                          
                            </div>
                        </div>
                        @endif
                        @if(Auth::user()->perfil==2)
                        <div class="px-3 font-semibold flex flex-col pt-3">
                            <div class="text-slate-200 font-bold">
                                <i class="fas fa-tasks"></i>
                                AT&T
                            </div>
                            <div class="flex flex-col" id="distribuidores">
                                
                                <div class="pl-5 pt-2">
                                    <a href="{{route('carga_cis')}}" class="text-slate-200 hover:text-slate-400">
                                        <span class="text-orange-500"><i class="fas fa-file-signature"></i></span>
                                        Carga de SIS
                                    </a>
                                </div>  
                                <div class="pl-5 pt-2">
                                    <a href="{{route('periodo_nuevo')}}" class="text-slate-200 hover:text-slate-400">
                                        <span class="text-amber-300"><i class="fas fa-database"></i></span>
                                        Nuevo Periodo
                                    </a>
                                </div>                                 
                            </div>
                        </div>   
                        @endif                                                                                       
                        <div class="px-3 text-[#343d49] flex flex-col">.
                        </div>
                        <div class="px-3 text-[#343d49] flex flex-col">.
                        </div>
                        <div class="px-3 text-[#343d49] flex flex-col">.
                        </div>
                        <div class="px-3 text-[#343d49] flex flex-col">.
                        </div>
                        <div class="px-3 text-[#343d49] flex flex-col">.
                        </div>
                        <div class="px-3 text-[#343d49] flex flex-col">.
                        </div>
                        <div class="px-3 text-[#343d49] flex flex-col">.
                        </div>
                        <div class="px-3 text-[#343d49] flex flex-col">.
                        </div>
                    </div> 
                </div>
                <div class="max-w-7xl mx-auto py-4 px-2 sm:px-2 px-4 flex space-x-5 flex-row">
                    <div class="flex">
                        <span onclick="openNav()" class="text-gray-700 font-bold text-2xl"><i class="fas fa-bars"></i></span>
                    </div>
                    <div class="flex items-center"> 
                        <h2 class="font-semibold leading-tight text-gray-700 text-lg">    
                            {{ $header }} 
                        </h2>
                    </div>
                </div>
                
            </header>

            @endif

            <!-- Page Content -->
            <main>
                <div class="flex -mb-4">
                    <!--
                    <div id="sidebar" class="bg-gray-300 text-gray-700 h-screen flex w-52 flex-shrink-0 border-r border-side-nav md:block lg:block">
                        <div>
                            <ul class="list-reset flex flex-col">
                                <li class=" w-full h-full py-3 px-2 border-b border-light-border bg-blue-200">
                                        Configuracion
                                </li> 
                                <li class=" w-full h-full py-3 px-2 border-b border-light-border {{request()->routeIs('dashboard')?'bg-gray-100':''}}">
                                    <a href="{{ route('dashboard') }}" 
                                        class="font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                                        <i class="fas fa-users-cog float-left mx-2"></i>
                                        Grupos atencion
                                        <span><i class="fas fa-angle-right float-right"></i></span>
                                    </a>
                                </li>                                 
                            </ul>                
                        </div>

                    </div>
                    -->
                    <div class="w-full">
                            {{ $slot }}
                    </div>
                </div>
            </main>
        </div>

        @stack('modals')

        @livewireScripts
        <script>
            var sidebar = document.getElementById('sidebar');

            function sidebarToggle() {
                if(sidebar.style.display!="none") {
                    sidebar.style.display="none";
                }
                else{
                    sidebar.style.display="block";
                }
            }    
        </script>
        <script>
        /* Set the width of the side navigation to 250px */
function openNav() {
  document.getElementById("mySidenav").style.width = "220px";
}

/* Set the width of the side navigation to 0 */
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>
<script>
            Livewire.on('alert_ok',function(message)
            {
                Swal.fire(
                    'OK!',
                    message,
                    'success'
                )

            });
        </script>
    </body>
</html>
