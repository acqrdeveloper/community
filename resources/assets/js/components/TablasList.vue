<template>
    <section>
        <!-- LOADING PAGE -->
        <loading-page v-if="loadingPage"></loading-page>
        <!-- PAGE -->
        <div v-else="" class="row fade in">
            <div class="panel">
                <div class="panel-body">
                    <header>
                        <h3>Lista Tablas Mantenimiento</h3>
                        <hr>
                    </header>
                    <div class="form-inline">
                        <select @change.prevent="fnChange" v-model="selectedTabla" class="form-control text-lowercase">
                            <option value="" selected disabled>- Seleccionar Tabla -</option>
                            <option v-for="x in combo_tablas" :value="x.id">{{x.nombre}}</option>
                        </select>
                        <select v-show="selectedTabla != '' " @change.prevent="fnChange" class="form-control" v-model="selectedEstado">
                            <option value="">- Estado -</option>
                            <option v-for="x in combo_estados" :value="x.id">{{x.value}}</option>
                        </select>
                        <button v-show="selectedTabla != '' " class="btn btn-primary" @click.prevent="fnStoreEditTabla()">
                            <i class="fa fa-plus fa-fw"></i>Nuevo
                        </button>
                        <button v-show="selectedTabla != '' " class="btn btn-success" @click.prevent="fnChange">
                            <i class="fa fa-refresh"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table small">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Valor</th>
                                <th class="text-center">Estado</th>
                                <th>Actualizado</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="loadingTable">
                                <td colspan="6" class="text-success text-center">
                                    <div style="padding: 2em 2em 0 2em">
                                        <i class="fa fa-circle-o-notch fa-spin fa-2x"></i>
                                        <p>cargando data</p>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="!loadingTable" v-for="tabla in tablas">
                                <td>{{ tabla.nombre }}</td>
                                <td>{{ tabla.descripcion }}</td>
                                <td>{{ tabla.valor }}</td>
                                <td class="text-center" v-if="tabla.estado == 'A' " title="activo"><i class="fa fa-circle text-primary"></i></td>
                                <td class="text-center" v-else="tabla.estado == 'I' " title="inactivo"><i class="fa fa-circle text-danger"></i></td>
                                <td>{{ tabla.updated_at }}</td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm" @click.prevent="fnStoreEditTabla(tabla)"><i class="fa fa-edit"></i></button>
                                </td>
                            </tr>
                            <tr v-if="!loadingTable && tablas.length <= 0 ">
                                <td colspan="6" class="text-center text-warning">
                                    <div style="padding: 2em 2em 0 2em">
                                        <i class="fa fa-exclamation-triangle fa-2x"></i>
                                        <p>no hay data</p>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODALS -->
        <component :is="'tabla-create-update-modal'" v-if="showModal">
            <div slot="modal-component">
                <form role="form" @submit.prevent="fnValidateCreateUpdate(newTabla.id)">
                    <div class="modal-header">
                        <button type="button" class="close" @click.prevent="fnOpenCloseModal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 v-if="isPost" class="modal-title">Crear Campo</h4>
                        <h4 v-else="" class="modal-title">Editar Campo</h4>
                    </div>
                    <div v-if="loadModal" class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-center text-muted">
                                    <i class="fa fa-circle-o-notch fa-spin fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else="!loadModal" class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Tabla Referencial</label>
                            <p>Nombre de tabla.</p>
                            <span class="form-control">{{showText(selectedTabla)}}</span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Nombre</label>
                            <p>Escribir nombre.</p>
                            <input type="text" class="form-control" v-model="newTabla.nombre" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Descripción</label>
                            <p>Especificar campo opcional.</p>
                            <input type="text" class="form-control" v-model="newTabla.descripcion" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Valor</label>
                            <p>Especificar campo opcional.</p>
                            <input type="text" class="form-control" v-model="newTabla.valor" required>
                        </div>
                        <div hidden class="form-group">
                            <table class="table table-bordered">
                                <tbody>
                                <tr v-for="n in 10">
                                    <td>
                                        <div class="checkbox"><label class="control-label"><input type="checkbox"/>&nbsp;<b>Personas</b></label></div>
                                    </td>
                                    <td>
                                        <div class="checkbox"><label><input type="checkbox">Crear</label></div>
                                    </td>
                                    <td>
                                        <div class="checkbox"><label><input type="checkbox">Editar</label></div>
                                    </td>
                                    <td>
                                        <div class="checkbox"><label><input type="checkbox"> Actualizar</label></div>
                                    </td>
                                    <td>
                                        <div class="checkbox"><label><input type="checkbox">Eliminar</label></div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-if="!isPost" class="form-group">
                            <label class="control-label">Estado</label>
                            <p class="text-muted">Seleccionar estado.</p>
                            <div class="small">
                                <label class="control-label">
                                    <input value="A" type="radio" v-model="newTabla.estado" class="fa fa-fw"/>Activo
                                </label>
                                <label class="control-label">
                                    <input value="I" type="radio" v-model="newTabla.estado" class="fa fa-fw"/>Inactivo
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" @click.prevent="fnOpenCloseModal"><i class="fa fa-remove fa-fw"></i>Cancelar</button>
                        <button v-if="isPost" type="submit" class="btn btn-primary"><i class="fa fa-check fa-fw"></i>Crear</button>
                        <button v-else="" type="submit" class="btn btn-primary"><i class="fa fa-check fa-fw"></i>Actualizar</button>
                    </div>
                </form>
            </div>
        </component>
    </section>
