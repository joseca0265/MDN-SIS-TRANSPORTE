<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield("titulo")</title>
    <link rel="stylesheet" href="{{url("/css/estilos.css")}}">
    <link rel="stylesheet" href="{{url("/css/all.min.css")}}">
    <link rel="stylesheet" href="{{url("/css/bulma.min.css")}}"/>
    <link rel="stylesheet" href="{{url("/css/estilo-select.css")}}"/>
   
    <script type="text/javascript">
        const URL_BASE = "{{url("/")}}",
            URL_BASE_API = "{{url("/api")}}",
            TOKEN_CSRF = "{{csrf_token()}}";
    </script>
    <script src="{{url("/js/principal.js?q=") . time()}}"></script>
    <script src="{{url("/js/wireframe.js?q=") . time()}}"></script>
    <script src="{{url("/js/utiles.js")}}"></script>
    <script src="{{url("/js/vue.js")}}"></script>
</head>

<body>
@if(Auth::check())
    <nav class="navbar is-transparent has-shadow is-spaced">
        <div class="navbar-brand">
            <a class="navbar-item" href="{{ route("buscador") }}">
                <img class="logo" style="max-height: 85%;max-width: 80%" src="{{url("/img_actualizado/logo.png") }}"
                     alt="Aquí el logotipo de la empresa"
                     width="150" height="20">
            </a>
            <div id="intercambiarMenu" class="navbar-burger burger" data-target="menuPrincipal">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div id="menuPrincipal" class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item" href="{{ route("mapas") }}">
                    <span class="">
                        <i class="fa fa-map" style="color:#41C2E1"></i>
                    </span>&nbsp;Ubicaciones
                </a>
                
                <!--<a class="navbar-item" href="#">
                    <span class="icon has-text-info">
                        <i class="fa fa-chart-line"></i>
                    </span>&nbsp;Reportes
                </a>-->
				<?php if((Auth::user()->rol)== 1){?>
					<a class="navbar-item" href="{{ route("usuarios") }}">
                    <span class="icon has-text-danger">
                        <i class="fa fa-users"></i>
                    </span>&nbsp;Usuarios
                </a>
					<?php }else{
						
					}?>
				
            </div>

            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="field is-grouped">
                        <a class="button"
                           href="{{route("logout")}}">
                            <strong>Salir</strong>&nbsp;({{Auth::user()->nombre}})
						
                            <span class="icon has-text-danger">
                                <i class="fa fa-sign-out-alt"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
@endif
<section class="section" style="padding-top: 0.3rem;font-size:13px">
    @yield("contenido")
</section>
</body>

</html>
