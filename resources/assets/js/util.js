/**
 * Created by aquispe on 26/10/2017.
 */

import Vue from 'vue';

let util = {
    formatTimestamp: "YYYY-MM-DD HH:mm:ss",
    formatDate: "YYYY-MM-DD",
    combo_meses: [
        {id: 1, value: "enero"},
        {id: 2, value: "febrero"},
        {id: 3, value: "marzo"},
        {id: 4, value: "abril"},
        {id: 5, value: "mayo"},
        {id: 6, value: "junio"},
        {id: 7, value: "julio"},
        {id: 8, value: "agosto"},
        {id: 9, value: "setiembre"},
        {id: 10, value: "octubre"},
        {id: 11, value: "noviembre"},
        {id: 12, value: "diciembre"}],
    combo_estado_civil: [
        {id: "S", value: "soltero(a)"},
        {id: "C", value: "casado(a)"},
        {id: "V", value: "viudo(a)"},
        {id: "D", value: "divorciado(a)"}],
    combo_seguros: [
        {id: "1", value: "sis"},
        {id: "2", value: "rimac seguros"},
        {id: "3", value: "positiva seguros"},
        {id: "4", value: "afp habitat"},
    ],
    combo_estados: [
        {id: "A", value: "activo"},
        {id: "I", value: "inactivo"},
    ],
    fnAlertFlash(data) {
        $("body, html").animate({scrollTop: '0'}, 800);
        new Vue({
            el: '#alert_flash',
            template: ' <div id="alert_flash"><div class="row"> ' +

            '           <div v-if=" level == \'success\' " class="alert alert-success" style="position: relative;"> ' +
            '           <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
            '           <p class="h5 text-capitalize"> ' +
            '           <i class="fa fa-check fa-fw"></i><b>{{ title }}</b> </p> <p>{{ message }}</p> </div> ' +

            '           <div v-if=" level == \'danger\' " class="alert alert-danger" style="position: relative;"> ' +
            '           <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
            '           <p class="h5 text-capitalize"> ' +
            '           <i class="fa fa-exclamation-triangle fa-fw"></i><b>{{ title }}</b> </p> <p>{{ message }}</p> </div> ' +

            '           </div></div> ',
            data: () => ({
                title: data.title,
                message: data.message,
                level: data.level,
            }),
            created() {
                switch (this.level) {
                    case "success":
                        setTimeout(function () {
                            document.getElementById('alert_flash').style.display = 'none';
                        }, 1000);
                        break;
                    case "warning":
                        setTimeout(function () {
                            document.getElementById('alert_flash').style.display = 'none';
                        }, 60000);
                        break;
                    default:
                        setTimeout(function () {
                            document.getElementById('alert_flash').style.display = 'none';
                        }, 120000);
                        break;
                }
            }
        });
    },
    fnAlertError(data) {
        $("body, html").animate({scrollTop: '0'}, 800);
        let html = '<div id="alert_error"><div class="row"><div class="alert alert-danger"> <ul style="padding: 0.2em;">';
        $.each(data, function (k, v) {
            html += ' <li style="display: block;padding: 0.15em;"><i class="fa fa-times fa-fw" style="vertical-align: text-top;"></i>&nbsp;&nbsp;' + v + '</li>';
        });
        html += '</ul></div></div></div>';
        new Vue({
            el: '#alert_error',
            template: html,
        });
        setTimeout(function () {
            document.getElementById('alert_error').style.display = 'none';
        }, 60000);
    }
};

export default util;