</template>
<script>
    /**
     * Created by aquispe on 05/11/2017.
     **/
    import Vue from 'vue';
    import Service from '../services/TablasService';
    import LoadingPage from '../components/LoadingPage.vue';
    import TablaCreateUpdateModal from '../components/Modal.vue';

    Vue.component('loading-page', LoadingPage);
    Vue.component('tabla-create-update-modal', TablaCreateUpdateModal);

    export default {
        data: () => ({
            // CONTROL
            combo_estados:Service.state.util.combo_estados,
            combo_tablas: [],
            loadingPage: true,
            loadingTable: false,
            loadModal: true,
            showModal: false,
            isPost: true,
            // DATABASE
            selectedTabla: "",
            selectedEstado:"A",
            newTabla: [],
            tablas: [],
            tabla: {},
            params: {
                tabla: null,
                id: null,
                estado:null,
            },
        }),
        beforeCreate() {
            setTimeout(() => {this.loadingPage = !this.loadingPage;}, 1000);
        },
        created() {
            Service.dispatch("load", {self: this});
        },
        computed: {},
        methods: {
            showText(val) {
                for (let i = 0; i < this.combo_tablas.length; i++) {
                    if (this.combo_tablas[i].id === val) return this.combo_tablas[i].nombre;
                }
                return "";
            },
            fnChange() {
                // Seleccionar tipo tabla
                this.loadingTable = !this.loadingTable;
                this.params.tabla = this.selectedTabla;
                this.params.estado = this.selectedEstado;
                Service.dispatch("fetch", {self: this});
            },
            fnStoreEditTabla(objeto = null) {
                // Abrir modal crear o editar tabla
                if (objeto != null) {
                    this.isPost = false;
                    this.newTabla = [];
                    this.newTabla = objeto;
                } else {
                    this.isPost = true;
                    this.newTabla = {};
                }
                this.fnOpenCloseModal();
            },
            fnUpdateTabla(id) {
                // Actualizar tabla
                this.params.tabla = this.selectedTabla;
                this.params.id = id;
                Service.dispatch("update", {self: this});
                this.loadingTable = !this.loadingTable;
                this.fnOpenCloseModal();
            },
            fnStoreTabla() {
                // Crear tabla
                this.params.tabla = this.selectedTabla;
                Service.dispatch("store", {self: this});
                this.loadingTable = !this.loadingTable;
                this.fnOpenCloseModal();
            },
            fnValidateCreateUpdate(id) {
                // Validar tipo de submit
                if (this.isPost) {
                    this.fnStoreTabla();
                } else{
                    this.fnUpdateTabla(id);
                }
            },
            fnOpenCloseModal() {
                if (this.showModal) {// forClose
                    document.getElementById('super-body').classList.remove("modal-open");
                    this.showModal = false;
                    this.loadModal = true;
                } else {// forOpen
                    document.getElementById('super-body').classList.add("modal-open");
                    if (!this.isPost) {
                        this.showModal = true;
                        setTimeout(() => {this.loadModal = false;}, 1000);
                    } else {
                        this.loadModal = false;
                        this.showModal = true;
                    }
                }
            },
        }
    }
</script>
