/**
 * Created by aquispe on 31/10/2017.
 */

import Vue from 'vue';
import Vuex from 'vuex';
import Axios from 'axios';
import Util from '../util';

Vue.use(Vuex);
Axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const SERVICE = new Vuex.Store({
        state: {
            util:Util,
        },
        mutations: {},
        actions: {
            load({commit}, {self}){

                Axios.get("/tablas-load")
                    .then((response) => {
                        if (response.data.load) {
                            self.combo_tablas = response.data.data;
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
            fetch({commit}, {self}) {

                Axios.get("/tablas-all", {params:self.params})
                    .then((response) => {
                        if (response.data.load) {
                            self.loadingTable = false;
                            self.tablas = response.data.data;
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
            update({commit}, {self}) {

                Axios.put("/tablas-update/" + self.params.tabla + "/" + self.params.id, self.newTabla)
                    .then((response) => {
                        if (response.data.load) {
                            this.dispatch("fetch", {self: self});
                            Util.fnAlertFlash(response.data);
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

                Axios.post("/tablas-store/"+self.params.tabla, self.newTabla)
                    .then((response) => {
                        if (response.data.load) {
                            this.dispatch("fetch", {self: self});
                            Util.fnAlertFlash(response.data);
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

            }
        }
    });

export default SERVICE;