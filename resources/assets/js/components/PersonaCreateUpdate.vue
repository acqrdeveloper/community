<template>
    <section>
        <!-- TEMPLATE -->
        <component :is="'loading-page'" v-if="loadingPage"></component>
        <!-- PAGE -->
        <div v-if="!loadingPage" class="row fade in">
            <form role="form" @submit.prevent="fnValidateCreateUpdate" enctype="multipart/form-data">
                <div class="panel">
                    <div class="panel-body">
                        <header>
                            <h3>
                                <span v-if="isPost">Nueva Persona</span>
                                <span v-else>Editar Persona</span>
                            </h3>
                            <hr>
                        </header>
                        <div class="form-inline">
                            <div class="pull-left">
                                <router-link :to="{name: 'personas'}" class="btn btn-success">
                                    <i class="fa fa-list fa-fw"></i>Lista
                                </router-link>
                            </div>
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary">
                                    <span v-if="isPost"><i class="fa fa-check fa-fw"></i>Crear</span>
                                    <span v-else><i class="fa fa-refresh fa-fw"></i>Actualizar</span>
                                </button>
                                <button type="reset" class="btn btn-danger"><i class="fa fa-remove fa-fw"></i>Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a title="general" href="#1" aria-controls="home" role="tab" data-toggle="tab">
                            <h5><span><i class="fa fa-user fa-fw"></i>General</span></h5></a>
                    </li>
                    <li role="presentation">
                        <a title="avanzada" href="#2" aria-controls="profile" role="tab" data-toggle="tab">
                            <h5><span><i class="fa fa-user-plus fa-fw"></i>Información Avanzada y Parentesco</span></h5>
                        </a>
                    </li>
                    <li role="presentation">
                        <a title="beneficios" href="#3" aria-controls="options" role="tab" data-toggle="tab">
                            <h5><span><i class="fa fa-plus-circle fa-fw"></i>Beneficios</span></h5></a>
                    </li>
                    <li role="presentation">
                        <a title="antecedentes" href="#4" aria-controls="the_image" role="tab" data-toggle="tab">
                            <h5><span><i class="fa fa-minus-circle fa-fw"></i>Antecedentes</span></h5></a>
                    </li>
                    <li role="presentation">
                        <a title="antecedentes" href="#5" aria-controls="the_image" role="tab" data-toggle="tab">
                            <h5><span><i class="fa fa-cogs fa-fw"></i>Información Empresa</span></h5></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="1">
                        <div class="panel nav-panel">
                            <div class="panel-body">
                                <div class="form-group">
                                    <header>
                                        <h4><i class="fa fa-angle-double-right fa-fw"></i>Información Persona</h4>
                                        <hr>
                                    </header>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="thumbnail">
                                                <img v-show="isPost && !imageSrc" src="/images/upload.png" alt="image" width="100%" height="100%" style="max-width: 129px;max-height: 129px;">
                                                <img v-show="isPost && imageSrc" :src="imageSrc" alt="image" width="100%" height="100%" style="max-width: 129px;max-height: 129px;">
                                                <img v-show="!isPost && !imageSrc" :src="'/images/users/'+ newPersona.imagen" width="100%" height="100%" style="max-width: 129px;max-height: 129px;">
                                                <img v-show="!isPost && imageSrc" :src="imageSrc" width="100%" height="100%" style="max-width: 129px;max-height: 129px;">
                                            </div>
                                            <input @change="previewThumbnail" type="file" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label class="control-label">Nombres</label>
                                            <p class="text-muted">Nombres completo.</p>
                                            <input @keyup="fnGenerateEmail" type="text" v-model="newPersona.nombres" class="form-control" required/>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Apellido Paterno</label>
                                                    <p class="text-muted">Apellido de paternidad.</p>
                                                    <input @keyup="fnGenerateEmail" type="text" v-model="newPersona.apellido_paterno" class="form-control" maxlength="50" required/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Apellido Materno</label>
                                                    <p class="text-muted">Apellido de maternidad.</p>
                                                    <input type="text" v-model="newPersona.apellido_materno" class="form-control" maxlength="50" required/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Dni</label>
                                            <p class="text-muted">Documento de Identidad.</p>
                                            <input @keyup="fnGeneratePwd(newPersona.dni);fnGenerateEmail();" type="text" v-model="newPersona.dni" class="form-control" maxlength="8" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">Fecha Nacimiento</label>
                                            <p class="text-muted">Dia.</p>
                                            <select @change="fnCalculateAge" class="form-control" v-model="newPersona.dia" required>
                                                <option value="" selected disabled>- seleccionar -</option>
                                                <option v-for=" n in 31 " :value="n">{{n}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">.</label>
                                            <p class="text-muted">Mes.</p>
                                            <select @change="fnCalculateAge" class="form-control" v-model="newPersona.mes" required>
                                                <option value="" selected disabled>- seleccionar -</option>
                                                <option v-for="x in combo_meses" :value="x.id">{{x.value}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">.</label>
                                            <p class="text-muted">Año.</p>
                                            <select @change="fnCalculateAge" class="form-control" v-model="newPersona.anio" required>
                                                <option value="" selected disabled>- seleccionar -</option>
                                                <option v-for="x in (moment().format('YYYY')-18)" v-if="x >= 1980" :value="x">{{x}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Edad</label>
                                            <p class="text-muted">Edad actual.</p>
                                            <input type="number" v-model="newPersona.edad" class="form-control" readonly maxlength="3" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Dirección / Lugar / Zona</label>
                                    <p class="text-muted">Ubicacion de hogar.</p>
                                    <input type="text" v-model="newPersona.direccion" class="form-control"/>
                                </div>
                                <div v-show="!isPost" class="form-group">
                                    <label class="control-label">Contraseña Usuario</label>
                                    <p class="text-muted">Contraseña desencriptada.</p>
                                    <div class="form-control">{{newPersona.decrypt}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Correo</label>
                                            <p class="text-muted">Correo.</p>
                                            <input type="email" v-model="newPersona.email" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">
                                                <input title="modificar contraseña." v-model="checkedPassword" type="checkbox" class="fa fa-fw">Contraseña
                                            </label>
                                            <p class="text-muted">Ingrese una contraseña válida.</p>
                                            <input v-if="!checkedPassword" type="password" readonly v-model="newPersona.password" class="form-control" maxlength="16" minlength="8">
                                            <input v-else="" type="password" v-model="newPersona.password" class="form-control" maxlength="16" minlength="8">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">.</label>
                                            <p class="text-muted">Confirmar contraseña.</p>
                                            <input v-if="!checkedPassword" type="password" readonly v-model="newPersona.confirm_password" class="form-control" maxlength="16" minlength="8">
                                            <input v-else="" type="password" v-model="newPersona.confirm_password" class="form-control" maxlength="16" minlength="8">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Estado Civil</label>
                                            <p class="text-muted">Estado civil.</p>
                                            <select class="form-control" v-model="newPersona.estado_civil">
                                                <option value="" selected disabled>- seleccionar -</option>
                                                <option v-for="x in combo_estado_civil" :value="x.id">{{x.value}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Sexo</label>
                                            <p class="text-muted">Seleccionar sexo.</p>
                                            <label class="control-label">
                                                <input value="M" type="radio" v-model="newPersona.sexo" class="fa fa-fw"/>Masculino
                                            </label>
                                            <label class="control-label">
                                                <input value="F" type="radio" v-model="newPersona.sexo" class="fa fa-fw"/>Femenino
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3" v-show="!isPost">
                                        <div class="form-group">
                                            <label class="control-label">Estado</label>
                                            <p class="text-muted">Estado.</p>
                                            <label class="control-label">
                                                <input value="A" type="radio" v-model="newPersona.estado" class="fa fa-fw"/>Activo
                                            </label>
                                            <label class="control-label">
                                                <input value="I" type="radio" v-model="newPersona.estado" class="fa fa-fw"/>Inactivo
                                            </label>
                                        </div>
                                    </div>
                                    <div v-if=" !isPost ? newEmpresa.estado == 'A' ? true : false : true "
                                         class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Empresa</label>
                                            <p class="text-muted">Crear empresa.</p>
                                            <label class="control-label">
                                                <input :disabled="isPost ? false : true " type="checkbox" v-model="newPersona.es_empresa" class="fa fa-fw"/>Habilitar Empresa
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div v-show="newPersona.es_empresa" class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <header>
                                                <br>
                                                <h4><i class="fa fa-angle-double-right fa-fw"></i>Información Empresa
                                                </h4>
                                                <hr>
                                            </header>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Nombre Comercial</label>
                                            <p>Escriba el nombre de la empresa.</p>
                                            <input v-model="newEmpresa.nombre_comercial" type="text" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Dirección Empresa</label>
                                            <p>Escriba la dirección de la empresa.</p>
                                            <input v-model="newEmpresa.direccion" type="text" class="form-control">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="control-label">Razon Social</label>
                                                <p>Escriba la razon social de la empresa.</p>
                                                <input v-model="newEmpresa.razon_social" type="text" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label">R.U.C / D.N.I</label>
                                                <p>Ingrese el RUC o el DNI.</p>
                                                <input v-model="newEmpresa.ruc" type="text" class="form-control" minlength="8" maxlength="11">
                                            </div>
                                            <div class="col-md-4" v-show="!isPost">
                                                <div class="form-group">
                                                    <label class="control-label">Estado</label>
                                                    <p class="text-muted">Estado.</p>
                                                    <label class="control-label">
                                                        <input value="A" type="radio" v-model="newEmpresa.estado" class="fa fa-fw"/>Activo
                                                    </label>
                                                    <label class="control-label">
                                                        <input value="I" type="radio" v-model="newEmpresa.estado" class="fa fa-fw"/>Inactivo
                                                    </label>
                                                </div>
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
                                    <header>
                                        <h4><i class="fa fa-angle-double-right fa-fw"></i>Parentesco Matrimonial</h4>
                                        <hr>
                                    </header>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">
                                        <input v-model="checkedPadre" type="checkbox" class="fa fa-fw" @change.prevent="(!checkedPadre) ? selectedPadre = [] : false">Conyuge
                                    </label>
                                    <p class="text-muted">Seleccionar.</p>
                                    <component :is="'multiselect'" v-if="checkedPadre" v-model="selectedPadre" tag-placeholder="Seleccionar conyugue" placeholder="Seleccionar conyugue" label="value" track-by="id" :options="objMales" :multiple="true" :taggable="true"></component>
                                </div>
                                <div class="form-group">
                                    <header>
                                        <br>
                                        <h4><i class="fa fa-angle-double-right fa-fw"></i>Parentesco Familiar</h4>
                                        <hr>
                                    </header>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">
                                        <input v-model="checkedHijo" type="checkbox" class="fa fa-fw" @change.prevent="(!checkedHijo) ? selectedHijo = [] : false">Hijo(s)
                                    </label>
                                    <p class="text-muted">Seleccionar.</p>
                                    <component :is="'multiselect'" v-if="checkedHijo " v-model="selectedHijo" tag-placeholder="Seleccionar hijo(s)" placeholder="Seleccionar hijo(s)" label="value" track-by="id" :options="objMales" :multiple="true" :taggable="true"></component>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="3">
                        <div class="panel nav-panel">
                            <div class="panel-body">
                                <header>
                                    <h4><i class="fa fa-angle-double-right fa-fw"></i>Beneficios Públicos y/o Privados
                                    </h4>
                                    <hr>
                                </header>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                <input v-model="checkedSegSalud" type="checkbox" class="fa fa-fw"/>Seguro de Salud
                                            </label>
                                            <p class="text-muted">Seleccionar.</p>
                                            <select v-if="checkedSegSalud" class="form-control">
                                                <option value="" disabled selected>- seleccionar -</option>
                                                <option v-for="x in combo_seguros" :value="x.id">{{ x.value }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                <input v-model="checkedSegVida" type="checkbox" class="fa fa-fw">Seguro de Vida
                                            </label>
                                            <p class="text-muted">Seleccionar.</p>
                                            <select v-if="checkedSegVida" class="form-control">
                                                <option value="" selected disabled>- seleccionar -</option>
                                                <option value="1">afp</option>
                                                <option value="2">onp</option>
                                                <option value="2">privado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="4">
                        <div class="panel nav-panel">
                            <div class="panel-body">
                                <header>
                                    <button class="btn btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus fa-fw"></i>Agregar Nuevo Caso</button>
                                    <hr>
                                </header>
                                <div class="alert">
                                    <header>
                                        <h5><label class="control-label">Historial - Casos de Correción</label></h5>
                                    </header>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="alert-default">
                                            <tr>
                                                <th><i class="fa fa-calendar fa-fw"></i>Fecha</th>
                                                <th><i class="fa fa-file fa-fw"></i>Descripción</th>
                                                <th><i class="fa fa-user fa-fw"></i>Redactor</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="n in 5">
                                                <td><a href="#" title="click para ver"><i class="fa fa-link fa-fw"></i>2017-10-31</a>
                                                </td>
                                                <td>Robo de celular.</td>
                                                <td>Sr. Alejandro tirado de Perez</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="alert ">
                                    <header>
                                        <h5><label class="control-label">Historial - Casos Graves</label></h5>
                                    </header>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="alert-warning">
                                            <tr>
                                                <th><i class="fa fa-calendar fa-fw"></i>Fecha</th>
                                                <th><i class="fa fa-file fa-fw"></i>Descripción</th>
                                                <th><i class="fa fa-user fa-fw"></i>Redactor</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>2017-10-31</td>
                                                <td>Robo de casas a mano armada.</td>
                                                <td>Sr. Alejandro tirado de Perez</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="alert ">
                                    <header>
                                        <h5><label class="control-label">Historial - Casos muy Graves</label></h5>
                                    </header>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="alert-danger">
                                            <tr>
                                                <th><i class="fa fa-calendar fa-fw"></i>Fecha</th>
                                                <th><i class="fa fa-file fa-fw"></i>Descripción</th>
                                                <th><i class="fa fa-user fa-fw"></i>Redactor</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>2017-10-31</td>
                                                <td>Muerte al compañero de la escuela.</td>
                                                <td>Sr. Alejandro tirado de Perez</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="5">
                        <div class="panel nav-panel">
                            <div class="panel-body">
                                //we working please wait
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- MODALS -->
    </section>
</template>
<script>
    /**
     * Created by aquispe on 04/11/2017.
     **/
    import Vue from 'vue';
    import Service from '../services/PersonaService';
    import Moment from 'moment';
    import LoadingPage from '../components/LoadingPage.vue';

    Vue.component('loading-page', LoadingPage);

    export default {
        data: () => ({
                // CONTROL
                moment: Moment,
                combo_meses: Service.state.util.combo_meses,
                combo_estado_civil: Service.state.util.combo_estado_civil,
                combo_seguros: Service.state.util.combo_seguros,
                loadingPage: true,
                isPost: true,
                // DATABASE
                tempPersona: {
                    nombres: "",
                    apellido_paterno: "",
                    apellido_materno: "",
                    edad: "",
                    dni: "",
                    dia: "",
                    mes: "",
                    anio: "",
                    direccion: "",
                    estado_civil: "",
                    email: "",
                    password: "",
                    confirm_password: "",
                    fecha_nacimiento: null,
                    imagen: null,
                    decrypt: "",
                    estado: "A",
                    sexo: "M",
                    es_empresa: false,
                },
                newPersona: {
                    nombres: "",
                    apellido_paterno: "",
                    apellido_materno: "",
                    edad: "",
                    dni: "",
                    dia: "",
                    mes: "",
                    anio: "",
                    direccion: "",
                    estado_civil: "",
                    email: "",
                    password: "",
                    confirm_password: "",
                    fecha_nacimiento: null,
                    imagen: null,
                    decrypt: "",
                    estado: "A",
                    sexo: "M",
                    es_empresa: false,
                },
                tempEmpresa: {
                    nombre_empresa: "",
                    razon_social: "",
                    ruc: "",
                    direccion_empresa: "",
                    estado: "A",
                },
                newEmpresa: {
                    nombre_comercial: "",
                    razon_social: "",
                    ruc: "",
                    direccion: "",
                    estado: "A",
                },
                id: null,
                imageSrc: null,
                fields: "nombres",
                objMales: [],
                checkedPassword: false,
                checkedHijo: false,
                checkedPadre: false,
                checkedSegSalud: false,
                checkedSegVida: false,
                selectedPadre: [],
                selectedHijo: [],
        }),
        beforeCreate() {},
        created() {
            // Hide
            document.getElementById('alert_error').style.display = 'none';
            document.getElementById('alert_flash').style.display = 'none';
            // Editar
            if (this.$route.params.id != undefined) {
                this.id = this.$route.params.id;
                this.newPersona = [];
                this.newEmpresa = [];
                Service.dispatch("edit", {self: this});
            } else {
                setTimeout(() => {this.loadingPage = !this.loadingPage;}, 1000);
            }
            Service.dispatch("filter", {self: this});
        },
        watch: {
            // Escuchar
            $route() {
                setTimeout(() => {this.loadingPage = !this.loadingPage;}, 1000);
                this.isPost = !this.isPost;
                this.newPersona = this.tempPersona;
                this.newEmpresa = this.tempEmpresa;
                this.loadingPage = !this.loadingPage;
            }
        },
        computed: {},
        methods: {
            fnStore() {
                // Crear
                Service.dispatch("store", {self: this});
            },
            fnEdit() {
                // Editar
                this.isPost = !this.isPost;
                this.newPersona.dia = this.moment(this.newPersona.fecha_nacimiento, "YYYY-MM-DD").format("D");
                this.newPersona.mes = this.moment(this.newPersona.fecha_nacimiento).month() + 1;
                this.newPersona.anio = this.moment(this.newPersona.fecha_nacimiento, "YYYY-MM-DD").format("YYYY");
            },
            fnUpdate() {
                // Actualizar
                this.id = this.$route.params.id;
                Service.dispatch("update", {self: this});
            },
            fnValidateCreateUpdate() {
                // Validar
                if (this.isPost) {
                    this.fnStore();
                } else {
                    this.fnUpdate();
                }
            },
            previewThumbnail(event) {
                // Selecionar
                let input = event.target;
                if (input.files && input.files[0]) {
                    let reader = new FileReader(), vm = this;
                    reader.onload = (e) => {
                        vm.newPersona.imagen = e.target.result;
                        vm.imageSrc = e.target.result;
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            },
            fnGeneratePwd(input) {
                // Generar
                this.newPersona.password = input;
                this.newPersona.confirm_password = input;
            },
            fnGenerateEmail() {
                // Generar
                this.newPersona.email = this.newPersona.nombres.charAt(0) + this.newPersona.apellido_paterno.split(" ")[0].trim() + this.newPersona.dni.trim() + "@gmail.com";
            },
            fnCalculateAge() {
                // Calcular
                if (this.newPersona.dia != "") {
                    if (this.newPersona.mes != "") {
                        if (this.newPersona.anio != "") {
                            let date_nac = this.moment([this.newPersona.anio, (this.newPersona.mes) - 1, this.newPersona.dia]);
                            this.newPersona.edad = this.moment().diff(date_nac, "years");
                        } else {
                            this.newPersona.edad = "";
                        }
                    }
                }
            }
        }
    }
</script>