<template>
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_1" data-toggle="tab">Categorías</a>
                    </li>
                    <li @click="opcionProducto = 1">
                        <a href="#tab_2" data-toggle="tab">Productos</a>
                    </li>
                </ul>

                <div class="tab-content">

                    <div class="tab-pane active" id="tab_1">
                        <Categoria :enlace="enlace" />
                    </div>

                    <div class="tab-pane" id="tab_2">
                        <Producto :enlace="enlace" v-if="opcionProducto" />
                    </div>

                </div>


            </div>
        </div>
    </div>
</template>

<script>
    import Categoria from './Categoria.vue';
    import Producto from './Producto.vue';
    export default {
        props: ['enlace'],
        components: { Categoria,Producto },
        data(){
            return {
                opcionProducto : 0
            }
        }

    }
</script>