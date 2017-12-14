<template>
    <section>
        <!-- BEFORE PAGE -->
        <component :is="'loading-page'" v-if="loadingPage"></component>
        <!-- PAGE -->
        <div v-else="" class="row fade in">
            <form role="form" @submit.prevent="fnValidateCreateUpdate">
                <div class="panel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <!--<div class="thumbnail">-->
                                <img :src="'/images/users/'+newPersona.imagen" width="100%" height="100%"
                                     style="max-width: 129px;max-height: 129px;">
                                <!--</div>-->
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="pull-left">
                                            <h3 class="text-uppercase">
                                                <span v-if="newPersona.estado == 'A' "
                                                      class="text-primary">{{newPersona.apellido_paterno}} {{newPersona.apellido_materno}}, {{newPersona.nombres}}</span>
                                                <span v-else=""
                                                      class="text-danger">{{newPersona.apellido_paterno}} {{newPersona.apellido_materno}}, {{newPersona.nombres}}</span>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="pull-right">
                                            <router-link class="btn btn-primary" :to="{name:'personas'}"><i
                                                    class="fa fa-angle-left fa-fw"></i>volver
                                            </router-link>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-2">
                                        <table class="table">
                                            <tr>
                                                <td><b>D.N.I</b>&nbsp;:</td>
                                                <td>{{newPersona.dni}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-2">
                                        <table class="table">
                                            <tr>
                                                <td><b>F.Nto</b>&nbsp;:</td>
                                                <td class="small">
                                                    {{moment(newPersona.fecha_nacimiento).format('DD-MM-YYYY')}}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-2">
                                        <table class="table">
                                            <tr>
                                                <td><b>Edad</b>&nbsp;:</td>
                                                <td>{{newPersona.edad}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-2">
                                        <table class="table">
                                            <tr>
                                                <td><b>Sexo</b>&nbsp;:</td>
                                                <td>
                                                    <span v-if="newPersona.sexo=='M' ">Masculino</span>
                                                    <span v-else>Femenino</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-2">
                                        <table class="table">
                                            <tr>
                                                <td><b>Estado</b>&nbsp;:</td>
                                                <td>
                                                    <span v-if="newPersona.estado == 'A' "
                                                          class="text-primary">Activo</span>
                                                    <span class="text-danger" v-else>Inactivo</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a title="general" href="#1" aria-controls="home" role="tab" data-toggle="tab">
                            <h5><span><i class="fa fa-user fa-fw"></i>General</span></h5></a>
                    </li>
                    <li v-show="newPersona.es_empresa" role="presentation">
                        <a title="avanzada" href="#3" aria-controls="profile" role="tab" data-toggle="tab">
                            <h5><span><i class="fa fa-money fa-fw"></i>Empresa</span></h5>
                        </a>
                    </li>
                    <li role="presentation">
                        <a title="avanzada" href="#2" aria-controls="profile" role="tab" data-toggle="tab">
                            <h5><span><i class="fa fa-money fa-fw"></i>Pagos</span></h5>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="1">
                        <div class="panel nav-panel">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="control-label">Dirección | Lugar | Zona</label>
                                    <p class="text-muted">Ubicacion de hogar.</p>
                                    <div class="form-control">{{newPersona.direccion}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Correo</label>
                                            <p class="text-muted">Correo.</p>
                                            <div class="form-control">{{newPersona.email}}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Estado Civil</label>
                                            <p class="text-muted">Estado civil.</p>
                                            <div v-if="newPersona.estado_civil == 'C' " class="form-control">Casado
                                            </div>
                                            <div v-else-if="newPersona.estado_civil == 'V' " class="form-control">
                                                Viudo
                                            </div>
                                            <div v-else-if="newPersona.estado_civil == 'S' " class="form-control">
                                                Soltero
                                            </div>
                                            <div v-else-if="newPersona.estado_civil == 'D' " class="form-control">
                                                Divorciado
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="2">
                        <div class="panel nav-panel">
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="form-inline">
                                        <input type="date" class="form-control"/>
                                        <select class="form-control">
                                            <option value="">pagado</option>
                                            <option value="">pendiente</option>
                                            <option value="">vencido</option>
                                        </select>
                                    </div>
                                </div>
                                <table class="table small">
                                    <thead class="bg-primary">
                                    <tr>
                                        <th>Tipo Comprobante</th>
                                        <th>N° Comprobante</th>
                                        <th>Fecha Emitido</th>
                                        <th>Fecha Vencido</th>
                                        <th>Fecha Creado</th>
                                        <th>I.G.V</th>
                                        <th>Monto</th>
                                        <th>Total</th>
                                        <th class="text-center"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="n in 10">
                                        <td v-if="n%2==0">Boleta</td>
                                        <td v-else="">Factura</td>
                                        <td>FF01-09231</td>
                                        <td>2017-01-04</td>
                                        <td>2017-01-04</td>
                                        <td>2017-01-04</td>
                                        <td>S/.508.54</td>
                                        <td>S/.508.54</td>
                                        <td>S/.508.54</td>
                                        <td class="text-center">
                                            <div class="btn-group dropdown btn-group-sm" role="group">
                                                <button title="detalle" type="button" class="btn btn-default"><i
                                                        class="fa fa-file fa-fw"></i></button>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false">
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                        <li title="historial">
                                                            <a @click.prevent="fnOpenCloseModal" href><i
                                                                    class="fa fa-book fa-fw"></i>Historial</a>
                                                        </li>
                                                        <li title="anular">
                                                            <a href><i class="fa fa-remove fa-fw"></i>Anular</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="3">
                        <div class="panel nav-panel">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="control-label">Nombre Comercial</label>
                                    <p>Escriba el nombre de la empresa.</p>
                                    <div class="form-control">{{newEmpresa.nombre_comercial}}</div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Dirección Empresa</label>
                                    <p>Escriba la dirección de la empresa.</p>
                                    <div class="form-control">{{newEmpresa.direccion}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="control-label">Razon Social</label>
                                        <p>Escriba la razon social de la empresa.</p>
                                        <div class="form-control">{{newEmpresa.razon_social}}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">R.U.C | D.N.I</label>
                                        <p>Ingrese el RUC o el DNI.</p>
                                        <div class="form-control">{{newEmpresa.ruc}}</div>
                                    </div>
                                    <div class="col-md-4" v-show="!isPost">
                                        <div class="form-group">
                                            <label class="control-label">Estado</label>
                                            <p class="text-muted">Estado.</p>
                                            <div v-if="newEmpresa.estado == 'A'" class="form-control">Activo</div>
                                            <div class="form-control" v-else>Inactivo</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- MODALS -->
        <component :is="'persona-pay-history-modal'" v-if="showModal">
            <div slot="modal-component">
                <div class="modal-header">
                    <button type="button" class="close" @click.prevent="fnOpenCloseModal"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Historial Pagos</h4>
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
                <div v-else="" class="modal-body modal-scroll">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Descripcion</th>
                            <th>Fecha Actualizado</th>
                        </tr>
                        </thead>
                        <tbody class="small">
                        <tr v-for="n in 100">
                            <td>super administrador</td>
                            <td><b>AUMENTO</b> 10 soles a mariano carranza</td>
                            <td>{{moment().format('YYYY-MM-DD HH:mm:ss')}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" @click.prevent="fnOpenCloseModal" class="btn btn-danger">Cerrar</button>
                </div>
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
    import Multiselect from 'vue-multiselect';
    import LoadingPage from '../components/LoadingPage.vue';
    import PersonaPayHistoryModal from '../components/Modal.vue';

    Vue.component('multiselect', Multiselect);
    Vue.component('loading-page', LoadingPage);
    Vue.component('persona-pay-history-modal', PersonaPayHistoryModal);

    export default {
        data: () => ({
            // CONTROL
            moment: Moment,
            showModal: false,
            loadModal: true,
            loadingPage: true,
            // DATABASE
            newPersona: {},
            newEmpresa: {},
            imageSrc: null,
            id: null,
            isPost: false,
        }),
        beforeCreate() {
        },
        created() {
            // Alert
            document.getElementById('alert_error').style.display = 'none';
            document.getElementById('alert_flash').style.display = 'none';
            // Route
            if (this.$route.params.id != undefined) {
                this.id = this.$route.params.id;
                Service.dispatch("detail", {self: this});
            } else {
                setTimeout(() => {
                    this.loadingPage = !this.loadingPage;
                }, 1000);
            }
        },
        watch: {
            // Escuchar
            $route() {
                setTimeout(() => {
                    this.loadingPage = !this.loadingPage;
                }, 1000);
                this.isPost = !this.isPost;
                this.newPersona = this.tempPersona;
                this.loadingPage = !this.loadingPage;
            }
        },
        computed: {},
        methods: {
            fnDetailPersona() {
                this.newPersona.dia = this.moment(this.newPersona.fecha_nacimiento, Service.state.util.formatDate).format("D");
                this.newPersona.mes = this.moment(this.newPersona.fecha_nacimiento).month() + 1;
                this.newPersona.anio = this.moment(this.newPersona.fecha_nacimiento, Service.state.util.formatDate).format("YYYY");
            },
            fnOpenCloseModal() {
                if (this.showModal) {// Cerrar
                    this.showModal = false;
                    this.loadModal = true;
                    document.getElementById('super-body').classList.remove("modal-open");
                } else {// Abrir
                    document.getElementById('super-body').classList.add("modal-open");
                    this.showModal = true;
                    setTimeout(() => {this.loadModal = false;}, 1000);
                }
            },
        }
    }
</script>  
