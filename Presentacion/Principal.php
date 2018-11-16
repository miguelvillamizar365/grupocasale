<?php

/**
 * pagina principal presentación
 * @author miguel villamizar
 * @copyright 2017/11/13
 */


class Principal
{
    function PaginaPrincipal()
    {
		header('Content-Type:text/html; charset=iso-8859-1');
        ?>
            <!DOCTYPE html>
            
            <head>
              <!-- Required meta tags -->
			  
              <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
              <title>Grupo Casale</title>
			  <link rel="stylesheet" href="../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
			  <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
			  <link rel="stylesheet" href="../vendors/css/vendor.bundle.addons.css">			  
			  
			  
			  <link rel="stylesheet" href="../vendors/icheck/skins/all.css">
			  <link rel="stylesheet" href="../css/style.css" />
			  <link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css" />	
			  
              
			  <!--<link rel="stylesheet" type="text/css" href="../datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css"/>
              <link rel="stylesheet" type="text/css" href="../datatables/Buttons-1.4.2/css/buttons.bootstrap4.min.css"/>
			  <link rel="stylesheet" type="text/css" href="../datatables/DataTables-1.10.16/css/fixedHeader.bootstrap.css"/>
			  <link rel="stylesheet" type="text/css" href="../datatables/DataTables-1.10.16/css/responsive.bootstrap.css"/>
			  -->
			  
			  <link rel="stylesheet" href="../selectize.js-master/dist/css/selectize.bootstrap3.css" />              
              <link href="../selectize.js-master/src/less/selectize.less" />     
	
			  
              <link rel="shortcut icon" href="../images/Tracto.png" />
			  
            </head>
            
            <body>					
				<div class="row1">
					<div class="container-scroller">
						<div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
						  <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
							<div class="row w-100">
							  <div class="col-lg-4 mx-auto">
								<div class="auto-form-wrapper">									  
									  <form id="login"> 
										<input type="hidden" id="desea" name="desea" value="" />
										<div class="form-group">
										  <div class="input-group">
											<input id="TB_correo" name="TB_correo" type="text" class="form-control p_input" placeholder="Correo electrónico" />
											<div class="input-group-append">
												<span class="input-group-text">
													<i class="mdi mdi-check-circle-outline"></i>
												</span>
											</div>
										  </div>
										</div>
										<div class="form-group">
										  <div class="input-group">
											<input id="TB_clave" name="TB_clave" type="password" class="form-control p_input" placeholder="Clave" />
											<div class="input-group-append">
												<span class="input-group-text">
													<i class="mdi mdi-check-circle-outline"></i>
												</span>
											</div>
										  </div>
										</div>
							
										<div class="text-center">
										  <input type="button" onclick="registrarUsuario()" class="btn btn-secondary" value="Registrarse" />
										  <input type="button" onclick="IniciaSesion()" class="btn btn-primary" value="Iniciar Sesión" />
										</div>
									  </form>
								</div>
								 <p class="footer-text text-center">copyright © 2018 Bootstrapdash. All rights reserved.</p>
							  </div>
							</div>
						  </div>
						  <!-- content-wrapper ends -->
						</div>
							<!-- page-body-wrapper ends -->
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

				<!-- container-scroller -->
				<!-- plugins:js -->
				<script src="../vendors/js/vendor.bundle.base.js"></script>
				<script src="../vendors/js/vendor.bundle.addons.js"></script>
				<!-- endinject -->
				<!-- inject:js -->
				<script src="../js/off-canvas.js"></script>
				<script src="../js/misc.js"></script>
				<!-- endinject -->
				<script src="../selectize.js-master/dist/js/standalone/selectize.js"></script>
				<script src="../selectize.js-master/examples/js/index.js"></script>
				<script src="../js/jquery.blockUI.js"></script>
            </body>            
            
        <?php
    }
    
    function mensajeRedirect($mensaje, $url)
    {
		header('Content-Type:text/html; charset=iso-8859-1');
        ?>        
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
                <button onclick="<?php echo $url?>" type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
              </div>
            </div>
          </div>
        </div>   
        <script>
        
             $("#mensajeEmergenteRedirect")
            .find('.modal-body > div[id="mensaje"]')
            .html(<?php echo $mensaje?>);
            	
    		$("#mensajeEmergenteRedirect").modal("show");
            
        </script>
        <?php
    }
    
