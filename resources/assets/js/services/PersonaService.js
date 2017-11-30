/**
 * Created by aquispe on 26/10/2017.
 */

import Vue from 'vue';
import Vuex from 'vuex';
import Axios from 'axios';
import Util from '../util';

Vue.use(Vuex);
Axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const SERVICE = new Vuex.Store({
    state: {
        util:Util
    },
    mutations: {},
    actions: {
        fetch({commit}, {self}) {

            Axios.get("/persona-all", {params: self.params})
                .then((response) => {
                    if (response.data.load) {
                        self.loadingTable = false;
                        self.personas = response.data.data.data;
                        self.pagination.total = response.data.data.total;
                        self.pagination.per_page = response.data.data.per_page;
                    }
                })
                .catch((error) => {
                    if (!error.response.data.load) {
                        switch (error.response.status) {
                            case 412:// Exception Laravel
                                Util.fnAlertFlash(error.response.data);
                            break;
                            default:// Request Laravel 401,422
                                Util.fnAlertError( error.response.data);
                                break;
                        }
                    }
                });

        },
        store({commit}, {self}) {

            Axios.post("/persona/store", $.extend(self.newPersona, {empresa: self.newEmpresa}))
                .then((response) => {
                    if (response.data.load) {
                        self.newPersona = self.tempPersona;
                        self.newEmpresa = self.tempEmpresa;
                        self.$router.replace('/personas');
                        Util.fnAlertFlash(response.data);
                    }
                })
                .catch((error) => {
                    if (!error.response.data.load) {
                        switch (error.response.status) {
                            case 412:// Exception Laravel
                                Util.fnAlertFlash( error.response.data);
                                break;
                            default:// Request Laravel 401,422
                                Util.fnAlertError( error.response.data);
                                break;
                        }
                    }
                })

        },
        edit({commit}, {self}) {

            Axios.get("/persona-edit/" + self.id)
                .then((response) => {
                    if (response.data.load) {
                        self.newPersona = {};
                        self.newEmpresa = {};
                        self.newPersona = response.data.data.persona;
                        if (response.data.data.empresa != undefined) {
                            self.newEmpresa = response.data.data.empresa;
                        }
                        self.loadingPage = false;
                        self.fnEdit();
                    }
                })
                .catch((error) => {
                    if (!error.response.data.load) {
                        switch (error.response.status) {
                            case 412:// Exception Laravel
                                Util.fnAlertFlash( error.response.data);
                                break;
                            default:// Request Laravel 401,422
                                Util.fnAlertError( error.response.data);
                                break;
                        }
                    }
                });

        },
        detail({commit}, {self}) {

            Axios.get("/persona-show/" + self.id)
                .then((response) => {
                    if (response.data.load) {
                        self.newPersona = {};
                        self.newEmpresa = {};
                        self.newPersona = response.data.data.persona;
                        if (response.data.data.empresa != undefined) {
                            self.newEmpresa = response.data.data.empresa;
                        }
                        self.loadingPage = false;
                        self.fnDetailPersona();
                    }
                })
                .catch((error) => {
                    if (!error.response.data.load) {
                        switch (error.response.status) {
                            case 412:// Exception Laravel
                                Util.fnAlertFlash( error.response.data);
                                break;
                            default:// Request Laravel 401,422
                                Util.fnAlertError( error.response.data);
                                break;
                        }
                    }
                });

        },
        update({commit}, {self}) {

            Axios.put("/persona-update/" + self.id, $.extend(self.newPersona, {empresa: self.newEmpresa}))
                .then((response) => {
                    if (response.data.load) {
                        self.$router.replace('/personas');
                        Util.fnAlertFlash( response.data);
                    }
                })
                .catch((error) => {
                    if (!error.response.data.load) {
                        switch (error.response.status) {
                            case 412:// Exception Laravel
                                Util.fnAlertFlash( error.response.data);
                                break;
                            default:// Request Laravel 401,422
                                Util.fnAlertError( error.response.data);
                                break;
                        }
                    }
                });

        },
        changeStatus({commit}, {self}) {

            Axios.put("/persona-change-status/" + self.params.id, {estado:self.params.estado})
                .then((response) => {
                    if (response.data.load) {
                        self.fnOpenCloseModal();
                        self.fnChange();
                        Util.fnAlertFlash( response.data);
                    }
                })
                .catch((error) => {
                    self.fnOpenCloseModal();
                    if (!error.response.data.load) {
                        switch (error.response.status) {
                            case 422:// Request Laravel
                                Util.fnAlertError( error.response.data);
                                break;
                            case 412:// Exception Laravel
                                Util.fnAlertFlash( error.response.data);
                                break;
                            case 401:// Request Laravel
                                Util.fnAlertError( error.response.data);
                                break;
                        }
                    }
                });

        },
        filter({commit}, {self}) {

            Axios.get("/persona-filter",{params:{}})
                .then((response) => {
                    if (response.data.load) {
                        self.objMales = response.data.data;
                    }
                })
                .catch((error) => {
                    if (!error.response.data.load) {
                        switch (error.response.status) {
                            case 412:// Exception Laravel
                                Util.fnAlertFlash( error.response.data);
                                break;
                            default:// Request Laravel 401,422
                                Util.fnAlertError( error.response.data);
                                break;
                        }
                    }
                });

        },
    }
});

export default SERVICE;