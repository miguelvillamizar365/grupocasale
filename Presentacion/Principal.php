<?php

class Principal
{
    function PaginaPrincipal()
    {
        ?>
            <!DOCTYPE html>
            
            <head>
              <!-- Required meta tags -->
              <!-- <meta charset="utf-8" /> -->
              
              <meta charset="iso-8859-1" />
              <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
              <title>Grupo Casale</title>
              <link rel="stylesheet" href="../node_modules/font-awesome/css/font-awesome.min.css" />
              <link rel="stylesheet" href="../node_modules/perfect-scrollbar/dist/css/perfect-scrollbar.min.css" />
              <link rel="stylesheet" href="../css/style.css" />              
              <link rel="stylesheet" type="text/css" href="../datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css"/>
              <link rel="stylesheet" type="text/css" href="../datatables/Buttons-1.4.2/css/buttons.bootstrap4.min.css"/>
              
              <link rel="shortcut icon" href="../images/Tracto.png" />
              
            </head>
            
            <body>
                
            <div class="row1">
              <div class="container-scroller">
                <div class="container-fluid">
                  <div class="row">
                    <div class="content-wrapper full-page-wrapper d-flex align-items-center">
                      <div class="card col-lg-4 offset-lg-4">
                        <div class="card-block">
                          <h3 class="card-title text-primary text-left mb-5 mt-4">Login</h3>
                          <form id="login"> 
                            <input type="hidden" id="desea" name="desea" value="" />
                            <div class="form-group">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input id="TB_correo" name="TB_correo" type="text" class="form-control p_input" placeholder="Correo electrónico" />
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input id="TB_clave" name="TB_clave" type="password" class="form-control p_input" placeholder="Clave" />
                              </div>
                            </div>
                            <div class="text-center">
                              <input type="button" onclick="registrarUsuario()" class="btn btn-secondary" value="Registrarse" />
                              <input type="button" onclick="IniciaSesion()" class="btn btn-primary" value="Login" />
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="row2">
            
            </div>
                            
            <div class="row3">
            
            </div>
              
            <div class="modal fade" id="mensajeEmergente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Mensaje de aplicación</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body">
                    <div id="mensaje">
                    
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal fade" id="loadAjax" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                
                  <div class="modal-body">                    
                    <div class="bg-white text-center navbar-brand-wrapper">
                        <a class="navbar-brand brand-logo" href="#"><img src="../images/logo_star_black.png" /></a>
                        <a class="navbar-brand brand-logo-mini" href="#"><img src="../images/logo_star_mini.jpg" alt=""></a>
                    </div>                    
                  </div>
                                   
                </div>
              </div>
            </div>
            
            <div class="modal fade" id="mensajeEmergenteRedirect" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Mensaje de aplicación</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body">
                    <div id="mensaje">
                    
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button onclick="redirectLogin()" type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                  </div>
                </div>
              </div>
            </div>   
            
            <script src="../node_modules/jquery/dist/jquery.min.js"></script>
            <script src="../node_modules/tether/dist/js/tether.min.js"></script>
            <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>              
            <script src="../js/jsSitio/principal.js"></script>
            
            </body>            
            </html>
        <?php
    }
    
    
    function cargaContenido()
    {
        ?>        
        <div class="container-scroller">
            <!--Navbar-->
            <nav class="navbar bg-primary-gradient col-lg-12 col-12 p-0 fixed-top navbar-inverse d-flex flex-row">
                <div class="bg-white text-center navbar-brand-wrapper">
                    <a class="navbar-brand brand-logo" href="#"><img src="../images/logo_star_black.png" /></a>
                    <a class="navbar-brand brand-logo-mini" href="#"><img src="../images/logo_star_mini.jpg" alt=""></a>
                </div>
                <div class="navbar-menu-wrapper d-flex align-items-center">
                    <button class="navbar-toggler navbar-toggler hidden-md-down align-self-center mr-3" type="button" data-toggle="minimize">
                      <span class="navbar-toggler-icon"></span>
                    </button>
                    <form class="form-inline mt-2 mt-md-0 hidden-md-down">
                        <input class="form-control mr-sm-2 search" type="text" placeholder="Search">
                    </form>
                    <ul class="navbar-nav ml-lg-auto d-flex align-items-center flex-row">
                        <!--<li class="nav-item">
                            <a class="nav-link profile-pic" href="#"><img class="rounded-circle" src="../images/face.jpg" alt=""></a>
                        </li>-->
                        <li class="nav-item">   
                            <form id="login"> 
                                <input type="hidden" id="desea" name="desea" value="" />                                                       
                                <a class="nav-link" onclick="CerrarSesion()" href="#">
                                    Cerrar Sesión
                                    <i class="fa fa-window-close"></i>
                                </a>
                            </form>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right hidden-lg-up align-self-center" type="button" data-toggle="offcanvas">
                      <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>
            <!--End navbar-->
            <div class="container-fluid">
                <div class="row row-offcanvas row-offcanvas-right">
                    <nav class="bg-white sidebar sidebar-fixed sidebar-offcanvas" id="sidebar">
                    <!-- <div class="user-info"> -->
                        <!-- <img src="../images/face.jpg" alt=""> -->
                        <!-- <p class="name">Richard V.Welsh</p> -->
                        <!-- <p class="designation">Manager</p> -->
                        <!-- <span class="online"></span> -->
                    <!-- </div> -->
                        <ul class="nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">
                                    <!-- <i class="fa fa-dashboard"></i> -->
                                    <img src="../images/icons/1.png" alt="">
                                    <span class="menu-title">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="loadReferencias()">
                                    <img src="../images/icons/2.png" alt="">
                                    <span class="menu-title">Referencias</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/widgets.html">
                                    <img src="../images/icons/2.png" alt="">
                                    <span class="menu-title">Facturas</span>
                                </a>
                            </li>
    						<li class="nav-item">
                                <a class="nav-link" href="pages/widgets.html">
                                    <img src="../images/icons/2.png" alt="">
                                    <span class="menu-title">Autoriza Referencia</span>
                                </a>
                            </li>
    						<li class="nav-item">
                                <a class="nav-link" href="pages/widgets.html">
                                    <img src="../images/icons/2.png" alt="">
                                    <span class="menu-title">Orden Trabajo</span>
                                </a>
                            </li>
    						<li class="nav-item">
                                <a class="nav-link" href="pages/widgets.html">
                                    <img src="../images/icons/2.png" alt="">
                                    <span class="menu-title">Orden Salida</span>
                                </a>
                            </li>
    						<li class="nav-item">
                                <a class="nav-link" href="pages/widgets.html">
                                    <img src="../images/icons/2.png" alt="">
                                    <span class="menu-title">Alistamiento <br /> Preoperacional</span>
                                </a>
                            </li>
    						<li class="nav-item">
                                <a class="nav-link" href="pages/widgets.html">
                                    <img src="../images/icons/2.png" alt="">
                                    <span class="menu-title">Control Combustible</span>
                                </a>
                            </li>
    						<li class="nav-item">
                                <a class="nav-link" href="pages/widgets.html">
                                    <img src="../images/icons/2.png" alt="">
                                    <span class="menu-title">Alertas</span>
                                </a>
                            </li>
    						<li class="nav-item">
                                <a class="nav-link" href="pages/widgets.html">
                                    <img src="../images/icons/2.png" alt="">
                                    <span class="menu-title">Widgets</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/forms.html">
                                    <!-- <i class="fa fa-wpforms"></i> -->
                                    <img src="../images/icons/3.png" alt="">
                                    <span class="menu-title">Forms</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/buttons.html">
                                    <!-- <i class="fa fa-calculator"></i> -->
                                    <img src="../images/icons/4.png" alt="">
                                    <span class="menu-title">Buttons</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/tables.html">
                                    <!-- <i class="fa fa-table"></i> -->
                                    <img src="../images/icons/5.png" alt="">
                                    <span class="menu-title">Tables</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/charts.html">
                                    <!-- <i class="fa fa-bar-chart"></i> -->
                                    <img src="../images/icons/6.png" alt="">
                                    <span class="menu-title">Charts</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/icons.html">
                                    <!-- <i class="fa fa-font"></i> -->
                                    <img src="../images/icons/7.png" alt="">
                                    <span class="menu-title">Icons</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/typography.html">
                                    <!-- <i class="fa fa-bold"></i> -->
                                    <img src="../images/icons/8.png" alt="">
                                    <span class="menu-title">Typography</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                    <!-- <i class="fa fa-address-book"></i> -->
                                    <img src="../images/icons/9.png" alt="">
                                    <span class="menu-title">Sample Pages<i class="fa fa-sort-down"></i></span>
                                </a>
                                <div class="collapse" id="collapseExample">
                                    <ul class="nav flex-column sub-menu">
                                        <li class="nav-item">
                                            <a class="nav-link" href="samples/blank_page.html">
                                          Blank Page
                                        </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="samples/register.html">
                                          Register
                                        </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="samples/login.html">
                                          Login
                                        </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="samples/not-found.html">
                                          404
                                        </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="samples/error.html">
                                          500
                                        </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <!-- <i class="fa fa-bold"></i> -->
                                    <img src="../images/icons/10.png" alt="">
                                    <span class="menu-title">Settings</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- SIDEBAR ENDS -->
                    
                    <div class="dashboard">                    
                        <div class="content-wrapper">
                            <h3 class="text-primary mb-4">Dashboard</h3>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-block">
                                            <h4 class="card-title font-weight-normal text-success">7874</h4>
                                            <p class="card-text">Visitors</p>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0"
                                                    aria-valuemax="100">75%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-block">
                                            <h4 class="card-title font-weight-normal text-info">75632</h4>
                                            <p class="card-text ">Sales</p>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0"
                                                    aria-valuemax="100">40%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-block">
                                            <h4 class="card-title font-weight-normal text-warning">2156</h4>
                                            <p class="card-text">Orders</p>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                                    aria-valuemax="100">25%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-block">
                                            <h4 class="card-title font-weight-normal text-danger">$ 89623</h4>
                                            <p class="card-text">Revenue</p>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0"
                                                    aria-valuemax="100">65%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6  mb-4">
                                    <div class="card">
                                        <div class="card-block">
                                            <h5 class="card-title mb-4">Sales</h5>
                                            <canvas id="lineChart" style="height:250px"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6  mb-4">
                                    <div class="card">
                                        <div class="card-block">
                                            <h5 class="card-title mb-4">Customer Satisfaction</h5>
                                            <canvas id="doughnutChart" style="height:250px"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <div class="card">
                                        <div class="card-block">
                                            <h5 class="card-title mb-4">Payments</h5>
                                            <table class="table">
                                                <thead class="text-primary">
                                                    <tr>
                                                        <th><i class="fa fa-user ml-2"></i></th>
                                                        <th>User</th>
                                                        <th>Item</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th><img src="../images/profile.jpg" alt="profile" class="rounded-circle" width="40"
                                                                height="40" /></th>
                                                        <td>Larry</td>
                                                        <td>Acer</td>
                                                        <td><span class="badge badge-success">Success</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th><img src="../images/profile.jpg" alt="profile" class="rounded-circle" width="40"
                                                                height="40" /></th>
                                                        <td>Larry</td>
                                                        <td>Acer</td>
                                                        <td><span class="badge badge-danger">Failed</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th><img src="../images/profile.jpg" alt="profile" class="rounded-circle" width="40"
                                                                height="40" /></th>
                                                        <td>Larry</td>
                                                        <td>Acer</td>
                                                        <td><span class="badge badge-primary">Processing</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th><img src="../images/profile.jpg" alt="profile" class="rounded-circle" width="40"
                                                                height="40" /></th>
                                                        <td>Larry</td>
                                                        <td>Acer</td>
                                                        <td><span class="badge badge-success">Success</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th><img src="../images/profile.jpg" alt="profile" class="rounded-circle" width="40"
                                                                height="40" /></th>
                                                        <td>Larry</td>
                                                        <td>Acer</td>
                                                        <td><span class="badge badge-danger">Failed</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card">
                                        <div class="card-block">
                                            <h5 class="card-title"></h5>
                                            <div id="map" style="min-height:415px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="footer">
                        <div class="container-fluid clearfix">
                          <span class="float-right">
                              <a href="#">Grupo Casale</a> &copy; 2017
                          </span>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
        <?php
    }         
    