	function dashboard()
	{
		?>             
		
			<h3 class="text-primary mb-4">Dashboard</h3>
			<div class="row">
				<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 mb-4">
					<div class="card">
						<div class="card-body">
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
						<div class="card-body">
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
						<div class="card-body">
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
						<div class="card-body">
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
						<div class="card-body">
							<h5 class="card-title mb-4">Sales</h5>
							<canvas id="lineChart" style="height:250px"></canvas>
						</div>
					</div>
				</div>
				<div class="col-lg-6  mb-4">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title mb-4">Customer Satisfaction</h5>
							<canvas id="doughnutChart" style="height:250px"></canvas>
						</div>
					</div>
				</div>
			</div>
			
          <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Area chart</h4>
                  <canvas id="areaChart" style="height:250px"></canvas>
                </div>
              </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Bar chart</h4>
                  <canvas id="barChart" style="height:230px"></canvas>
                </div>
              </div>
            </div>
          </div>
			<div class="row">
				<div class="col-lg-6 mb-4">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title mb-4">Payments</h5>
							<table class="display table table-striped table-bordered nowrap">
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
						<div class="card-body">
							<h5 class="card-title"></h5>
							<div id="map" style="min-height:415px;"></div>
						</div>
					</div>
				</div>
			</div>
			
			 <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">Advanced Table</h5>
                                    <div class="table-responsive">
                                        <table class="table center-aligned-table">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th>No</th>
                                                    <th>Invoice Subject</th>
                                                    <th>Client</th>
                                                    <th>VatNo.</th>
                                                    <th>Created</th>
                                                    <th>Status</th>
                                                    <th>Price</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="">
                                                    <td>034</td>
                                                    <td>Designs</td>
                                                    <td>Client</td>
                                                    <td>53275531</td>
                                                    <td>12 May 2017</td>
                                                    <td><label class="badge badge-success">Approved</label></td>
                                                    <td>$349</td>
                                                    <td><a href="#" class="btn btn-primary btn-sm">Manage</a></td>
                                                    <td><a href="#" class="btn btn-danger btn-sm">Remove</a></td> 
                                                </tr>
                                                <tr class="">
                                                    <td>035</td>
                                                    <td>Designs</td>
                                                    <td>Client</td>
                                                    <td>53275531</td>
                                                    <td>12 May 2017</td>
                                                    <td><label class="badge badge-warning">Approved</label></td>
                                                    <td>$349</td>
                                                    <td><a href="#" class="btn btn-primary btn-sm">Manage</a></td>
                                                    <td><a href="#" class="btn btn-danger btn-sm">Remove</a></td> 
                                                </tr>
                                                <tr class="">
                                                    <td>036</td>
                                                    <td>Designs</td>
                                                    <td>Client</td>
                                                    <td>53275531</td>
                                                    <td>12 May 2017</td>
                                                    <td><label class="badge badge-success">Approved</label></td>
                                                    <td>$349</td>
                                                    <td><a href="#" class="btn btn-primary btn-sm">Manage</a></td>
                                                    <td><a href="#" class="btn btn-danger btn-sm">Remove</a></td> 
                                                </tr>
                                                <tr class="">
                                                    <td>037</td>
                                                    <td>Designs</td>
                                                    <td>Client</td>
                                                    <td>53275531</td>
                                                    <td>12 May 2017</td>
                                                    <td><label class="badge badge-danger">Rejected</label></td>
                                                    <td>$349</td>
                                                    <td><a href="#" class="btn btn-primary btn-sm">Manage</a></td>
                                                    <td><a href="#" class="btn btn-danger btn-sm">Remove</a></td> 
                                                </tr>
                                                <tr class="">
                                                    <td>038</td>
                                                    <td>Designs</td>
                                                    <td>Client</td>
                                                    <td>53275531</td>
                                                    <td>12 May 2017</td>
                                                    <td><label class="badge badge-success">Approved</label></td>
                                                    <td>$349</td>
                                                    <td><a href="#" class="btn btn-primary btn-sm">Manage</a></td>
                                                    <td><a href="#" class="btn btn-danger btn-sm">Remove</a></td> 
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					
					<div class="col-md-6 grid-margin stretch-card">
					  <div class="card">
						<div class="card-body">
						  <h4 class="card-title">Checkbox Controls</h4>
						  <p class="card-description">Checkbox and radio controls</p>
						  <form class="forms-sample">
							<div class="row">
							  <div class="col-md-6">
								<div class="form-group">
								  <div class="form-check">
									<label class="form-check-label">
									  <input type="checkbox" class="form-check-input"> Default
									</label>
								  </div>
								  <div class="form-check">
									<label class="form-check-label">
									  <input type="checkbox" class="form-check-input" checked> Checked
									</label>
								  </div>
								  <div class="form-check">
									<label class="form-check-label">
									  <input type="checkbox" class="form-check-input" disabled> Disabled
									</label>
								  </div>
								  <div class="form-check">
									<label class="form-check-label">
									  <input type="checkbox" class="form-check-input" disabled checked> Disabled checked
									</label>
								  </div>
								</div>
							  </div>
							  <div class="col-md-6">
								<div class="form-group">
								  <div class="form-radio">
									<label class="form-check-label">
									  <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios1" value="" checked> Option one
									</label>
								  </div>
								  <div class="form-radio">
									<label class="form-check-label">
									  <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios2" value="option2"> Option two
									</label>
								  </div>
								</div>
								<div class="form-group">
								  <div class="form-radio disabled">
									<label class="form-check-label">
									  <input type="radio" class="form-check-input" name="optionsRadios2" id="optionsRadios3" value="option3" disabled> Option three is disabled
									</label>
								  </div>
								  <div class="form-radio disabled">
									<label class="form-check-label">
									  <input type="radio" class="form-check-input" name="optionsRadio2" id="optionsRadios4" value="option4" disabled checked> Option four is selected and disabled
									</label>
								  </div>
								</div>
							  </div>
							</div>
						  </form>
						</div>
					  </div>
					</div>
					<div class="col-md-6 grid-margin stretch-card">
					  <div class="card">
						<div class="card-body">
						  <h4 class="card-title">Checkbox Flat Controls</h4>
						  <p class="card-description">Checkbox and radio controls with flat design</p>
						  <form class="forms-sample">
							<div class="row">
							  <div class="col-md-6">
								<div class="form-group">
								  <div class="form-check form-check-flat">
									<label class="form-check-label">
									  <input type="checkbox" class="form-check-input"> Default
									</label>
								  </div>
								  
								  <div class="form-check form-check-flat">
									<label class="form-check-label">
									  <input type="checkbox" class="form-check-input" checked> Checked
									</label>
								  </div>
								  <div class="form-check form-check-flat">
									<label class="form-check-label">
									  <input type="checkbox" class="form-check-input" disabled> Disabled
									</label>
								  </div>
								  <div class="form-check form-check-flat">
									<label class="form-check-label">
									  <input type="checkbox" class="form-check-input" disabled checked> Disabled checked
									</label>
								  </div>
								</div>
							  </div>
							  <div class="col-md-6">
								<div class="form-group">
								  <div class="form-radio form-radio-flat">
									<label class="form-check-label">
									  <input type="radio" class="form-check-input" name="flatRadios1" id="flatRadios1" value="" checked> Option one
									</label>
								  </div>
								  <div class="form-radio form-radio-flat">
									<label class="form-check-label">
									  <input type="radio" class="form-check-input" name="flatRadios2" id="flatRadios2" value="option2"> Option two
									</label>
								  </div>
								</div>
								<div class="form-group">
								  <div class="form-radio form-radio-flat disabled">
									<label class="form-check-label">
									  <input type="radio" class="form-check-input" name="flatRadios3" id="flatRadios3" value="option3" disabled> Option three is disabled
									</label>
								  </div>
								  <div class="form-radio form-radio-flat disabled">
									<label class="form-check-label">
									  <input type="radio" class="form-check-input" name="flatRadios4" id="flatRadios4" value="option4" disabled checked> Option four is selected and disabled
									</label>
								  </div>
								</div>
							  </div>
							</div>
						  </form>
						</div>
					  </div>
					</div>
		<?php
	}
	
    
    function cargaContenido($MenuLista)
    {		
        ?>      
	 
		<div class="modal fade" id="mensajeConfirmaSession" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Mensaje de aplicación</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  </div>
			  <div class="modal-body">
				
				<div id="mensajeConfSesion">
				
				</div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				<button onclick="CerrarSesion()" type="button" class="btn btn-primary" >Aceptar</button>
			  </div>
			</div>
		  </div>
		</div> 		
        <div class="container-scroller">
					
			<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
			  <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
				<a class="navbar-brand brand-logo" href="index.html">
				  <img src="../images/logo_centro2.jpg" alt="logo" />
				</a>
				<a class="navbar-brand brand-logo-mini" href="index.html">
				  <img src="../images/logo-mini.svg" alt="logo" />
				</a>
			  </div>
			  <div class="navbar-menu-wrapper d-flex align-items-center">
				<!--<ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
				  <li class="nav-item">
					<a href="#" class="nav-link">Schedule
					  <span class="badge badge-primary ml-1">New</span>
					</a>
				  </li>
				  <li class="nav-item active">
					<a href="#" class="nav-link">
					  <i class="mdi mdi-elevation-rise"></i>Reports</a>
				  </li>
				  <li class="nav-item">
					<a href="#" class="nav-link">
					  <i class="mdi mdi-bookmark-plus-outline"></i>Score</a>
				  </li>
				</ul>-->
				<ul class="navbar-nav navbar-nav-right">
				  <!--<li class="nav-item dropdown">
					<a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
					  <i class="mdi mdi-file-document-box"></i>
					  <span class="count">7</span>
					</a>
					<div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
					  <div class="dropdown-item">
						<p class="mb-0 font-weight-normal float-left">You have 7 unread mails
						</p>
						<span class="badge badge-info badge-pill float-right">View all</span>
					  </div>
					  <div class="dropdown-divider"></div>
					  <a class="dropdown-item preview-item">
						<div class="preview-thumbnail">
						  <img src="../images/faces/face4.jpg" alt="image" class="profile-pic">
						</div>
						<div class="preview-item-content flex-grow">
						  <h6 class="preview-subject ellipsis font-weight-medium text-dark">David Grey
							<span class="float-right font-weight-light small-text">1 Minutes ago</span>
						  </h6>
						  <p class="font-weight-light small-text">
							The meeting is cancelled
						  </p>
						</div>
					  </a>
					  <div class="dropdown-divider"></div>
					  <a class="dropdown-item preview-item">
						<div class="preview-thumbnail">
						  <img src="../images/faces/face2.jpg" alt="image" class="profile-pic">
						</div>
						<div class="preview-item-content flex-grow">
						  <h6 class="preview-subject ellipsis font-weight-medium text-dark">Tim Cook
							<span class="float-right font-weight-light small-text">15 Minutes ago</span>
						  </h6>
						  <p class="font-weight-light small-text">
							New product launch
						  </p>
						</div>
					  </a>
					  <div class="dropdown-divider"></div>
					  <a class="dropdown-item preview-item">
						<div class="preview-thumbnail">
						  <img src="../images/faces/face3.jpg" alt="image" class="profile-pic">
						</div>
						<div class="preview-item-content flex-grow">
						  <h6 class="preview-subject ellipsis font-weight-medium text-dark"> Johnson
							<span class="float-right font-weight-light small-text">18 Minutes ago</span>
						  </h6>
						  <p class="font-weight-light small-text">
							Upcoming board meeting
						  </p>
						</div>
					  </a>
					</div>
				  </li>-->
				  <!--<li class="nav-item dropdown">
					<a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
					  <i class="mdi mdi-bell"></i>
					  <span class="count">4</span>
					</a>
					<div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
					  <a class="dropdown-item">
						<p class="mb-0 font-weight-normal float-left">You have 4 new notifications
						</p>
						<span class="badge badge-pill badge-warning float-right">View all</span>
					  </a>
					  <div class="dropdown-divider"></div>
					  <a class="dropdown-item preview-item">
						<div class="preview-thumbnail">
						  <div class="preview-icon bg-success">
							<i class="mdi mdi-alert-circle-outline mx-0"></i>
						  </div>
						</div>
						<div class="preview-item-content">
						  <h6 class="preview-subject font-weight-medium text-dark">Application Error</h6>
						  <p class="font-weight-light small-text">
							Just now
						  </p>
						</div>
					  </a>
					  <div class="dropdown-divider"></div>
					  <a class="dropdown-item preview-item">
						<div class="preview-thumbnail">
						  <div class="preview-icon bg-warning">
							<i class="mdi mdi-comment-text-outline mx-0"></i>
						  </div>
						</div>
						<div class="preview-item-content">
						  <h6 class="preview-subject font-weight-medium text-dark">Settings</h6>
						  <p class="font-weight-light small-text">
							Private message
						  </p>
						</div>
					  </a>
					  <div class="dropdown-divider"></div>
					  <a class="dropdown-item preview-item">
						<div class="preview-thumbnail">
						  <div class="preview-icon bg-info">
							<i class="mdi mdi-email-outline mx-0"></i>
						  </div>
						</div>
						<div class="preview-item-content">
						  <h6 class="preview-subject font-weight-medium text-dark">New user registration</h6>
						  <p class="font-weight-light small-text">
							2 days ago
						  </p>
						</div>
					  </a>
					</div>
				  </li>-->
				  <li class="nav-item dropdown d-none d-xl-inline-block">
					<a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
					  <span class="profile-text"><?php echo $_SESSION["nombre_usuario"]; ?></span>
					  <!--<img class="img-xs rounded-circle" src="../images/faces/face1.jpg" alt="Profile image">-->
					</a>
					<div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
					  <!--<a class="dropdown-item p-0">
						<div class="d-flex border-bottom">
						  <div class="py-3 px-4 d-flex align-items-center justify-content-center">
							<i class="mdi mdi-bookmark-plus-outline mr-0 text-gray"></i>
						  </div>
						  <div class="py-3 px-4 d-flex align-items-center justify-content-center border-left border-right">
							<i class="mdi mdi-account-outline mr-0 text-gray"></i>
						  </div>
						  <div class="py-3 px-4 d-flex align-items-center justify-content-center">
							<i class="mdi mdi-alarm-check mr-0 text-gray"></i>
						  </div>
						</div>
					  </a>-->
						<form id="login"> 
							<a class="dropdown-item" onclick="AlertaCerrarSesion()" href="#">
								<?php echo utf8_encode("Cerrar Sesión");?>
								<i class="fa fa-window-close"></i>
							</a>
						</form>
					</div>
				  </li>
				</ul>
				<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
				  <span class="mdi mdi-menu"></span>
				</button>
			  </div>
			</nav>
		
            <!--End navbar-->
            <div class="container-fluid page-body-wrapper">
				<nav class="sidebar sidebar-offcanvas" id="sidebar">
				 
					<ul class="nav">
						<li class="nav-item nav-profile">
							<div class="nav-link">
							  <div class="user-wrapper">
								<div class="profile-image">
								  <!--<img src="../images/faces/face1.jpg" alt="profile image">-->
								</div>
								<div class="text-wrapper">
								  <p class="profile-name"><?php echo $_SESSION["nombre_usuario"]; ?></p>
								  <div>
									<small class="designation text-muted"><?php echo $_SESSION["nombre_rol"]; ?></small>
									<span class="status-indicator online"></span>
								  </div>
								</div>
							  </div>
							  <!--<button class="btn btn-success btn-block">New Project
								<i class="mdi mdi-plus"></i>
							  </button>-->
							</div>
						  </li>
						<?php 		
						if( count($MenuLista) > 0)
						{
							$cont =0;
							foreach($MenuLista as $item)
							{
								?>
								<li class="nav-item">								
									<?php
									
									if((count($item) > 3) && ($item[3] == ''))
									{
										$nodoPadreId = $item[0];
										$nodoPadreTitle = str_replace("#","",$item[2]);
										
										?>
											<a id="<?php echo $item[6];?>" class="nav-link" href="<?php echo $item[2];?>" data-toggle="collapse" aria-expanded="false" aria-controls="<?php echo $nodoPadreTitle;?>">
												<?php 											
												if($item[5] == 1)//imagen
												{
													/*
													?>
													<img src="<?php echo $item[4];?>" alt="">
													<?php*/
												}
												else // icono
												{
													?>
													<i class="<?php echo $item[4];?>"></i>
													<?php
												}
												?>											
												<span class="menu-title"><?php echo $item[1];?></span>
												
												<?php
												if((count($MenuLista[$cont+1]) > 3) && ($MenuLista[$cont+1][3] != ''))
												{
													?>
													<i class="menu-arrow"></i>
													<?php
												}
												?>
											</a>							
										<?php
									}
									else if((count($item) > 3) && ($item[3] != ''))
									{
										if($nodoPadreId == $item[3])
										{
											?>
											<div class="collapse" id="<?php echo $nodoPadreTitle;?>">
												<ul class="nav flex-column sub-menu">
													<li class="nav-item">
														<a id="<?php echo $item[6];?>" class="nav-link" href="<?php echo $item[2];?>">
														  <?php 											
															if($item[5] == 1)//imagen
															{
																?>
																<img src="<?php echo $item[4];?>" alt="">
																<?php
															}
															else // icono
															{
																?>
																<i class="<?php echo $item[4];?>"></i>
																<?php
															}
															?>		
														  <?php echo $item[1];?>
														</a>
													</li>
												</ul>
											</div>                                
											<?php
										}
									}
									?>								
								</li>									
								<?php
								$cont = $cont +1;
							}
						}
						?>							
					</ul>
				</nav>
				<!-- SIDEBAR ENDS -->
				
			   <!-- CONTENIDO Principal -->
				<div class="main-panel">
					<div class="content-wrapper dashboard">
					<?php
					$objPrincipal = new Principal();
					echo $objPrincipal->dashboard();
					?>
					</div>
					<footer class="footer">
						<div class="container-fluid clearfix">
						  <span class="float-right">
							  <a href="#">Grupo Casale</a> &copy; 2018
						  </span>
						</div>
					</footer>				
				</div>
            </div>
        </div>
		<script>
			// $(function() {
				  // $( 'ul.nav li' ).on( 'click', function() {
						// $( this ).parent().find( 'li.active' ).removeClass( 'active' );
						// $( this ).addClass( 'active' );
				  // });
			// });
		</script>
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
                    <div class="card-body">
                      <h3 class="card-title text-primary text-left mb-5 mt-4">Mantenimiento</h3>
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
                          <input type="button" onclick="IniciaSesion()" class="btn btn-primary" value="Iniciar Sesión" />
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
		header('Content-Type:text/html; charset=iso-8859-1');
        ?>  		
        
         <div class="container-scroller">
            <div class="container-fluid">
              <div class="row">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center">
                  <div class="card col-lg-8 offset-lg-2">
                    <div class="card-body">
                      <h3 class="card-title text-primary text-left mb-5 mt-4">Registro Usuario</h3>
                      <form id="registro">
                        
                        <input type="hidden" id="desea" name="desea" value="" />                                              
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">                                
                                  <label for="TB_nombre">Nombre</label>
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input id="TB_nombre" name="TB_nombre" type="text" class="form-control p_input" placeholder="Nombre" maxlength="50" />
                                  </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="TB_apellido">Apellido</label>
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input id="TB_apellido" name="TB_apellido" type="text" class="form-control p_input" placeholder="Apellido" maxlength="50"  />
                                  </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="TB_documento">Documento</label>
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-drivers-license-o"></i></span>
                                    <input id="TB_documento" name="TB_documento" type="text" class="form-control p_input" placeholder="Número de Documento" maxlength="50"  />
                                  </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="TB_telefono">Teléfono</label>
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                    <input id="TB_telefono" name="TB_telefono" type="text" class="form-control p_input" placeholder="Teléfono" maxlength="50"  />
                                  </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">                                
                                <div class="form-group">
                                    
                                  <label for="id_rol">Rol</label>            
                                  <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-users"></i></span>                                    
                                        <select style="width: 400px!important;" id="id_rol" name="id_rol" class="show-tick form-control">                                   
                                        </select>
                                  </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="TB_direccion">Dirección</label>
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                    <input id="TB_direccion" name="TB_direccion" type="text" class="form-control p_input" placeholder="Dirección" maxlength="50"  />
                                  </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="TB_email">Email</label>
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope-open"></i></span>
                                    <input id="TB_email" name="TB_email" type="text" class="form-control p_input" placeholder="Email" maxlength="50"  />
                                  </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                
                                  <label for="TB_clave">Clave</label>
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" id="TB_clave" name="TB_clave" type="text" class="form-control p_input" placeholder="Clave" maxlength="50"  />
                                  </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                
                                  <label for="TB_confirmaclave">Confirmar Clave</label>
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" id="TB_confirmaclave" name="TB_confirmaclave" type="text" class="form-control p_input" placeholder="Confirmar Clave" maxlength="50"  />
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