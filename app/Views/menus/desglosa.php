
<div class="col-md-12">
                            <div class="card">


                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">&#xE5D2;</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Estructura</h4>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="table-responsive table-sales">
                                                <table class="table">
                                                    <tbody>
                                                    <tr>
                                                           
                                                            
                                                            <td class="text-right">
                                                                Menu
                                                            </td>
                                                            <td>
                                                            </td>
                                                            <td class="text-right">
                                                                SubMenu
                                                            </td>
                                                            <td>
                                                                
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        foreach ($datos->getResult() as $item) {
                                                           ?>
  <tr>
                                                           
                                                            
                                                            <td class="text-right">
                                                                <?php echo $item->menu?>
                                                            </td>
                                                            <td>
                                                            <?php  if ($item->idmenu==NULL){}else{ ?>
                                                                <a href="../elimina_menu/<?php echo $item->idmenu?>/<?php echo $item->empresa?>" class="btn btn-sm btn-outline-danger">Eliminar</a>
                                                            <?php
                                                            }?>
                                                            </td>
                                                            <td class="text-right">
                                                                 <?php echo $item->submenu?>
                                                            </td>
                                                            <td>
                                                              <?php  if ($item->idsubmenu==NULL){}else{ ?>
                                                                <a href="../elimina_submenu/<?php echo $item->idsubmenu?>/<?php echo $item->empresa?>" class="btn btn-sm btn-outline-danger">Eliminar</a>
                                                                  <?php
                                                            }?>
                                                            </td>
                                                        </tr>
                                                           <?php
                                                        }
                                                        ?>
                                                         
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>