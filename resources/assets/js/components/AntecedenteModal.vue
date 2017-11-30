<!-- Modal -->
<template>
    <transition name="modal">
        <div class="modal-mask fade">
            <div class="modal-wrapper">
                <div class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Nuevo Antecendente</h4>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <div class="form-group">
                                        <label class="control-label">Estado</label>
                                        <p>Seleccionar.</p>
                                        <select name="" id="" class="form-control">
                                            <option value="" disabled selected>- seleccionar -</option>
                                            <option value="">correcional</option>
                                            <option value="">grave</option>
                                            <option value="">muy grave</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Descripcion</label>
                                        <p>Detalle o documente el caso.</p>
                                        <textarea cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal"><i
                                        class="fa fa-check fa-fw"></i>Crear
                                </button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                        class="fa fa-remove fa-fw"></i>Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
