<div class="col-md-12">
                            <div class="card">
                                
                                
                                <div class="card-content">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th>Alternativas</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($alternativas->getResult() as $key) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $key->id_alternativa?></td>
                                                        <td><?php echo $key->alternativa?></td>
                                                        <td>
                                                            <input type="radio" id="acepta" name="acepta" value="<?php echo $key->id_alternativa?>">Seleccionada
                                                            <button type="button" rel="tooltip" onclick="elimina('<?php echo $key->id_alternativa?>')" class="btn btn-sm btn-outline-danger">
                                                            Eliminar
                                                        </button></td>
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