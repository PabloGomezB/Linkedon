<template>
    <div>
        <OfertasByCategorias></OfertasByCategorias>
        <!-- <ChartOfertas></ChartOfertas> -->
    </div>
</template>

<script>
// import ListaOfertas from "./ListaOfertas";
import OfertasByCategorias from "./OfertasByCategorias";
// import ChartOfertas from "./ChartOfertas";

export default {
    name: "UserLoggedView",
    components: {
        OfertasByCategorias,
        // ChartOfertas,
    },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped></style>
