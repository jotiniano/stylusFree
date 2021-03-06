  <div>
        <!-- row of columns -->
        <div class="row-fluid">
          
          <div>
                <ul class="breadcrumb">                    
                    <li><a href="/user/crear">Agregar Usuario</a></li>
                </ul>
              <form class="well inline" method="post" enctype="multipart/form-data" >
                      <h3>Buscar Usuario</h3>
                      <hr>                      
                      <div class="row-fluid">
                          <div class="span2">
                              <h4>Cod. Usuario</h4>
                              <?php echo $this->form->idUsuario;?>
                           </div>
                          <div class="span3">
                              <h4>Nombre</h4>
                              <?php echo $this->form->nombreUsuario;?>
                           </div>
                          <div class="span3">
                              <h4>Usuario</h4>
                              <?php echo $this->form->usuario;?>
                           </div>                          
                          <div class="span3">
                              <?php echo $this->form->buscar?>
                           </div>
                      </div>
                 </form>
                 <div id="message"></div>
                 <table class="table table-bordered">                     
                   <thead>
                     <tr>                       
                       <th>
                            Código
                       </th>
                       <th>
                           Nombre
                       </th>
                       <th>
                           Apellido
                       </th>
                       <th>
                           Usuario
                       </th>
                       <th>
                           Tipo
                       </th>
                       <th>                          
                          Estado
                       </th>
                       <th>
                          Acciones
                       </th>
                     </tr>
                   </thead>
                   <tbody>
                     <?php
                     foreach ($this->result as $res):?>
                     <tr>
                      <td>
                         <?php echo $res["idUsuario"]; ?>
                       </td>
                       <td>
                         <?php echo $res["nombreUsuario"]; ?>
                       </td>
                       <td>
                         <?php echo $res["apellidoUsuario"]; ?>
                       </td>
                       <td>
                         <?php echo $res["usuario"]; ?>
                       </td>
                       <td>
                         <?php echo $res["descripcion"]; ?>
                       </td>
                       <td>
                         <?php if($res["estado"]==1):
                             echo  "Activo"; 
                             else:
                                 "Inactivo";
                             endif; ?>
                       </td>
                       <td>
                           <a href="/admin/user/editar/id/<?php echo $res["idUsuario"]; ?>" title="Editar">Editar</a> |
                           <a href="/admin/user/eliminar/id/<?php echo $res["idUsuario"]; ?>" title="Editar">Eliminar</a>
                       </td>
                     </tr>
                         <?php endforeach; ?>
                   </tbody>
                 </table>
         </div>
        </div>                
  </div>