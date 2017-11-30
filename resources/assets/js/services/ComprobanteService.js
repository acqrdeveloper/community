/**
 * Created by aquispe on 09/11/2017.
 **/

import Vue from 'vue';
import Vuex from 'vuex';
import Axios from 'axios';
import Util from '../util';

Vue.use(Vuex);
Axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const SERVICE = new Vuex.Store({
    state: {},
    mutations: {},
    actions: {
        allActividades({commit}, {self}) {

            Axios.get("/actividad-all", {params: self.params})
                .then((response) => {
                    if (response.data.load) {
                        self.actividades = response.data.data;
                        self.auth = response.data.auth;
                    }
                })
                .catch((error) => {
                    if (!error.response.data.load) {
                        switch (error.response.status) {
                            case 412:// Exception Laravel
                                Util.fnAlertFlash(error.response.data);
                                break;
                            default:// Request Laravel 401,422
                                Util.fnAlertError(error.response.data);
                                break;
                        }
                    }
                });

        },
        allEmpresas({commit}, {self}) {

            Axios.get("/empresa-all", {params: self.params})
                .then((response) => {
                    if (response.data.load) {
                        self.empresas = response.data.data;
                        self.loadModal = false;
                    }
                })
                .catch((error) => {
                    if (!error.response.data.load) {
                        switch (error.response.status) {
                            case 412:// Exception Laravel
                                Util.fnAlertFlash(error.response.data);
                                break;
                            default:// Request Laravel 401,422
                                Util.fnAlertError(error.response.data);
                                break;
                        }
                    }
                });
        },
        allClientes({commit}, {self}) {

            Axios.get("/cliente-all", {params: self.params})
                .then((response) => {
                    if (response.data.load) {
                        self.clientes = response.data.data;
                        self.loadModal2 = false;
                    }
                })
                .catch((error) => {
                    if (!error.response.data.load) {
                        switch (error.response.status) {
                            case 412:// Exception Laravel
                                Util.fnAlertFlash(error.response.data);
                                break;
                            default:// Request Laravel 401,422
                                Util.fnAlertError(error.response.data);
                                break;
                        }
                    }
                });
        },
        store({commit}, {self}) {

            Axios.post("/comprobante-store", self.params)
                .then((response) => {
                    if (response.data.load) {
                        alert(response.data.data);
                    }
                })
                .catch((error) => {
                    if (!error.response.data.load) {
                        switch (error.response.status) {
                            case 412:// Exception Laravel
                                Util.fnAlertFlash(error.response.data);
                                break;
                            default:// Request Laravel 401,422
                                Util.fnAlertError(error.response.data);
                                break;
                        }
                    }
                });
        },
        edit({commit}, {self}) {

            Axios.get("/comprobante-edit", {params: self.params})
                .then((response) => {
                    if (response.data.load) {
                        self.clientes = response.data.data;
                        self.loadModal2 = false;
                    }
                })
                .catch((error) => {
                    if (!error.response.data.load) {
                        switch (error.response.status) {
                            case 412:// Exception Laravel
                                Util.fnAlertFlash(error.response.data);
                                break;
                            default:// Request Laravel 401,422
                                Util.fnAlertError(error.response.data);
                                break;
                        }
                    }
                });
        },
        update({commit}, {self}) {

            Axios.put("/comprobante-update/" + self.params.id, self.params)
                .then((response) => {
                    if (response.data.load) {
                        alert(response.data.data);
                    }
                })
                .catch((error) => {
                    if (!error.response.data.load) {
                        switch (error.response.status) {
                            case 412:// Exception Laravel
                                Util.fnAlertFlash(error.response.data);
                                break;
                            default:// Request Laravel 401,422
                                Util.fnAlertError(error.response.data);
                                break;
                        }
                    }
                });
        },
        all({commit}, {self}) {

            Axios.get("/comprobante-all", {params: self.params})
                .then((response) => {
                    if (response.data.load) {
                        self.clientes = response.data.data;
                        self.loadModal2 = false;
                    }
                })
                .catch((error) => {
                    if (!error.response.data.load) {
                        switch (error.response.status) {
                            case 412:// Exception Laravel
                                Util.fnAlertFlash(error.response.data);
                                break;
                            default:// Request Laravel 401,422
                                Util.fnAlertError(error.response.data);
                                break;
                        }
                    }
                });
        },
        allByCliente({commit}, {self}) {

            Axios.get("/comrpobante-all-by-cliente", {params: self.params})
                .then((response) => {
                    if (response.data.load) {
                        self.clientes = response.data.data;
                        self.loadModal2 = false;
                    }
                })
                .catch((error) => {
                    if (!error.response.data.load) {
                        switch (error.response.status) {
                            case 412:// Exception Laravel
                                Util.fnAlertFlash(error.response.data);
                                break;
                            default:// Request Laravel 401,422
                                Util.fnAlertError(error.response.data);
                                break;
                        }
                    }
                });
        },

    }
});

export default SERVICE;