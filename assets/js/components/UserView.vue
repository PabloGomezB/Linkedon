<template>
    <div>
        <ListaOfertas></ListaOfertas>
        <OfertasByCategorias></OfertasByCategorias>
        <!-- <ChartOfertas></ChartOfertas> -->
    </div>
</template>

<script>
import ListaOfertas from "./ListaOfertas";
import OfertasByCategorias from "./OfertasByCategorias";
// import ChartOfertas from "./ChartOfertas";

export default {
    name: "UserView",
    components: {
        ListaOfertas,
        OfertasByCategorias,
        // ChartOfertas,
    },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped></style>
