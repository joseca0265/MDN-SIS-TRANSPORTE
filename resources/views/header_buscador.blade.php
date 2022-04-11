<!DOCTYPE html>
<html>

<style>

footer {
  font-size: 15px;
  color: #555;
  background: #eee;
  
  position: fixed;

  display: block;
  width: 100%;
  bottom: 0;
  border-top: 1px solid #ddd;
}
</style>

<style>
.flex-container {
  display: flex;
  flex-wrap: nowrap;
  background-color: DodgerBlue;
}

.flex-container > div {
  background-color: #f1f1f1;
  width: 100px;
  margin: 10px;
  text-align: center;
  line-height: 75px;
  font-size: 30px;
}


#menu ul li {
    background-color:#fff;
	
}

#menu ul {
  list-style:none;
  margin:0;
  padding:0;

}

#menu ul a {
  display:block;
  color:#fff;
  text-decoration:none;
  font-weight:400;
  font-size:12px;
  padding:10px;
  font-family:"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;

  letter-spacing:1px;
  color: #000;
}

#menu ul li {
  position:relative;
  float:left;
  margin:0;
  padding:0;
  font-size:12px;
  
}

#menu ul li:hover {
  background:#f7f7f750;
}

#menu ul ul {
  display:none;
  position:absolute;
  top:100%;
  left:0;
  padding:0;
}

#menu ul ul li {
  float:none;
  width:110px
 
}



#menu ul ul a {
  line-height:105%;
  padding:6px 10px;
  font-weight:500;
  color:#00000070;
  letter-spacing:0px;
  
}

#menu ul li:hover > ul {
  display:block;
}
</style>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" type="image/jpg" href="img/favicon.png"/>
    <title>@yield("titulo")</title>
    <link rel="stylesheet" href="{{url("/css/estilos.css")}}">
    <link rel="stylesheet" href="{{url("/css/all.min.css")}}">
    <!--<link rel="stylesheet" href="{{url("/css/bulma.min.css")}}"/><!--Estilo de conflicto con el css de buscador-->
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
    <nav class="logo navbar is-transparent has-shadow is-spaced" id="menu"
style="box-shadow:none;background:#fff;color:#7f7f7f;font-size:12px;text-align:right;position:fixed">
        <div class="navbar-brand">
            <a class="navbar-item" href="#">
                
            </a>
            
        </div>
        <div id="menuPrincipal" class="navbar-menu">
            

            <div class="navbar-end" style="">
         
					
                       
                           <div style="align-items:center;display:inline-flex;padding:5px;padding-right:20px">
                           
							<ul style="max-height:25px">  <li style="max-height:55px"> Bienvenido&nbsp;{{Auth::user()->Nombres}}&nbsp;&nbsp;<img class="logo"  src='{{url("/img_actualizado/perfil.png") }}'
							style="width:48px;max-height:155px;border-radius:100%;">
							<ul style="padding:0px;box-shadow: 4px 3px 7px 1px #00000050;border:1px solid #00000050">
      <center><li style=" width:165px;"><a href="{{route("mapas")}}"><b>Equipos</b></a></li></center>
      <center><li style=" width:165px;"><a href="#"><b>Requerimientos</b></a></li></center>
      <center><li style=" width:165px;"><a href="#"></a></li></center>
	  <center><li style=" width:165px;"><a href="#"><tr></a></li></center>
	  <center><li style=" width:165px;border-top:1px solid #00000050;height:28px">
	  <a href="{{route("logout")}}" style="height:28px">
	  <i style="font-size:12px;color:#DA3131" class="fa fa-sign-out-alt"> </i><b>&nbsp;Cerrar Sesión</b></a> </li></center>
    </ul>
	  </li>
 
</ul>
							<!--<nav id="menu" style="background-color:transparent;border:1px solid #000;border-radius:25px">
<ul>
 
  <li><img class="logo"  src='{{url("/img_actualizado/perfil.png") }}'
							style="width:48px;max-height:155px;border-radius:100%;">
    <ul>
      <li><a href="#">Enlace 2.1</a></li>
      <li><a href="#">Enlace 2.2</a></li>
      <li><a href="#">Enlace 2.3</a></li>
    </ul>
  </li>
 
</ul>
</nav>-->
						</div>
                            

                 
            </div>
			
        </div>
    </nav>


	
@endif
<section class="section" style="padding-top: 5%;max-height:230px">
    @yield("contenido")
</section>

</body>
<footer>
<div style="height:45px;background:#f2f2f2;font-size:12px;border-bottom:solid 1px #7f7f7f50;">
<br>
<a style="color:#7f7f7f;font-weight:450;line-height:2px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lima, Perú</a>
</div>
<!---->
<div style="background:#f2f2f2;font-size:12px">
<!--<div class="flex-container">
  <div>1</div>
  <div>2</div>
  <div>3</div>  
  <div>4</div>
  <div>5</div>
  <div>6</div>  
  <div>7</div>
  <div>8</div>
  <br>
</div>-->

<table border="0px">

<tr style="background:#f2f2f2">
<td width="220px" style="text-align:center">
<a style="color:#7f7f7f;font-weight:450">Sobre MDN</a>
</td>
<td width="220px" style="text-align:center">
<a style="color:#7f7f7f;font-weight:450">Contáctanos</a>
</td>
<td width="220px" style="text-align:center">
<a style="color:#7f7f7f;font-weight:450">Conviertete en un proveedor</a>
</td>
<td width="220px" style="text-align:center">
<a style="color:#7f7f7f;font-weight:450">Únete a nuestro equipo</a>
</td>
<td width="35%">
</td>

<td width="60px">
<a href="https://www.mdnperu.com"><img class="logo"  style="width:25px;"src='{{url("/img_actualizado/web.png") }}'></a>
</td>
<td width="60px">
<a href="https://www.facebook.com/MDNPERUSAC"><img class="logo" style="width:25px;" src='{{url("/img_actualizado/facebook.png") }}'></a>
</td>
<td width="60px">
<img class="logo"  style="width:25px;" src='{{url("/img_actualizado/whatsapp.png") }}'>
</td>
</tr>
</table>
</div>
<!---->
</footer>

</html>
