<template>
    <section>
        <!-- TEMPLATE -->
        <component :is="'loading-page'" v-if="loadingPage"></component>
        <!-- PAGE -->
        <div v-if="!loadingPage" class="row fade in">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-10">
                            <label class="control-label">Usuario</label>
                            <p>Seleccionar usuario.</p>
                            <component :is="'multiselect'" v-model="selectedUsuario" selectedLabel="Seleccionado"
                                       deselectLabel="Remover" selectLabel="Seleccionar"
                                       tag-placeholder="- seleccionar -" placeholder="- seleccionar -" label="value"
                                       track-by="id"
                                       :options="[{id:1,value:'alex quispe'},{id:2,value:'deysi quispe'},{id:3,value:'diana quispe'}]"></component>
                        </div>
                        <div class="col-md-2">
                            <label>.</label>
                            <button class="btn btn-warning btn-block" type="button"><i class="fa fa-check fa-fw"></i>Aceptar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <form role="form">
                <div class="panel">
                    <div class="panel-body">
                        <header>
                            <h3>
                                <span>Nueva Empresa</span>
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
                                    <span><i class="fa fa-check fa-fw"></i>Crear</span>
                                </button>
                                <button type="reset" class="btn btn-danger"><i class="fa fa-remove fa-fw"></i>Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel">
                    <div class="panel-body">
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
                            <div class="col-md-6">
                                <label class="control-label">Razon Social</label>
                                <p>Escriba la razon social de la empresa.</p>
                                <input v-model="newEmpresa.razon_social" type="text" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">R.U.C | D.N.I</label>
                                <p>Ingrese el RUC o el DNI.</p>
                                <input v-model="newEmpresa.ruc" type="text" class="form-control" minlength="8"
                                       maxlength="11">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</template>
<script>
    /**
     * Created by aquispe on 19/11/2017.
     **/
    import Vue from 'vue';
    import Service from '../services/PersonaService';
    import LoadingPage from '../components/LoadingPage.vue';
    import Multiselect from 'vue-multiselect';

    Vue.component('multiselect', Multiselect);
    Vue.component('loading-page', LoadingPage);

    export default {
        data: () => ({
            loadingPage: true,
            isPost: true,
            selectedUsuario: null,
            newEmpresa: {},
        }),
        beforeCreate() {
            setTimeout(() => {
                this.loadingPage = !this.loadingPage;
            }, 1000);
        },
        created() {
        },
        computed: {},
        methods: {}
    }
</script>  