    function limpiaLogin(){
        
        ?>        
          
        <?php
    }
    
    function cargaLogin()
    {
        ?>
         <div class="container-scroller">
            <div class="container-fluid">
              <div class="row">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center">
                  <div class="card col-lg-4 offset-lg-4">
                    <div class="card-block">
                      <h3 class="card-title text-primary text-left mb-5 mt-4">Login</h3>
                      <form id="login"> 
                        <input type="hidden" id="desea" name="desea" value="" />
                        <div class="form-group">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input id="TB_correo" name="TB_correo" type="text" class="form-control p_input" placeholder="Correo electrónico" />
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input id="TB_clave" name="TB_clave" type="password" class="form-control p_input" placeholder="Clave" />
                          </div>
                        </div>
                        <div class="text-center">
                          <input type="button" onclick="registrarUsuario()" class="btn btn-secondary" value="Registrarse" />
                          <input type="button" onclick="IniciaSesion()" class="btn btn-primary" value="Login" />
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php
    }
    
    function registroUsuario()
    {
        ?>        
         <div class="container-scroller">
            <div class="container-fluid">
              <div class="row">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center">
                  <div class="card col-lg-8 offset-lg-2">
                    <div class="card-block">
                      <h3 class="card-title text-primary text-left mb-5 mt-4">Registro Usuario</h3>
                      <form id="registro">
                        
                        <input type="hidden" id="desea" name="desea" value="" />                                              
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input id="TB_nombre" name="TB_nombre" type="text" class="form-control p_input" placeholder="Nombre" />
                                  </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input id="TB_apellido" name="TB_apellido" type="text" class="form-control p_input" placeholder="Apellido" />
                                  </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-drivers-license-o"></i></span>
                                    <input id="TB_documento" name="TB_documento" type="text" class="form-control p_input" placeholder="Número de Documento" />
                                  </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                    <input id="TB_telefono" name="TB_telefono" type="text" class="form-control p_input" placeholder="Teléfono" />
                                  </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">                                
                                <div class="form-group">
                                    
                                  <label for="id_rol">Rol</label>            
                                  <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-users"></i></span>                                    
                                        <select style="width: 400px!important;" id="id_rol" name="id_rol" class="">                                   
                                        </select>
                                  </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                    <input id="TB_direccion" name="TB_direccion" type="text" class="form-control p_input" placeholder="Dirección" />
                                  </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope-open"></i></span>
                                    <input id="TB_email" name="TB_email" type="text" class="form-control p_input" placeholder="Email" />
                                  </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" id="TB_clave" name="TB_clave" type="text" class="form-control p_input" placeholder="Clave" />
                                  </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" id="TB_confirmaclave" name="TB_confirmaclave" type="text" class="form-control p_input" placeholder="Confirmar Clave" />
                                  </div>
                                </div>
                            </div>
                        </div>
                                                
                        <div class="text-center">
                            <button type="button" onclick="atrasRegistro()" class="btn btn-secondary">Atrás</button>
                            <button type="button" onclick="guardarUsuario()" class="btn btn-primary">Guardar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>       
          
          <script>
          
           $("#TB_documento").keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                     // Allow: Ctrl+A, Command+A
                    (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
                     // Allow: home, end, left, right, down, up
                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                         // let it happen, don't do anything
                         return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
            
             $("#TB_telefono").keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                     // Allow: Ctrl+A, Command+A
                    (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
                     // Allow: home, end, left, right, down, up
                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                         // let it happen, don't do anything
                         return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
          </script>  
        <?php
    }
}

?>