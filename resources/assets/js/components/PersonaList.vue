<template>
    <section>
        <!-- BEFORE PAGE -->
        <component :is="'loading-page'" v-if="loadingPage"></component>
        <!-- PAGE -->
        <div v-else="" class="row fade in">
            <div class="panel">
                <div class="panel-body">
                    <header>
                        <h3><span class="small text-muted">
                            <a title="obtener más infomación" href data-toggle="modal" data-target="#help-modal"><i class="fa fa-question-circle"></i></a>
                        </span>&nbsp;Lista Personas</h3>
                        <hr>
                    </header>
                    <div class="form-inline">
                        <select @change="buscar = '' " v-model="selectedFiltro" class="form-control">
                            <option value="" selected disabled>- Filtrar por Campo -</option>
                            <option value="dni">Dni</option>
                            <option value="nombre">Nombres</option>
                            <option value="apellido">Apellidos</option>
                        </select>
                        <input v-show="selectedFiltro != '' " @keyup="fnKeyup" v-model="buscar" type="text" class="form-control" :placeholder="'Buscar por '+selectedFiltro">
                        <select @change="fnChange" v-model="selectedEstado" class="form-control">
                            <option value="" selected>- Estado -</option>
                            <option value="A">activo</option>
                            <option value="I">inactivo</option>
                        </select>
                        <button type="button" @click="fnClean" class="btn btn-info"><i class="fa fa-eraser fa-fw"></i>Limpiar</button>
                    </div>
                </div>
            </div>
            <div class="panel">
                    <div class="panel-body">
                        <table class="table small">
                            <thead>
                            <tr>
                                <th>Apellidos Nombres</th>
                                <th>Dni</th>
                                <th>Edad</th>
                                <th>F.Nacimiento</th>
                                <th>Telefonos</th>
                                <th>Correo</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center w-10"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="loadingTable">
                                <td colspan="8" class="text-success text-center">
                                    <div style="padding: 2em 2em 0 2em">
                                        <i class="fa fa-circle-o-notch fa-spin fa-2x"></i>
                                        <p>cargando data</p>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="!loadingTable" v-for="persona in personas">
                                <td>
                                    <router-link :to="{name: 'persona-show', params: {id: persona.id}}" title="detalle" class="btn-link text-uppercase">{{persona.apellido_paterno}} {{persona.apellido_materno}}, {{persona.nombres}}</router-link>
                                </td>
                                <td>{{persona.dni}}</td>
                                <td>{{persona.edad}}</td>
                                <td>{{moment(persona.fecha_nacimiento).format('DD-MM-YYYY')}}</td>
                                <td>{{persona.telefono}}</td>
                                <td>{{persona.email}}</td>
                                <td class="text-center">
                                    <i v-if=" persona.estado == 'A' " class="fa fa-circle text-primary"></i>
                                    <i v-else="" class="fa fa-circle text-danger"></i>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group dropdown btn-group-sm" role="group">
                                        <router-link :to="{name: 'persona-show', params: {id: persona.id}}" title="detalle" class="btn btn-default"><i class="fa fa-eye fa-fw"></i></router-link>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                <li title="editar">
                                                    <router-link :to="{name: 'persona-edit', params: {id: persona.id}}">
                                                        <i class="fa fa-edit fa-fw"></i>Editar
                                                    </router-link>
                                                </li>
                                                <li title="cambiar estado">
                                                    <a href @click.prevent="fnOpenCloseModal(persona)"><i class="fa fa-circle fa-fw"></i>Estado</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="!loadingTable && personas.length <= 0 ">
                                <td colspan="8" class="text-center text-warning">
                                    <div style="padding: 2em 2em 0 2em">
                                        <i class="fa fa-exclamation-triangle fa-2x"></i>
                                        <p>no hay data</p>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <component :is="'paginate'" :page-count="Math.ceil(pagination.total / pagination.per_page)" :click-handler="fnPaginate" :container-class="'pagination pull-right'"><span slot="prevContent">&laquo;</span><span slot="nextContent">&raquo;</span></component>
                    </div>
                </div>
        </div>
        <!-- MODALS -->
        <component :is="'help-modal'">
            <div slot="help-modal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Ayuda</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <p>Mas información</p>
                    </div>
                </div>
            </div>
        </component>
        <component :is="'change-status-modal'" v-if="showModal">
            <div slot="modal-component">
                <form role="form" @submit.prevent="fnChangeEstado">
                    <div class="modal-header">
                        <button type="button" class="close" @click.prevent="fnOpenCloseModal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Cambiar Estado</h4>
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
                    <div v-else="" class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label><input value="A" v-model="estado2" type="radio"/> Activo</label>
                                <label><input value="I" v-model="estado2" type="radio"/> Inactivo</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" @click="fnOpenCloseModal"><i class="fa fa-remove fa-fw"></i>Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check fa-fw"></i>Actualizar</button>
                    </div>
                </form>
            </div>
        </component>
    </section>
