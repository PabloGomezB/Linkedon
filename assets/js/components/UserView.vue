<template>
    <div>
        <ListaOfertas></ListaOfertas>
        <OfertasByCategorias></OfertasByCategorias>
    </div>
</template>

<script>
import ListaOfertas from "./ListaOfertas";
import OfertasByCategorias from "./OfertasByCategorias";

export default {
    name: "UserView",
    components: {
        ListaOfertas,
        OfertasByCategorias,
    },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped></style>
