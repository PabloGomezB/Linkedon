<template>
    <div class="mt-3">
        <b-row
            v-show="mostrarOfertas"
            align-v="stretch"
            v-if="resultadoOfertas.length != 0"
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
        <div v-else>
            <p>No se han encontrado ofertas.</p>
        </div>
        <div v-show="mostrarOfertas == false" class="text-center mt-5">
            <b-spinner label="Loading..."></b-spinner>
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
        mostrarOfertas: Boolean,
    },
};
</script>

<style></style>
