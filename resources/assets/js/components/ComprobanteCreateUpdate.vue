<template>
    <section>
        <!-- BEFORE PAGE -->
        <component :is="'loading-page'" v-if="loadingPage"></component>
        <!-- PAGE -->
        <div v-else="" class="row fade in">
            <div class="panel">
                <div class="panel-body">
                    <header>
                        <h3>
                            <span class="small text-muted">
                                <a title="obtener más infomación" href data-toggle="modal" data-target="#myModal"><i class="fa fa-question-circle"></i></a>
                            </span>&nbsp;Comprobante de Pago
                        </h3>
                        <hr>
                    </header>
                    <div class="pull-right">
                        <button type="button" disabled class="btn btn-warning"><i class="fa fa-print fa-fw"></i>Vista Previa
                        </button>
                        <button type="button" class="btn btn-danger"><i class="fa fa-remove fa-fw"></i>Cancelar</button>
                        <button @click.prevent="fnStore" type="button" class="btn btn-primary"><i class="fa fa-check fa-fw"></i>Crear Deuda(s)
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-body">
                    <form role="form">
                        <div class="alert alert-warning">
                            <div class="row">
                                <div class="col-md-4">
                                    <label><i class="fa fa-user fa-fw"></i>Usuario Auth</label>
                                    <div>{{auth.nombres_apellidos}}</div>
                                </div>
                                <div class="col-md-8">
                                    <label><i class="fa fa-unlock-alt fa-fw"></i>Token Auth</label>
                                    <div>{{auth.remember_token}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-info">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-table fa-fw"></i>Tipo Comprobante</label>
                                        <select @change="fnChangeTipoComprobante" v-model="selectedTipoComprobante" class="form-control">
                                            <option value="">- seleccionar -</option>
                                            <option value="F">Factura</option>
                                            <option value="B">Boleta</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>.</label>
                                        <input v-model="folio" type="text" class="form-control" placeholder="F-" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                    <div class="form-group pull-right">
                                        <label><i class="fa fa-calendar-check-o fa-fw"></i>Fecha Facturación</label>
                                        <component :is="'date-picker'" lang="es" v-model="selectedFechaSearch"></component>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h4><i class="fa fa-angle-double-right fa-fw"></i>Empresa / Cliente</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <button @click.prevent="fnOpenCloseModal(1)" :disabled="selectedTipoComprobante != '' ? false : true " class="btn btn-warning">
                                    <span v-show="!validateEmpresaComprobante"><i class="fa fa-plus fa-fw"></i>Agregar Empresa</span>
                                    <span v-show="validateEmpresaComprobante"><i class="fa fa-edit fa-fw"></i>Cambiar Empresa</span>
                                </button>
                                <button :disabled="validateEmpresaComprobante ? false : true" class="btn btn-warning " @click.prevent="fnOpenCloseModal(2)">
                                    <span v-show="!validateClienteComprobante"><i class="fa fa-plus fa-fw"></i>Agregar Cliente</span>
                                    <span v-show="validateClienteComprobante"><i class="fa fa-edit fa-fw"></i>Cambiar Cliente</span>
                                </button>
                            </div>
                        </div>
                        <header>
                            <hr>
                        </header>
                        <div v-show="validateEmpresaComprobante" class="alert alert-default text-uppercase">
                            <table width="100%">
                                <tr>
                                    <td width="95%">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="text-capitalize">Razón Social</label>
                                                <div>{{empresaComprobante.razon_social}}</div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>R.U.C</label>
                                                <div>{{empresaComprobante.ruc}}</div>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="text-capitalize">Dirección</label>
                                                <div>{{empresaComprobante.direccion}}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td width="5%" class="text-center"><i class="fa fa-angle-left"></i></td>
                                </tr>
                            </table>
                        </div>
                        <div v-show="validateClienteComprobante" class="alert alert-default text-uppercase">
                            <table width="100%">
                                <tr>
                                    <td width="95%">
                                        <div v-show="!validateClienteIds" class="row">
                                            <div class="col-md-4">
                                                <label class="text-capitalize">Nombres y Apellidos</label>
                                                <div>{{clienteComprobante.nombres}}</div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>D.N.I</label>
                                                <div>{{clienteComprobante.dni}}</div>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="text-capitalize">Dirección</label>
                                                <div>{{clienteComprobante.direccion}}</div>
                                            </div>
                                        </div>
                                        <div v-show="validateClienteIds" class="row">
                                            <div class="col-md-12">Seleccionado {{checkedClienteSelected.length}} personas</div>
                                        </div>
                                    </td>
                                    <td width="5%" class="text-center"><i class="fa fa-angle-left"></i></td>
                                </tr>
                            </table>
                        </div>
                        <header v-show="validateClienteComprobante">
                            <br>
                            <h4><i class="fa fa-angle-double-right fa-fw"></i>Detalle</h4>
                            <hr>
                        </header>
                        <div v-show="validateClienteComprobante" class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Actividad</label>
                                    <p>Seleccionar actividad / producto.</p>
                                    <select @change="fnChangeActividad(actividades[selectedActividad - 1])" v-model="selectedActividad" class="form-control">
                                        <option value="" selected disabled>- seleccionar -</option>
                                        <option v-for="actividad in actividades" :value="actividad.id" class="text-capitalize">{{actividad.nombre}}</option>
                                    </select>
                                </div>
                            </div>
                            <div v-show="selectedActividad != '' " class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">
                                        <input v-show="selectedActividad == 3 " title="modificar precio"
                                               v-model="checkedModificarPrecio" type="checkbox" class="fa fa-fw"/>Precio</label>
                                    <p>Precio calculado.</p>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span>S/.</span>
                                        </div>
                                        <input v-model="precio" type="number" class="form-control" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div v-show="checkedModificarPrecio" class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Autosumar Precio</label>
                                    <p>Agregar monto.</p>
                                    <input v-model="precio_autosuma" type="number" class="form-control" placeholder="0.00"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">.</label>
                                    <p class="control-label">.</p>
                                    <button :disabled="selectedActividad != '' ? false : true" @click.prevent="fnPushItem(data_comprobante)" type="button" class="btn btn-warning btn-block"><i class="fa fa-plus fa-fw"></i>Agregar Item
                                    </button>
                                </div>
                            </div>
                            <div v-show="selectedActividad != '' " class="col-md-12">
                                <div class="form-group">
                                    <label title="modificar concepto de actividad" class="control-label">
                                        <input v-model="checkedDescripcion" type="checkbox" class="fa fa-fw"/>Concepto o Descripción</label>
                                    <p>Descripción de pago.</p>
                                    <textarea :disabled="checkedDescripcion ? false : true" rows="2" class="form-control">{{descripcion}}</textarea>
                                </div>
                            </div>
                            <div v-show="checkedModificarPrecio" class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Observación por Modificación de Precio</label>
                                    <textarea rows="2" class="form-control" placeholder="Describa el ¿porque?."></textarea>
                                </div>
                            </div>
                        </div>
                        <table v-show="validateClienteComprobante" class="table">
                            <thead>
                            <tr>
                                <th width="15%">Id Producto</th>
                                <th width="65%">Descripción</th>
                                <th width="15%">Precio</th>
                                <th width="5%"></th>
                            </tr>
                            </thead>
                            <tbody class="table-bordered">
                            <tr v-for="(item,index) in items">
                                <td>{{item.id}}</td>
                                <td>{{item.descripcion}}</td>
                                <td>{{item.valor}}</td>
                                <td>
                                    <button @click.prevent="fnRemoveItem({item,index})" type="button" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></button>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="2"><b>SubTotal</b></td>
                                <td colspan="2"><span>S/.</span>{{subtotal}}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><b>I.G.V</b></td>
                                <td colspan="2"><span>S/.</span>{{igv}}</td>
                            </tr>
                            <tr class="bg-default">
                                <td colspan="2"><b>Total</b></td>
                                <td colspan="2"><span>S/.</span>{{total}}</td>
                            </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>
            <div v-if="false" class="panel">
                <div class="panel-body">
                    <div class="alert alert-default">
                        <header>
                            <label class="control-label">Comprobante Autogenerado</label>
                            <hr>
                        </header>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-inline">
                                    <select class="form-control">
                                        <option value="A">activo</option>
                                        <option value="A">pendiente</option>
                                        <option value="A">deuda</option>
                                    </select>
                                    <component :is="'date-picker'" lang="es" v-model="selectedFechaSearch" ></component>
                                    <component :is="'date-picker'" lang="es" v-model="selectedFechaSearch2" ></component>
                                </div>
                            </div>
                        </div>
                        <br>
                        <table class="table small table-bordered">
                            <thead class="bg-primary">
                            <tr>
                                <th>Tipo</th>
                                <th>Persona</th>
                                <th>Dni</th>
                                <th>Fecha Creado</th>
                                <th>Fecha Emitido</th>
                                <th>Fecha Vencido</th>
                                <th>Fecha Actualizado</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>BOLETA</td>
                                <td>alex quispe roque</td>
                                <td>72482060</td>
                                <td>2017-11-06 10:05:23</td>
                                <td>2017-11-07</td>
                                <td>2017-11-07</td>
                                <td>2017-11-06 10:05:23</td>
                                <td>PENDIENTE PAGO</td>
                                <td>
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODALS -->
        <component :is="'empresa-list-modal'" v-if="showModal">
            <div slot="modal-component">
                <div class="modal-header">
                    <button type="button" class="close" @click.prevent="fnOpenCloseModal(1)" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="form-inline">
                        <select v-model="selectedFiltroEmpresa" class="form-control">
                            <option value="" selected disabled>- Seleccionar Empresa -</option>
                            <option value="nombre_empresa">nombre empresa</option>
                            <option value="ruc">ruc</option>
                        </select>
                        <input v-show="selectedFiltroEmpresa != '' " v-model="buscarEmpresa" type="text" class="form-control w-30" :placeholder="'Buscar por ' + selectedFiltroEmpresa"/>
                    </div>
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
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Empresa</th>
                                    <th>Ruc</th>
                                    <th>Tipo</th>
                                    <th width="5%"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="empresa in empresas">
                                    <td>{{empresa.nombre_comercial}}</td>
                                    <td>{{empresa.ruc}}</td>
                                    <td>{{empresa.razon_social}}</td>
                                    <td title="seleccionar empresa">
                                        <button type="button" @click.prevent="fnLoadObjects({empresa:empresa})" class="btn btn-warning btn-xs"><i class="fa fa-check"></i></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </component>
        <component :is="'cliente-list-modal'" v-if="showModal2">
            <div slot="modal-component">
                <div class="modal-header">
                    <button type="button" class="close" @click.prevent="fnOpenCloseModal(2)" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="form-inline">
                        <select v-model="selectedFiltroCliente" class="form-control">
                            <option value="" selected disabled>- Seleccionar Cliente -</option>
                            <option value="dni">dni</option>
                            <option value="nombre_apellido">nombre y apellido</option>
                        </select>
                        <input v-model="buscarCliente" type="text" class="form-control w-30" :placeholder="'Buscar por ' + selectedFiltroCliente"/>
                    </div>
                </div>
                <div v-if="loadModal2" class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center text-muted">
                                <i class="fa fa-circle-o-notch fa-spin fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else="" class="modal-body modal-scroll">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th width="2%"><input v-model="checkedClienteSelectedAll" type="checkbox" class="fa fa-fw"></th>
                                    <th>Apellidos y Nombres</th>
                                    <th>Dni</th>
                                    <th>Dirección</th>
                                    <th width="5%"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(cliente,index) in filteredClientes" v-bind:key="cliente.id">
                                    <td><input v-model="checkedClienteSelected" :value="cliente.id" :sector="cliente.id" type="checkbox"></td>
                                    <td>{{cliente.apellido_paterno}} {{cliente.apellido_materno}}, {{cliente.nombres}}
                                    </td>
                                    <td>{{cliente.dni}}</td>
                                    <td>{{cliente.direccion}}</td>
                                    <td title="seleccionar cliente">
                                        <button v-show="validateAddCliente" type="button" @click.prevent="fnLoadObjects({cliente:cliente})" class="btn btn-warning btn-xs"><i class="fa fa-check"></i></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" @click="fnOpenCloseModal(2)"><i class="fa fa-remove fa-fw"></i>Cancelar
                    </button>
                    <button v-show="!validateAddCliente" type="button" class="btn btn-warning" @click="fnLoadClienteIds"><i class="fa fa-check fa-fw"></i>Cargar Clientes
                    </button>
                </div>
            </div>
        </component>
    </section>
</template>
<script>
    /**
     * Created by aquispe on 06/11/2017.
     **/
    import Vue from 'vue';
    import Service from '../services/ComprobanteService';
    import DatePicker from 'vue2-datepicker';
    import Moment from 'moment';
    import Modal from '../components/Modal.lg.vue';
    import LoadingPage from '../components/LoadingPage.vue';

    Vue.component('loading-page', LoadingPage);
    Vue.component('date-picker', DatePicker);
    Vue.component('empresa-list-modal', Modal);
    Vue.component('cliente-list-modal', Modal);

    export default {
        data: () => ({
            // CONTROL
            moment: Moment,
            loadingPage: true,
            loadingTable: true,
            showModal: false,
            showModal2: false,
            loadModal: true,
            loadModal2: true,
            // DATABASE
            selectedFechaSearch: null,
            selectedFechaSearch2: null,
            checkedPagoAgua: "",
            checkedModificarPrecio: false,
            checkedDescripcion: false,
            selectedFiltroEmpresa: "",
            selectedActividad: "",
            selectedFiltroCliente: "",
            selectedTipoComprobante: "",
            buscarEmpresa: "",
            buscarCliente: "",
            actividades: [],
            empresas: [],
            clientes: [],
            actividad: {},
            empresa: {},
            cliente: {},
            empresaComprobante: [],
            validateEmpresaComprobante: false,
            clienteComprobante: [],
            validateClienteComprobante: false,
            // HTTP
            params: {
                id: null,
                id_usuario: [],
                id_actividad: null,
            },
            // INVOICE
            descripcion: "",
            precio_autosuma: "",
            items: [],
            item: {},
            subtotal: "0.00",
            igv: "0.00",
            total: "0.00",
            precio:"0.00",
            folio: "-",
            checkedClienteSelected: false,
            checkedClientes: [],
            validateAddCliente: true,
            validateClienteIds: false,
            auth:{
                remember_token:""
            },
        }),
        beforeCreate() {
            setTimeout(() => {
                this.loadingPage = !this.loadingPage;
                document.getElementById('alert_error').style.display = 'none';
                document.getElementById('alert_flash').style.display = 'none';
            }, 1000);
        },
        created() {
            Service.dispatch("allActividades", {self: this});
        },
        computed: {
            filteredClientes() {
                return this.clientes.filter(cliente => {
                    return cliente.nombres.toLowerCase().indexOf(this.buscarCliente.toLowerCase()) > -1
                })
            },
            checkedClienteSelectedAll: {
                get() {
                    this.checkedClienteSelected.length == 0 || this.checkedClienteSelected.length == undefined ? this.validateAddCliente = true : this.validateAddCliente = false;
                    return (this.filteredClientes ? this.checkedClienteSelected.length == this.filteredClientes.length : false);
                },
                set(value) {
                    let selected = [];
                    this.validateAddCliente = false;
                    if (value) {
                        this.filteredClientes.forEach((cliente) => {
                            selected.push(cliente.id);
                        });
                    } else {
                        this.validateAddCliente = true;
                    }
                    this.checkedClienteSelected = selected;
                }
            }
        },
        methods: {
            fnChangeTipoComprobante() {
                if (this.selectedTipoComprobante == "F") this.folio = "F001-12865";
                if (this.selectedTipoComprobante == "B") this.folio = "B001-12865";
            },
            fnOpenCloseModal(num) {
                switch (num) {
                    case 1:// Listar
                        if (this.showModal) {// Cerrar
                            document.getElementById('super-body').classList.remove("modal-open");
                            this.showModal = false;
                            this.loadModal = true;
                        } else {// Abrir
                            document.getElementById('super-body').classList.add("modal-open");
                            this.showModal = true;
                            Service.dispatch("allEmpresas", {self: this});
                        }
                        break;
                    case 2:// Listar
                        if (this.showModal2) {// Cerrar
                            document.getElementById('super-body').classList.remove("modal-open");
                            this.showModal2 = false;
                            this.loadModal2 = true;
                        } else {// Abrir
                            document.getElementById('super-body').classList.add("modal-open");
                            this.showModal2 = true;
                            Service.dispatch("allClientes", {self: this});
                        }
                        break;
                }
            },
            fnLoadObjects(objeto) {
                document.getElementById('super-body').classList.remove("modal-open");
                if (objeto.empresa != undefined) {
                    this.validateEmpresaComprobante = true;
                    this.empresaComprobante = objeto.empresa;
                    this.showModal = false;
                    this.loadModal = true;
                }
                if (objeto.cliente != undefined) {
                    this.validateClienteComprobante = true;
                    this.validateClienteIds = false;
                    this.clienteComprobante = objeto.cliente;
                    this.showModal2 = false;
                    this.loadModal2 = true;
                }
            },
            fnPushItem(objeto) {
                this.items.push(objeto);
                this.params.id_usuario.push(objeto.id);

                this.total = parseFloat(parseFloat(this.total) + parseFloat(objeto.valor)).toFixed(2);
                this.igv = parseFloat(parseFloat(this.total) * 0.18).toFixed(2);
                this.subtotal = parseFloat(parseFloat(this.total) - parseFloat(this.igv)).toFixed(2);
                // Limpiar
                this.selectedActividad = "";
                this.precio_autosuma = "";
                this.checkedModificarPrecio = false;
            },
            fnRemoveItem(objeto) {
                this.items.splice(objeto.index, 1);

                this.total = parseFloat(parseFloat(this.total) - parseFloat(objeto.valor)).toFixed(2);
                this.igv = parseFloat(parseFloat(this.total) * 0.18).toFixed(2);
                this.subtotal = parseFloat(parseFloat(this.total) - parseFloat(this.igv)).toFixed(2);
            },
            fnChangeActividad(objeto) {
                console.log(objeto);
                this.data_comprobante = objeto;
                this.precio = this.data_comprobante.valor;


                // Limpiar
                this.checkedModificarPrecio = false;
                this.precio_autosuma = "";
            },
            fnLoadClienteIds() {
                if (this.checkedClienteSelected.length > 0) {
                    document.getElementById('super-body').classList.remove("modal-open");
                    this.validateClienteComprobante = true;
                    this.validateClienteIds = true;
                    this.showModal2 = false;
                    this.loadModal2 = true;
                }
            },
            fnStore() {
                this.params.id_usuario = [4,5];
                this.params.id_actividad = 1;
                this.params.id_tipo_comprobante = 1;
                Service.dispatch("store", {self: this});
            },
            fnUpdate() {
                this.params.id = 3;
                this.params.id_actividad = 1;
                this.params.id_tipo_comprobante = 1;
                Service.dispatch("update", {self: this});
            },
        }
    }
</script>