</template>
<script>
    /**
     * Created by aquispe on 04/11/2017.
     **/
    import Vue from 'vue';
    import Service from '../services/PersonaService';
    import Moment from 'moment';
    import Paginate from 'vuejs-paginate';
    import LoadingPage from '../components/LoadingPage.vue';
    import HelpModal from '../components/HelpModal.vue';
    import ChangeStatusModal from '../components/Modal.vue';

    Vue.component('paginate', Paginate);
    Vue.component('loading-page', LoadingPage);
    Vue.component('help-modal', HelpModal);
    Vue.component('change-status-modal', ChangeStatusModal);

    export default {
        data: () => ({
            // CONTROL
            moment: Moment,
            loadingPage: true,
            loadingTable: true,
            showModal: false,
            loadModal: true,
            // DATABASE
            persona: {},
            personas: [],
            pagination: {
                total: 0,
                per_page: 2,
                from: 1,
                to: 0,
                current_page: 1
            },
            buscar: "",
            estado2: "A",
            params: {
                filtro: null,
                buscar: null,
                estado: null,
                page: 1,
                id: null,
            },
            selectedFiltro:"",
            selectedEstado: "A",
        }),
        beforeCreate() {
            setTimeout(() => {
                // Load
                this.loadingPage = !this.loadingPage;
                // Hide
//                document.getElementById('alert_error').style.display = 'none';
//                document.getElementById('alert_flash').style.display = 'none';
            }, 1000);
        },
        created() {
            // Listar
            this.fnChange();
        },
        computed: {},
        methods: {
            fnPaginate: function (page) {
                // Paginar
                this.params.page = page;
                this.loadingTable = !this.loadingTable;
                Service.dispatch("fetch", {self: this});
            },
            fnClean() {
                // Limpiar
                this.loadingTable = !this.loadingTable;
                this.buscar = "";
                this.selectedEstado = "A";
                this.selectedFiltro = "";
                this.fnChange();
            },
            fnChange() {
                // Filtrar
                this.loadingTable = true;
                this.params.buscar = this.buscar;
                this.params.estado = this.selectedEstado;
                this.params.filtro = this.selectedFiltro;
                Service.dispatch("fetch", {self: this});
            },
            fnKeyup() {
                // Escribir
                this.loadingTable = !this.loadingTable;
                this.params.page = 1;
                if (this.buscar.length >= 3) {
                    this.fnChange();
                } else if(this.buscar.length == "") {
                    this.fnChange();
                }
            },
            fnChangeEstado() {
                // Cambiar
                this.params.estado = this.estado2;
                Service.dispatch("changeStatus", {self: this});
            },
            fnOpenCloseModal(objeto = null) {
                if (objeto != undefined) {
                    this.params.id = objeto.id;
                    this.estado2 = objeto.estado;
                }
                if (this.showModal) {// Cerrar
                    document.getElementById('super-body').classList.remove("modal-open");
                    this.showModal = false;
                    this.loadModal = true;
                } else {// Abrir
                    document.getElementById('super-body').classList.add("modal-open");
                    if (!this.isPost) {
                        this.showModal = true;
                        setTimeout(() => {this.loadModal = false;}, 1000);
                    } else {
                        this.showModal = true;
                        this.loadModal = false;
                    }
                }
            }
        }
    }
</script>