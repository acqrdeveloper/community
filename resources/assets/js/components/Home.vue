<template>
    <section>
        <div class="panel">
            <div class="panel-body">
                <div class="alert alert-info" v-for="n in 3">
                    <p>
                        <span>Hola Alex,</span><br>
                        <span>Bienvenido ahora eres parte de un usuario administrativo, tomate el tiempo para darle una revision al software que tiene preparado para ti.</span>
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
    /**
     * Created by aquispe on 04/11/2017.
     **/
    export default {
        data() {
            return {}
        },
        beforeCreate() {
        },
        created() {
        },
        computed: {},
        methods: {}
    }
</script>  
