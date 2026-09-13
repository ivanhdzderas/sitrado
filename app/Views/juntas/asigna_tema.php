<div class="col-sm-5 col-sm-offset-1">
                                                         <div class="form-group label-floating">
                                                         <label class="control-label">Tema de la junta
                                                            </label>
                                                           <select id="nombre_junta" name="nombre_junta" class="form-control">
                                                                <option value=""></option>
                                                                <?php 
                                                                foreach ($todas_juntas->getResult() as $key) {
                                                                    ?>
                                                                    <option value="<?php echo $key->id_junta?>"><?php echo $key->tema?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                           </select>
                                                            </div></div>
                                                             <div class="col-sm-5">
                                                                     <button id="mostrar" name="mostrar" onclick="mostrar_temas()" class="btn btn-success">Mostrar</button>
                                                             </div>
                                                            <div class="col-lg-10 col-lg-offset-1" id="desglose_temas">
                                                                    <div class="input-group" >
                                                                    En espera de respuesta...
                                                                    </div>
                                                            </div