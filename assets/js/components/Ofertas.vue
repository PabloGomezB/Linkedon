<template>
    <div class="mt-3">
        <b-row
            align-v="stretch"
            v-if="isOfertasObtenidas && resultadoOfertas.length != 0"
        >
            <!-- Hacemos un loop para las diferentes ofertas que hay en resultadoOfertas -->
            <!-- Pasamos la informacion de oferta y el usuario logged al componente -->
            <Oferta
                v-for="oferta in resultadoOfertas"
                :key="oferta.id"
                :oferta="oferta"
                :userLogged="userLogged"
            ></Oferta>
        </b-row>
        <div v-else-if="!isOfertasObtenidas" class="text-center mt-5">
            <b-spinner label="Loading..."></b-spinner>
        </div>
        <div v-else-if="resultadoOfertas.length == 0">
            <p>No se han encontrado ofertas.</p>
        </div>
    </div>
</template>

<script>
import Oferta from "./Oferta";

export default {
    name: "Ofertas",
    components: {
        Oferta,
    },
    props: {
        resultadoOfertas: Array,
        userLogged: Object,
        isOfertasObtenidas: Boolean,
    },
};
</script>

<style></style>
