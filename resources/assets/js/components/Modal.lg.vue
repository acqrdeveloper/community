<template>
    <transition name="modal">
        <div id="modal-dialog-dinamic" class="modal fade in" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <slot name="modal-component"></slot><!-- modal dinamico -->
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </transition>
</template>
<script>
    /**
     * Created by aquispe on 05/11/2017.
     **/
</script>